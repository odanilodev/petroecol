<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AfericaoTerceiros extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		//INICIO controle sessão
		$this->load->library('Controle_sessao');
		$res = $this->controle_sessao->controle();
		if ($res == 'erro') {
			if ($this->input->is_ajax_request()) {
				$this->output->set_status_header(403);
				exit();
			} else {
				redirect('login/erro', 'refresh');
			}
		}
		// FIM controle sessão

		$this->load->model('Afericao_model');
		$this->load->model('Coletas_model');

		$this->load->library('residuoChaveId');
	}

	public function index($page = 1)
	{
		$this->load->model('AfericaoTerceiros_model');
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para afericao
		$scriptsAfericaoHead = scriptsAfericaoTerceirosHead();
		$scriptsAfericaoFooter = scriptsAfericaoTerceirosFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsAfericaoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsAfericaoFooter));

		$this->load->helper('cookie');

		if ($this->input->post()) {
			$this->input->set_cookie('filtro_afericao_terceiros', json_encode($this->input->post()), 3600);
		}

		if (is_numeric($page)) {
			$cookie_filtro_afericao_terceiros = count($this->input->post()) > 0 ? json_encode($this->input->post()) : $this->input->cookie('filtro_afericao_terceiros');
		} else {
			$page = 1;
			delete_cookie('filtro_afericao_terceiros');
			$cookie_filtro_afericao_terceiros = json_encode([]);
		}

		$data['cookie_filtro_afericao_terceiros'] = json_decode($cookie_filtro_afericao_terceiros, true);

		// >>>> PAGINAÇÃO <<<<<
		$limit = 20; // Número de afericao por página
		$this->load->library('pagination');
		$config['base_url'] = base_url('afericaoTerceiros/index/');
		$config['total_rows'] = $this->AfericaoTerceiros_model->recebeAfericoesTerceiros($cookie_filtro_afericao_terceiros, $limit, $page, true); // true para contar
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
		$this->pagination->initialize($config);
		// >>>> FIM PAGINAÇÃO <<<<<

		$this->load->model('FinMacro_model');
		$data['macros'] = $this->FinMacro_model->recebeMacros();

		$this->load->model('FinFormaTransacao_model');
		$data['formasTransacoes'] = $this->FinFormaTransacao_model->recebeFormasTransacao();

		$this->load->model('FinContaBancaria_model');
		$data['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();

		$this->load->model('FinDadosFinanceiros_model');
		$data['dadosFinanceiro'] = $this->FinDadosFinanceiros_model->recebeDadosFinanceiros();

		$this->load->model('SetoresEmpresa_model');
		$data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

		$this->load->model('Residuos_model');
		$data['residuos'] = $this->Residuos_model->recebeResiduos();

		$this->load->model('UnidadesMedidas_model');
		$data['unidadesMedidas'] = $this->UnidadesMedidas_model->recebeUnidadesMedidas();

		$data['afericoes'] = $this->AfericaoTerceiros_model->recebeAfericoesTerceiros($cookie_filtro_afericao_terceiros, $limit, $page);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/afericao/terceiros');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function salvarAfericaoTerceiros()
	{
		$dadosPost = $this->input->post('dados'); // todos os inputs

		if ($dadosPost['conta_bancaria']) {

			$this->load->model('FinContaBancaria_model');
			$dadosContaBancaria = $this->FinContaBancaria_model->recebeSaldoBancario($dadosPost['conta_bancaria']);

			// verifica se tem saldo suficiente na conta bancaria
			if ($dadosContaBancaria['saldo'] < str_replace(['.', ','], ['', '.'], $dadosPost['valor'])) {
				$response = array(
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Saldo insuficiente para realizar o pagamento.",
					'type' => "error"
				);

				return $this->output->set_content_type('application/json')->set_output(json_encode($response));
			}
		}

		$this->load->model('Residuos_model');
		$this->load->model('AfericaoTerceiros_model');
		$this->load->model('ConversaoUnidadeMedida_model');
		$this->load->helper('converter_unidade_medida_residuo');

		$unidadeMedidaPadraoResiduo = $this->Residuos_model->recebeResiduo($dadosPost['residuo'])['id_unidade_medida'];

		// converte a quantidade do residuo que foi coletada para unidade de medida padrão
		$quantidade = $dadosPost['quantidade']; // quantidade digitada
		if ($unidadeMedidaPadraoResiduo != $dadosPost['unidade_medida']) {

			$dadosConversaoResiduo = $this->ConversaoUnidadeMedida_model->recebeConversaoPorResiduo($dadosPost['residuo'], $dadosPost['unidade_medida']);

			if ($dadosConversaoResiduo) {
				$quantidade = calcularUnidadeMedidaResiduo($dadosConversaoResiduo['valor'], $dadosConversaoResiduo['tipo_operacao'], $quantidade); // quantidade convertida
			}
		}

		// converte a quantidade aferida para a unidade de medida padrão do resíduo
		$quantidadeAferida = $dadosPost['quantidade_aferida']; // quantidade digitada
		if ($unidadeMedidaPadraoResiduo != $dadosPost['unidade_medida_aferida']) {

			$dadosConversaoResiduoAferida = $this->ConversaoUnidadeMedida_model->recebeConversaoPorResiduo($dadosPost['residuo'], $dadosPost['unidade_medida_aferida']);

			if ($dadosConversaoResiduoAferida) {
				$quantidadeAferida = calcularUnidadeMedidaResiduo($dadosConversaoResiduoAferida['valor'], $dadosConversaoResiduoAferida['tipo_operacao'], $quantidadeAferida); // quantidade convertida
			}
		}

		// dados para tabela ci_afericao_terceiros
		$dadosAfericaoTerceiros['id_fornecedor'] = $dadosPost['fornecedor'];
		$dadosAfericaoTerceiros['id_residuo'] = $dadosPost['residuo'];
		$dadosAfericaoTerceiros['quantidade_paga'] = number_format($quantidade, 3, '.', '');
		$dadosAfericaoTerceiros['id_unidade_medida_paga'] = $dadosPost['unidade_medida'];
		$dadosAfericaoTerceiros['gasto'] = str_replace(['.', ','], ['', '.'], $dadosPost['valor']);
		$dadosAfericaoTerceiros['id_setor_empresa'] = $dadosPost['setor'];
		$dadosAfericaoTerceiros['data_afericao'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['data_afericao'])));
		$dadosAfericaoTerceiros['id_empresa'] = $this->session->userdata('id_empresa');
		$dadosAfericaoTerceiros['id_unidade_medida_aferida'] = $dadosPost['unidade_medida_aferida'];
		$dadosAfericaoTerceiros['quantidade_aferida'] = number_format($quantidadeAferida, 3, '.', '');

		$retornoAfericaoTerceiros = $this->AfericaoTerceiros_model->insereAfericaoTerceiros($dadosAfericaoTerceiros);

		if ($retornoAfericaoTerceiros) {

			$this->load->model('EstoqueResiduos_model');
			$quantidadeTotalResiduo = $this->EstoqueResiduos_model->recebeTotalAtualEstoqueResiduo($dadosPost['residuo']);

			// dados para tabela de estoque
			$dadosResiduosEstoque['id_residuo'] = $dadosPost['residuo'];
			$dadosResiduosEstoque['id_setor_empresa'] = $dadosPost['setor'];
			$dadosResiduosEstoque['quantidade'] = number_format($quantidadeAferida, 3, '.', '');
			$dadosResiduosEstoque['id_unidade_medida'] = $unidadeMedidaPadraoResiduo;
			$dadosResiduosEstoque['tipo_movimentacao'] = 1; // entrada
			$dadosResiduosEstoque['id_empresa'] = $this->session->userdata('id_empresa');

			// soma o total do residuo de acordo com o ultimo total gravado
			$dadosResiduosEstoque['total_estoque_residuo'] = ($quantidadeTotalResiduo['total_estoque_residuo'] ?? 0) + $dadosResiduosEstoque['quantidade'];
			$dadosResiduosEstoque['total_estoque_residuo'] = number_format($dadosResiduosEstoque['total_estoque_residuo'], 3, '.', '');
			$dadosResiduosEstoque['origem_movimentacao'] = 'Lançamento aferição de terceiros';

			$this->EstoqueResiduos_model->insereEstoqueResiduos($dadosResiduosEstoque);
		}

		// grava em contas a pagar caso clique para agendar pagamento
		if (!$dadosPost['conta_bancaria']) {
			$this->load->model('FinContasPagar_model');
			$dadosContasPagar['valor'] = str_replace(['.', ','], ['', '.'], $dadosPost['valor']);
			$dadosContasPagar['id_dado_financeiro'] = $dadosPost['fornecedor'];
			$dadosContasPagar['id_macro'] = $dadosPost['macro'];
			$dadosContasPagar['id_micro'] = $dadosPost['micro'];
			$dadosContasPagar['id_empresa'] = $this->session->userdata('id_empresa');
			$dadosContasPagar['id_setor_empresa'] = $dadosPost['setor'];
			$dadosContasPagar['status'] = 0; // em aberto 
			$dadosContasPagar['data_vencimento'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['data_afericao'])));
			$retornoContasPagar = $this->FinContasPagar_model->insereConta($dadosContasPagar);

			if ($retornoContasPagar) {
				$response = array(
					'success' => true,
					'title' => "Sucesso!",
					'message' => "Aferição de terceiros concluída com sucesso!",
					'type' => "success"
				);
			} else {
				$response = array(
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Ocorreu um erro ao agendar o pagamento, tente novamente!",
					'type' => "error"
				);
			}
			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		// atualiza saldo bancario
		if ($dadosPost['conta_bancaria']) {
			$this->load->model('FinSaldoBancario_model');
			$saldoContaBancaria = $this->FinSaldoBancario_model->recebeSaldoBancario($dadosPost['conta_bancaria'])['saldo'];
			$novoSaldoBancario = $saldoContaBancaria - str_replace(['.', ','], ['', '.'], $dadosPost['valor']);
			$retornoSaldoBancario = $this->FinSaldoBancario_model->atualizaSaldoBancario($dadosPost['conta_bancaria'], $novoSaldoBancario);
		}

		if (isset($retornoSaldoBancario)) {

			// dados para fluxo de caixa
			$this->load->model('FinFluxo_model');
			$dadosFluxo['id_conta_bancaria'] = $dadosPost['conta_bancaria'];
			$dadosFluxo['id_dado_financeiro'] = $dadosPost['fornecedor'];
			$dadosFluxo['id_empresa'] = $this->session->userdata('id_empresa');
			$dadosFluxo['id_forma_transacao'] = $dadosPost['forma_pagamento'];
			$dadosFluxo['id_setor_empresa'] = $dadosPost['setor'];
			$dadosFluxo['id_macro'] = $dadosPost['macro'];
			$dadosFluxo['id_micro'] = $dadosPost['micro'];
			$dadosFluxo['valor'] = str_replace(['.', ','], ['', '.'], $dadosPost['valor']);
			$dadosFluxo['movimentacao_tabela'] = 0; // saída do fluxo
			$dadosFluxo['data_movimentacao'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['data_afericao'])));

			$retornoFluxo = $this->FinFluxo_model->insereFluxo($dadosFluxo);

			if ($retornoFluxo) {
				$response = array(
					'success' => true,
					'title' => "Sucesso!",
					'message' => "Aferição de terceiros concluída com sucesso!",
					'type' => "success"
				);
			} else {
				$response = array(
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Ocorreu um erro ao finalizar a aferição, tente novamente!",
					'type' => "error"
				);
			}

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
}

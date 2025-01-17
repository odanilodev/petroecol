<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendas extends CI_Controller
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

		$this->load->model('Vendas_model');
	}

	public function residuos($page = 1)
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para vendas
		$scriptsVendasFooter = scriptsVendasFooter();
		$scriptsVendasHead = scriptsVendasHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsVendasHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsVendasFooter));

		// >>>> PAGINAÇÃO <<<<<
		$limit = 12; // Número de recipientes por página
		$this->load->library('pagination');
		$config['base_url'] = base_url('recipientes/index');
		$config['total_rows'] = $this->Vendas_model->recebeVendasResiduos($limit, $page, true); // true para contar
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
		$this->pagination->initialize($config);
		// >>>> FIM PAGINAÇÃO <<<<<

		// Setores Empresa 
		$this->load->model('SetoresEmpresa_model');
		$data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

		$data['vendasResiduos'] = $this->Vendas_model->recebeVendasResiduos($limit, $page);

		$this->load->model('UnidadesMedidas_model');
		$data['unidades_medidas'] = $this->UnidadesMedidas_model->recebeUnidadesMedidas();

		$this->load->model('Clientes_model');
		$data['clientes_finais'] = $this->Clientes_model->recebeClientesFinais();

		$this->load->model('Residuos_model');
		$data['residuos'] = $this->Residuos_model->recebeTodosResiduos();

		$this->load->model('FinMacro_model');
		$data['macros'] = $this->FinMacro_model->recebeMacros();

		$this->load->model('FinFormaTransacao_model');
		$data['formasTransacoes'] = $this->FinFormaTransacao_model->recebeFormasTransacao();

		$this->load->model('FinContaBancaria_model');
		$data['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/vendas/vendas-residuos');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function novaVendaResiduo()
	{
		$this->load->model('EstoqueResiduos_model');
		$this->load->model('Residuos_model');

		// Dados para tabela de vendas
		$dados['id_cliente'] = $this->input->post('cliente');
		$dados['id_residuo'] = $this->input->post('residuo');
		$dados['quantidade'] = $this->input->post('quantidade');
		$dados['id_unidade_medida'] = $this->input->post('unidadeMedida');
		$dados['id_setor_empresa'] = $this->input->post('setorEmpresa');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');
		$dados['porcentagem_desconto'] = $this->input->post('porcentagemDescontoVenda');
		$dados['valor_unidade_medida'] = str_replace(['.', ','], ['', '.'], $this->input->post('valorUnidadeMedida'));
		$dados['valor_total'] = 0; // vai somar o tatal no looping de parcelas
		$dados['data_venda'] = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('dataDestinacao')[0])));

		$unidadeMedidaPadraoResiduo = $this->Residuos_model->recebeResiduo($dados['id_residuo'])['id_unidade_medida'];

		// faz a conversão de quantidade caso o a unidade de medida seja diferente da padrão do resíduo
		$quantidadeResiduo = $dados['quantidade'];
		if ($unidadeMedidaPadraoResiduo != $dados['id_unidade_medida']) {
			$this->load->model('ConversaoUnidadeMedida_model');
			$this->load->helper('converter_unidade_medida_residuo');
			$dadosConversaoResiduo = $this->ConversaoUnidadeMedida_model->recebeConversaoPorResiduo($dados['id_residuo'], $dados['id_unidade_medida']);
			if ($dadosConversaoResiduo) {
				$quantidadeResiduo = calcularUnidadeMedidaResiduo($dadosConversaoResiduo['valor'], $dadosConversaoResiduo['tipo_operacao'], $dados['quantidade']); // quantidade convertida
			}
		}

		$quantidadeTotalResiduo = $this->EstoqueResiduos_model->recebeTotalAtualEstoqueResiduo($dados['id_residuo']);

		// verifica se tem a quantidade desejada para realizar a venda
		if (!isset($quantidadeTotalResiduo['total_estoque_residuo']) || $quantidadeTotalResiduo['total_estoque_residuo'] < $quantidadeResiduo) {
			$response = array(
				'success' => false,
				'type' => 'error',
				'title' => 'Algo deu errado!',
				'message' => 'Não há essa quantidade de resíduo no estoque!'
			);
			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		// integra com o financeiro (contas a receber)
		if (!$this->input->post('contaBancaria') || $this->input->post('contaBancaria') == null) {
			$this->load->model('FinContasReceber_model');
			$valorVenda = str_replace(['.', ','], ['', '.'], $this->input->post('valorVenda'));
			$parcelas = $this->input->post('parcelas');
			$dataVenda = $this->input->post('dataDestinacao');

			$idPrimeiraParcela = null;
			for ($i = 0; $i < $parcelas; $i++) {

				$dados['valor_total'] += $valorVenda[$i]; // soma o valor total da venda

				$dadosContasReceber['id_setor_empresa'] = $dados['id_setor_empresa'];
				$dadosContasReceber['id_empresa'] = $dados['id_empresa'];
				$dadosContasReceber['valor'] = $valorVenda[$i];
				$dadosContasReceber['id_cliente'] = $dados['id_cliente'];
				$dadosContasReceber['id_macro'] = $this->input->post('macro');
				$dadosContasReceber['id_micro'] = $this->input->post('micro');
				$dadosContasReceber['data_vencimento'] = date('Y-m-d', strtotime(str_replace('/', '-',$dataVenda[$i])));
				$dadosContasReceber['numero_parcela'] = $parcelas > 1 ? $i + 1 . '/' . $parcelas : '';
				$dadosContasReceber['id_primeira_parcela'] = $i > 0 ? $idPrimeiraParcela : null;

				$idContaInserida = $this->FinContasReceber_model->insereContasReceber($dadosContasReceber);

				if ($i == 0) {
					$idPrimeiraParcela = $idContaInserida;
				}
			}

		} else {
			// atualiza saldo bancário
			$valorTotal = str_replace(['.', ','], ['', '.'], $this->input->post('valorVenda'));
			$dataVenda = $this->input->post('dataDestinacao');

			
			$this->load->model('FinSaldoBancario_model');
			$idContaBancaria = $this->input->post('contaBancaria');
			$saldoAtual = $this->FinSaldoBancario_model->recebeSaldoBancario($idContaBancaria);
			$novoSaldo = $saldoAtual['saldo'] + $valorTotal[0];
			$this->FinSaldoBancario_model->atualizaSaldoBancario($idContaBancaria, $novoSaldo);

			// manda pro fluxo de caixa como entrada
			$dadosFluxo['id_setor_empresa'] = $dados['id_setor_empresa'];
			$dadosFluxo['id_empresa'] = $dados['id_empresa'];
			$dadosFluxo['valor'] = $valorTotal[0];
			$dadosFluxo['id_cliente'] = $dados['id_cliente'];
			$dadosFluxo['id_macro'] = $this->input->post('macro');
			$dadosFluxo['id_micro'] = $this->input->post('micro');
			$dadosFluxo['data_movimentacao'] = date('Y-m-d', strtotime(str_replace('/', '-',$dataVenda[0])));
			$dadosFluxo['id_conta_bancaria'] = $this->input->post('contaBancaria');
			$dadosFluxo['id_forma_transacao'] = $this->input->post('formaRecebimento');
			$dadosFluxo['movimentacao_tabela'] = 1; // entrada

			$this->load->model('FinFluxo_model');
			$this->FinFluxo_model->insereFluxo($dadosFluxo);

			$dados['valor_total'] = $valorTotal[0];
		}

		$retorno = $this->Vendas_model->insereNovaVendaResiduo($dados);

		// dados para tabela de estoque
		$dadosResiduosEstoque['id_residuo'] = $dados['id_residuo'];
		$dadosResiduosEstoque['quantidade'] = number_format($quantidadeResiduo, 3, '.', '');;
		$dadosResiduosEstoque['id_unidade_medida'] = $unidadeMedidaPadraoResiduo;
		$dadosResiduosEstoque['tipo_movimentacao'] = 0; // saída
		$dadosResiduosEstoque['id_empresa'] = $dados['id_empresa'];
		$dadosResiduosEstoque['id_setor_empresa'] = $dados['id_setor_empresa'];
		$dadosResiduosEstoque['origem_movimentacao'] = 'Venda de resíduo';


		// subtrai o total do residuo de acordo com o ultimo total gravado
		$dadosResiduosEstoque['total_estoque_residuo'] = $quantidadeTotalResiduo['total_estoque_residuo'] - $dadosResiduosEstoque['quantidade'];
		$dadosResiduosEstoque['total_estoque_residuo'] = number_format($dadosResiduosEstoque['total_estoque_residuo'], 3, '.', '');
		$this->EstoqueResiduos_model->insereEstoqueResiduos($dadosResiduosEstoque);


		if ($retorno) {

			$response = array(
				'success' => true,
				'type' => 'success',
				'title' => 'Sucesso!',
				'message' => 'Venda realizada com sucesso!'
			);
		} else {

			$response = array(
				'success' => false,
				'type' => 'error',
				'title' => 'Algo deu errado!',
				'message' => "Erro ao realizar a venda!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletaVendaResiduo()
	{
		$idVenda = $this->input->post('idVenda');


		$retorno = $this->Vendas_model->deletaVendaResiduo($idVenda);

		if ($retorno) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Venda deletada com sucesso!",
				'type' => "success"
			);
		} else {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possivel deletar a venda!",
				'type' => "error"
			);
		}


		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

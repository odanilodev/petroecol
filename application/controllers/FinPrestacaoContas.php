<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinPrestacaoContas extends CI_Controller
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

		$this->load->model('FinPrestacaoContas_model');
		$this->load->model('Funcionarios_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// Scripts para Prestação de Contas
		$scriptsPrestacaoContasHead = scriptsFinPrestacaoContasHead();
		$scriptsPrestacaoContasFooter = scriptsFinPrestacaoContasFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsPrestacaoContasHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsPrestacaoContasFooter));

		$data['prestacaoContas'] = $this->Funcionarios_model->recebeFuncionariosSaldos();

		$this->load->model('FinTiposCustos_model');
		$data['tiposCustos'] = $this->FinTiposCustos_model->recebeTiposCustos();

		$this->load->model('FinMacro_model');
		$data['macros'] = $this->FinMacro_model->recebeMacros();

		$this->load->model('FinFormaTransacao_model');
		$this->load->model('FinContaBancaria_model');

		$data['formasTransacao'] = $this->FinFormaTransacao_model->recebeFormasTransacao();
		$data['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/prestacao-contas');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraPrestacaoContas()
	{
		$idFuncionario = $this->input->post('idFuncionario');
		$codRomaneio = $this->input->post('codigoRomaneio');
		$idSetorEmpresa = $this->input->post('idSetorEmpresa');

		$prestarContas = true;

		// dados prestação de contas
		$dadosPrestacaoContas = $this->input->post('dadosPrestacaoContas');

		if (empty($dadosPrestacaoContas['valor'][0])) {

			$prestarContas = false;
		} 

		$valorTotal = 0;
		$success = true;

		if ($prestarContas) {

			$tiposCustos = $dadosPrestacaoContas['idTipoCusto'];
			$valores = $dadosPrestacaoContas['valor'];
			$recebido = $dadosPrestacaoContas['idRecebido'];
			$tipoPagamento = $dadosPrestacaoContas['tipoPagamento'];
			$dataPagamento = $dadosPrestacaoContas['dataPagamento'];
			$macros = $dadosPrestacaoContas['macros'];
			$micros = $dadosPrestacaoContas['micros'];

			for ($i = 0; $i < count($tiposCustos); $i++) {

				// valor que o funcionario gastou na rua do bolso dele (pagamento no ato)
				if (!$tipoPagamento[$i]) {
					$dados['id_tipo_custo'] = $tiposCustos[$i];
					$dados['valor'] = str_replace(['.', ','], ['', '.'], $valores[$i]); // valor para tabela prestacao
					$dados['id_recebido'] = $recebido[$i];
					$dados['tipo_pagamento'] = $tipoPagamento[$i];
					$dados['id_empresa'] = $this->session->userdata('id_empresa');
					$dados['id_funcionario'] = $idFuncionario;
					$dados['codigo_romaneio'] = $codRomaneio;
					$dados['id_setor_empresa'] = $idSetorEmpresa;

					$valorTotal += floatval($dados['valor']); // valor total que o funcionario gastou

				} else {
					$dados['id_tipo_custo'] = $tiposCustos[$i];
					$dados['valor'] = str_replace(['.', ','], ['', '.'], $valores[$i]); // valor para tabela prestacao
					$dados['id_recebido'] = $recebido[$i];
					$dados['tipo_pagamento'] = $tipoPagamento[$i];

					$contasPagar['data_vencimento'] = date('Y-m-d', strtotime(str_replace('/', '-', $dataPagamento[$i])));
					$contasPagar['valor'] = str_replace(['.', ','], ['', '.'], $valores[$i]);
					$contasPagar['id_funcionario'] = $idFuncionario;
					$contasPagar['id_empresa'] = $this->session->userdata('id_empresa');
					$contasPagar['id_dado_financeiro'] = $recebido[$i];
					$contasPagar['id_micro'] = $micros[$i];
					$contasPagar['id_macro'] = $macros[$i];
					$contasPagar['id_setor_empresa'] = $idSetorEmpresa;
					$contasPagar['observacao'] = "Romaneio: $codRomaneio";
					$this->load->model('FinContasPagar_model');

					$this->FinContasPagar_model->insereConta($contasPagar);
				}

				$retorno = $this->FinPrestacaoContas_model->inserePrestacaoContas($dados);
				if (!$retorno) {
					$success = false;
					break;
				}
			}
		}

		// atualiza o saldo do funcionario
		$dadosTroco = $this->input->post('dadosTroco');

		$valorDevolvido = str_replace(['.', ','], ['', '.'], $dadosTroco['valor']);

		$saldoAtualFuncionario = $this->Funcionarios_model->recebeFuncionario($idFuncionario);

		$dadosFuncionario['saldo'] = $saldoAtualFuncionario['saldo'] - (floatval($valorDevolvido) + $valorTotal);

		$this->Funcionarios_model->editaFuncionario($idFuncionario, $dadosFuncionario);

		//dados para inserir movimentação no fluxo (troco do funcionario)
		if ($dadosTroco['valor'] && $success && $prestarContas) {

			$retorno = $this->insereMovimentacaoPrestacaoFluxo($dadosTroco, $idFuncionario, $idSetorEmpresa);
		}

		// Atualiza o romaneio para saber que já prestou conta
		$this->load->model('Romaneios_model');
		$dadosRomaneios['prestar_conta'] = 1;
		$this->Romaneios_model->editaRomaneioCodigo($codRomaneio, $dadosRomaneios);


		if ($success) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Prestação de contas cadastrada com sucesso!",
				'type' => "success"
			);
		} else {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Falha ao cadastrar prestação de contas. Por favor, tente novamente.",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	function insereMovimentacaoPrestacaoFluxo($dados, $idFuncionario, $idSetorEmpresa)
	{

		$valor = str_replace(['.', ','], ['', '.'], $dados['valor']);

		$dadosFluxo['id_macro'] = 11;
		$dadosFluxo['id_micro'] = 1;
		$dadosFluxo['id_setor_empresa'] = $idSetorEmpresa;
		$dadosFluxo['id_conta_bancaria'] = $dados['contaBancaria'];
		$dadosFluxo['id_forma_transacao'] = $dados['formaPagamentoTroco'];
		$dadosFluxo['id_funcionario'] = $idFuncionario;
		$dadosFluxo['valor'] = $valor;
		$dadosFluxo['id_empresa'] = $this->session->userdata('id_empresa');
		$dadosFluxo['data_movimentacao'] = date('Y-m-d');
		$dadosFluxo['movimentacao_tabela'] = 1; // sempre entrada

		$this->load->model('FinFluxo_model');

		$retorno = $this->FinFluxo_model->insereFluxo($dadosFluxo);

		return $retorno;
	}


	public function recebeDatasRomaneiosFuncionario()
	{
		$idFuncionario = $this->input->post('idFuncionario');
		$dataRomaneio = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('dataRomaneio'))));

		$this->load->model('Romaneios_model');

		$prestacaoContasFuncionario = $this->Romaneios_model->recebeDatasRomaneiosFuncionario($idFuncionario, $dataRomaneio);

		return $this->output->set_content_type('application/json')->set_output(json_encode($prestacaoContasFuncionario));
	}
}

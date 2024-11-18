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
				$dados['id_tipo_custo'] = $tiposCustos[$i];
				$dados['valor'] = str_replace(['.', ','], ['', '.'], $valores[$i]); // valor para tabela prestacao
				$dados['id_recebido'] = $recebido[$i];
				$dados['tipo_pagamento'] = $tipoPagamento[$i];
				$dados['id_empresa'] = $this->session->userdata('id_empresa');
				$dados['id_funcionario'] = $idFuncionario;
				$dados['codigo_romaneio'] = $codRomaneio;
				$dados['id_setor_empresa'] = $idSetorEmpresa;

				if (!$tipoPagamento[$i]) {

					$valorTotal += floatval($dados['valor']); // valor total que o funcionario gastou

				} else {

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
		if ($dadosTroco['valor'] && $success) {

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
		$this->load->model('FinMicro_model');

        $microPadraoRomaneio = $this->FinMicro_model->recebePadraoMicro('troco-funcionario');

		$valor = str_replace(['.', ','], ['', '.'], $dados['valor']);

		$dadosFluxo['id_macro'] = $microPadraoRomaneio['id_macro'];
		$dadosFluxo['id_micro'] = $microPadraoRomaneio['id'];
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

	public function visualizarPrestacaoContas()
	{
		$codRomaneio = $this->input->post('codRomaneio');

		$retorno = $this->FinPrestacaoContas_model->recebeCustosPrestacaoContasRomaneio($codRomaneio);

		$valorTotalCustos = $this->FinPrestacaoContas_model->recebeCustoTotalPrestacaoContasRomaneio($codRomaneio);


		if ($retorno) {

			$response = array(
				'valorTotal' => $valorTotalCustos,
				'custos' => $retorno,
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));

		} else {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Falha ao exibir os custos deste romaneio. Por favor, tente novamente.",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	function verificaPrestacaoContasFuncionario()
	{
		$codRomaneio = $this->input->post('codRomaneio');
		$idResponsavel = $this->input->post('idResponsavel');
		$dataRomaneio = $this->input->post('dataRomaneio');

		$response = $this->FinPrestacaoContas_model->recebeRomaneiosSemPrestarContasResponsavel($codRomaneio, $idResponsavel, $dataRomaneio);
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));

	}
}

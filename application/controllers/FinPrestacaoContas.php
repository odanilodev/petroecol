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
		$tiposCustos = $this->input->post('tiposCustos');
		$valores = $this->input->post('valores');
		$idFuncionario = $this->input->post('idFuncionario');
		$dataRomaneio = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('dataRomaneio'))));

		$success = true;
		$valorTotal = 0;
		for ($i = 0; $i < count($tiposCustos); $i++) {
			$dados['id_tipo_custo'] = $tiposCustos[$i];
			$dados['valor'] = str_replace(['.', ','], ['', '.'], $valores[$i]);
			$dados['id_funcionario'] = $idFuncionario;
			$dados['data_romaneio'] = $dataRomaneio;
			$dados['id_empresa'] = $this->session->userdata('id_empresa');

			$valorTotal += floatval($dados['valor']);

			$retorno = $this->FinPrestacaoContas_model->inserePrestacaoContas($dados);
			if (!$retorno) {
				$success = false;
				break; 
			}
		}
		// atualiza o saldo do funcionario
		$valorDevolvido = str_replace(['.', ','], ['', '.'], $this->input->post('valorDevolvido'));

		$saldoAtualFuncionario = $this->Funcionarios_model->recebeFuncionario($idFuncionario);

		$dadosFuncionario['saldo'] = $saldoAtualFuncionario['saldo'] - (floatval($valorDevolvido) + $valorTotal);

		$this->Funcionarios_model->editaFuncionario($idFuncionario, $dadosFuncionario);

		//dados para inserir movimentação no fluxo
		$dadosFluxo['id_macro'] = $this->input->post('macro');
		$dadosFluxo['id_micro'] = $this->input->post('micro');
		$dadosFluxo['id_conta_bancaria'] = $this->input->post('contaBancaria');
		$dadosFluxo['id_forma_transacao'] = $this->input->post('formaPagamento');
		$dadosFluxo['id_funcionario'] = $idFuncionario;
		$dadosFluxo['valor'] = $this->input->post('valorDevolvido');
		$dadosFluxo['id_empresa'] = $this->session->userdata('id_empresa');
		$dadosFluxo['data_movimentacao'] = date('Y-m-d');
		$dadosFluxo['movimentacao_tabela'] = 1; // sempre entrada


		if ($dadosFluxo['valor']) {

			$this->load->model('FinFluxo_model');

			$this->FinFluxo_model->insereFluxo($dadosFluxo);
		}


		if ($success) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Prestação de contas realizada com sucesso!",
				'type' => "success"
			);
		} else {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Falha ao realizar a prestação de contas. Por favor, tente novamente.",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
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

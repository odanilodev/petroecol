<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinContasRecorrentes extends CI_Controller
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
		$this->load->model('FinDadosFinanceiros_model');
		$this->load->model('FinContasRecorrentes_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// Scripts para contas recorrentes
		$scriptsContasRecorrentesHead = scriptsFinContasRecorrentesHead();
		$scriptsContasRecorrentesFooter = scriptsFinContasRecorrentesFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsContasRecorrentesHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsContasRecorrentesFooter));

		$this->load->model('FinMacro_model');
		$data['macros'] = $this->FinMacro_model->recebeMacros();

		$this->load->model('FinGrupos_model');
		$data['grupos'] = $this->FinGrupos_model->recebeGrupos();
		$data['dadosFinanceiro'] = $this->FinDadosFinanceiros_model->recebeDadosFinanceiros();

		$data['contasRecorrentes'] = $this->FinContasRecorrentes_model->recebeContasRecorrentes();

		// echo "<pre>"; print_r($data['contasRecorrentes']); exit;

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/contas-recorrentes');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraContasRecorrentes()
	{
		$idConta = $this->input->post('idConta');
		$dadosLancamento = $this->input->post('dados');

		$data['id_dado_financeiro'] = $dadosLancamento['recebido'];
		$data['id_empresa'] = $this->session->userdata('id_empresa');
		$data['id_micro'] = $dadosLancamento['id_micro'];

		$retorno = $idConta ? $this->FinContasRecorrentes_model->editaConta($idConta, $data) : $this->FinContasRecorrentes_model->insereConta($data);

		if ($retorno) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Contas inseridas com sucesso!",
				'type' => "success"
			);
		} else {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Falha ao inserir contas recebidas. Por favor, tente novamente.",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function recebeTodosClientesAll()
	{
		$this->load->model('Clientes_model');
		$todosClientes = $this->Clientes_model->recebeTodosClientesAll();

		if ($todosClientes) {

			$response = array(
				'clientes' => $todosClientes,
				'success' => true
			);
		} else {
			$response = array(
				'success' => false
			);
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function visualizarConta()
	{
		$idConta = $this->input->post('idConta');

		$conta = $this->FinContasRecorrentes_model->recebeContaRecorrentes($idConta);

		if ($conta) {
			$response = array(
				'success' => true,
				'conta' => $conta
			);
		} 

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletarConta()
	{
		$idConta = $this->input->post('idConta');

		$retorno = $this->FinContasRecorrentes_model->deletaConta($idConta);

		if ($retorno) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Conta deletada com sucesso!",
				'type' => "success"
			);
		} else {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possivel deletar a conta!",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

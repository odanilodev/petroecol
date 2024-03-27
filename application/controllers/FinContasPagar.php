<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinContasPagar extends CI_Controller
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
		$this->load->model('FinContasPagar_model');

	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// Scripts para contas a pagar
		$scriptsContasPagarHead = scriptsFinContasPagarHead();
		$scriptsContasPagarFooter = scriptsFinContasPagarFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsContasPagarHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsContasPagarFooter));

		$this->load->model('FinMacro_model');
		$data['macros'] = $this->FinMacro_model->recebeMacros();
		$data['dadosFinanceiro'] = $this->FinDadosFinanceiros_model->recebeDadosFinanceiros();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/contas-pagar');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraContasPagar () 
	{
		$dadosLancamento = $this->input->post('dados');

		$data['id_dado_financeiro'] = $dadosLancamento['recebido'];
		$data['id_empresa'] = $this->session->userdata('id_empresa');

		$data['valor'] = str_replace(['.', ','], ['', '.'], $dadosLancamento['valor']);

		$data['id_micro'] = $dadosLancamento['micros'];
		$data['observacao'] = $dadosLancamento['observacao'];
		$data['data_vencimento'] = date('Y-m-d', strtotime(str_replace('/', '-',  $dadosLancamento['data_vencimento'])));
		$data['data_emissao'] = date('Y-m-d', strtotime(str_replace('/', '-',  $dadosLancamento['data_emissao'])));

		$success = true;

		for ($i = 0; $i < $dadosLancamento['parcelas']; $i++) {

			if ($i > 0) {
				$data['data_vencimento'] = date('Y-m-d', strtotime($data['data_vencimento'] . ' +30 days'));
			}

			$retorno = $this->FinContasPagar_model->insereContasPagar($data);

			// para o loop se der erro em alguma
			if ($i == 0 && !$retorno) {
				$success = false;
			}
		}

		if ($success) {
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
}

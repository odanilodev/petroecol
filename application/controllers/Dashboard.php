<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
		$this->load->model('Agendamentos_model');
		$this->load->model('Clientes_model');
		$this->load->model('Coletas_model');
		$this->load->helper('dashboard_helper');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para dashboard
		$scriptsDashboardFooter = scriptsDashboardFooter();
		$scriptsDashboardHead = scriptsDashboardHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsDashboardHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsDashboardFooter));

		//Dados agendamentos
		$data['agendamentosAtrasados'] = $this->Agendamentos_model->contaAgendamentoAtrasadoCLiente();
		$data['agendamentosFinalizados'] = $this->Agendamentos_model->contaAgendamentoFinalizadoCLiente();
		$data['agendamentosRestantes'] = $this->Agendamentos_model->contaAgendamentoCLiente();

		//Número de clientes por classificação
		$data['contaClassificacaoClientes'] = $this->Clientes_model->contaClientesPorClassificacao();

		//Residuos coletados no mês especifico ou no ano atual
		$data['quantidadeColetada'] = contaResiduosColetados($this->input->post('mes'));

		//Clientes separados por status
		$data['clientesPorStatus'] = clientesPorStatus();

		//Clientes inativados no mês ou ano
		$mesInativado = $this->input->post('mesInativado');
		$data['clientesInativados'] = $this->Clientes_model->clientesInativados($mesInativado);

		echo'<pre>';
		print_r($data['clientesInativados']);
		exit;

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/dashboard/dashboard');
		$this->load->view('admin/includes/painel/rodape');
	}
}

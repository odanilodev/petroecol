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

		$data['agendamentosAtrasados'] = $this->Agendamentos_model->contaAgendamentoAtrasadoCLiente();
		$data['agendamentosFinalizados'] = $this->Agendamentos_model->contaAgendamentoFinalizadoCLiente();
		$data['agendamentosRestantes'] = $this->Agendamentos_model->contaAgendamentoCLiente();

		//Número de clientes por classificação
		$data['contaClassificacaoClientes'] = $this->Clientes_model->contaClientesPorClassificacao();

		//Número de clientes por status
		$clientesPorStatus = $this->Clientes_model->contaClientesPorStatus();

		$contagemPorStatus = array();

    foreach ($clientesPorStatus as $v) {
			$contagemPorStatus[$v['status']] = $v['TOTAL_CLIENTES_POR_STATUS'];
    }

		$data['clientesPorStatus'] = $contagemPorStatus;
	
		//Resíduos coletados no mês
		$mes = $this->input->post('mes');
		$residuosColetadosMes = $this->Coletas_model->contaResiduosColetadosMes($mes);

		//Soma a quantidade coletada dos residuos no mês ou ano
		$quantidadeColetada = 0;
		foreach($residuosColetadosMes as $residuoColetado){
		
			$decoded = json_decode($residuoColetado['quantidade_coletada']); 
			$quantidadeColetada += intval($decoded[0]);
		}

		

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/dashboard/dashboard');
		$this->load->view('admin/includes/painel/rodape');
	}
}

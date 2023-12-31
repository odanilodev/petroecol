<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Romaneios extends CI_Controller
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

		$this->load->model('Etiquetas_model');
		$this->load->model('EtiquetaCliente_model');
		$this->load->model('Clientes_model');
		$this->load->model('Romaneios_model');
		$this->load->library('gerarRomaneio');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts romaneio
		$scriptsRomaneioHead = scriptsRomaneioHead();
		$scriptsRomaneioFooter = scriptsRomaneioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsRomaneioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsRomaneioFooter));

		$data['ultimosRomaneios'] = $this->Romaneios_model->recebeUltimosRomaneios();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/romaneio/romaneios');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function gerarRomaneioEtiqueta()
	{
		$codigo = time();

		// dados para gravar no banco
		$dados['id_responsavel'] = $this->input->post('responsavel');
		$dados['id_veiculo'] = $this->input->post('veiculo');
		$dados['data_romaneio'] = $this->input->post('data_coleta');
		$dados['clientes'] = json_encode($this->input->post('clientes')); // Recebe um array e depois passa os dados por JSON
		$dados['codigo'] = $codigo;
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$insereRomaneio = $this->Romaneios_model->insereRomaneio($dados); // grava no banco romaneio que foi gerado

		if ($insereRomaneio) {
			$response = array(
				'success' => true,
				'message' => 'Romaneio gerado com sucesso.'
			);
		} else {
			$response = array(
				'success' => false,
				'message' => 'Falha ao cadastrar romaneio, tente novamente!'
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));

	}


	public function gerarRomaneio()
	{
		$codigo = $this->uri->segment(3);
		$this->gerarromaneio->gerarPdf($codigo);
	}

	public function formulario()
	{
		$this->load->model('Funcionarios_model');
		$this->load->model('Veiculos_model');
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts romaneio
		$scriptsRomaneioHead = scriptsRomaneioHead();
		$scriptsRomaneioFooter = scriptsRomaneioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsRomaneioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsRomaneioFooter));

		$data['cidades'] = $this->Clientes_model->recebeCidadesCliente();
		$data['etiquetas'] = $this->Etiquetas_model->recebeEtiquetas();
		$data['clientes'] = $this->Clientes_model->recebeClientesEtiquetas();
		$data['responsaveis'] = $this->Funcionarios_model->recebeResponsavelAgendamento();
		$data['veiculos'] = $this->Veiculos_model->recebeVeiculos();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/romaneio/cadastra-romaneio');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function filtrarClientesRomaneio()
	{
		$dados['data_coleta'] = $this->input->post('data_coleta');
		$dados['cidades'] = $this->input->post('cidades');
		$dados['ids_etiquetas'] = $this->input->post('ids_etiquetas');

		$res = $this->Romaneios_model->filtrarClientesRomaneio($dados);

		$response = array(
			'retorno' => $res,
			'registros' => count($res)
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function recebeClientesRomaneios()
	{
		$codRomaneio = $this->input->post('codRomaneio');

		$romaneio = $this->Romaneios_model->recebeIdsClientesRomaneios($codRomaneio);

		$idsClientes = json_decode($romaneio['clientes'], true);

		$clientesRomaneio = $this->Clientes_model->recebeClientesRomaneio($idsClientes);

		// residuos
        $this->load->model('Residuos_model');

        $residuos = $this->Residuos_model->recebeTodosResiduos();

		// formas de pagamentos
        $this->load->model('FormaPagamento_model');

        $formas_pagamentos = $this->FormaPagamento_model->recebeFormasPagamento();

		$response = array(
			'retorno' => $clientesRomaneio,
			'residuos' => $residuos,
			'pagamentos' => $formas_pagamentos,
			'registros' => count($clientesRomaneio)
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	

	public function recebeTodosResiduos()
	{
		// residuos
        $this->load->model('Residuos_model');

        $residuos = $this->Residuos_model->recebeTodosResiduos();

		$response = array(
			'residuos' => $residuos
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}
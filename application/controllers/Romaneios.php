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
		date_default_timezone_set('America/Sao_Paulo');
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

	public function recebeRomaneioPorData()
	{
		$dataRomaneio = $this->input->post('dataRomaneio');
		$romaneios = $this->Romaneios_model->recebeRomaneioPorData($dataRomaneio);

		$response = array(
			'romaneios' => $romaneios,
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function detalhes()
	{

		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts romaneio
		$scriptsRomaneioHead = scriptsRomaneioHead();
		$scriptsRomaneioFooter = scriptsRomaneioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsRomaneioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsRomaneioFooter));

		$this->load->library('formasPagamentoChaveId');
		$this->load->library('residuoChaveId');

		$codRomaneio = $this->uri->segment(3);

		$this->load->model('Coletas_model');

		// todos residuos cadastrado na empresa
		$data['residuos'] = $this->residuochaveid->residuoArrayChaveId();
		// todas formas de pagamento cadastrado na empresa
		$data['formasPagamento'] = $this->formaspagamentochaveid->formaPagamentoArrayChaveId();


		$data['romaneio'] = $this->Coletas_model->recebeColetaRomaneio($codRomaneio);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/romaneio/detalhes-romaneio');
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
		$dados['id_setor_empresa'] = $this->input->post('setorEmpresa');
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

		$this->load->model('SetoresEmpresaCliente_model');
		$data['setores'] = $this->SetoresEmpresaCliente_model->recebeSetoresEmpresaClientes();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/romaneio/cadastra-romaneio');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function filtrarClientesRomaneio()
	{
		$filtrar_data = $this->input->post('filtrar_data');
		$dados['cidades'] = $this->input->post('cidades');
		$dados['ids_etiquetas'] = $this->input->post('ids_etiquetas');
		$dados['data_coleta'] = null;
		$setorEmpresa = $this->input->post('setorEmpresa');

		if ($filtrar_data != '') {
			$dados['data_coleta'] = $this->input->post('data_coleta');
		}

		$res = $this->Romaneios_model->filtrarClientesRomaneio($dados, $setorEmpresa);

		$response = array(
			'retorno' => $res,
			'registros' => count($res)
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function recebeClientesRomaneios()
	{
		$codRomaneio = $this->input->post('codRomaneio');
		$idSetorEmpresa = $this->input->post('idSetorEmpresa');

		$this->load->model('Agendamentos_model');

		$romaneio = $this->Romaneios_model->recebeRomaneioCod($codRomaneio);

		$id_cliente_prioridade = $this->Agendamentos_model->recebeAgendamentoPrioridade($romaneio['data_romaneio']);

		$idsClientes = json_decode($romaneio['clientes'], true);

		$clientesRomaneio = $this->Clientes_model->recebeClientesIds($idsClientes, $idSetorEmpresa);

		// residuos
		$this->load->model('Residuos_model');
		$residuos = $this->Residuos_model->recebeResiduoSetor($idSetorEmpresa);

		// formas de pagamentos
		$this->load->model('FormaPagamento_model');
		$formas_pagamentos = $this->FormaPagamento_model->recebeFormasPagamento();

		$response = array(
			'retorno' => $clientesRomaneio,
			'residuos' => $residuos,
			'pagamentos' => $formas_pagamentos,
			'id_cliente_prioridade' => $id_cliente_prioridade,
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

	public function recebeCidadeClientesSetor()
	{
		$idSetor = $this->input->post('id_setor');

		$this->load->model('SetoresEmpresaCliente_model');
		$cidades = $this->SetoresEmpresaCliente_model->recebeCidadesClientesSetoresEmpresa($idSetor);

		$response = array(
			'cidades' => $cidades
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function editarRomaneio()
	{
		$codigoRomaneio = $this->input->post('codigo');

		$romaneio = $this->Romaneios_model->recebeRomaneioCod($codigoRomaneio);

		$response = array(
			'romaneio' => $romaneio
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletaRomaneio()
	{
		$id = $this->input->post('id');

		$retorno = $this->Romaneios_model->deletaRomaneio($id);

		if ($retorno) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Romaneio deletado com sucesso!",
				'type' => "success",
				'redirect' => true
			);
		} else {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possivel deletar o romaneio!",
				'type' => "error",
				'redirect' => false

			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletaClienteRomaneio()
	{
		$codRomaneio = $this->input->post('romaneio');
		$id_cliente = $this->input->post('cliente');

		$romaneio = $this->Romaneios_model->recebeIdsClientesRomaneios($codRomaneio);


		$arrayIdsClientes = json_decode($romaneio['clientes']);

		if (count($arrayIdsClientes) == 1) {

			$this->Romaneios_model->deletaRomaneio($romaneio['id']);

			$response = array(
				'title' => "Sucesso!",
				'message' => 'Romaneio deletado com sucesso!',
				'type' => "success",
				'redirect' => true

			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}


		$index = array_search($id_cliente,  $arrayIdsClientes);

		if ($index !== false) {
			array_splice($arrayIdsClientes, $index, 1);
		}

		$data['clientes'] = json_encode($arrayIdsClientes);

		$this->Romaneios_model->editaRomaneioCodigo($codRomaneio, $data);


		$response = array(
			'romaneio' => $romaneio,
			'redirect' => false

		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function adicionaNovoClienteRomaneio()
	{
		$codRomaneio = $this->input->post('romaneio');
		$id_cliente = $this->input->post('cliente');

		$romaneio = $this->Romaneios_model->recebeIdsClientesRomaneios($codRomaneio);

		$arrayIdsClientes = json_decode($romaneio['clientes']);

		$index = array_search($id_cliente,  $arrayIdsClientes);

		// verifica se o id está no array
		if ($index !== false) {

			$response = array(
				'redirect' => false,
				'success' => false
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		} else {

			array_push($arrayIdsClientes, $id_cliente);

			$data['clientes'] = json_encode($arrayIdsClientes);

			$this->Romaneios_model->editaRomaneioCodigo($codRomaneio, $data);


			$response = array(
				'romaneio' => $romaneio,
				'redirect' => false,
				'success' => true
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
}

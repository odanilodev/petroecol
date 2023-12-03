<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Romaneios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// INICIO controle sessão
		$this->load->library('Controle_sessao');
		$res = $this->controle_sessao->controle();
		if ($res == 'erro') {
			redirect('login/erro', 'refresh');
		}
		// FIM controle sessão

		$this->load->model('Etiquetas_model');
		$this->load->model('EtiquetaCliente_model');
		$this->load->model('Clientes_model');
		$this->load->model('Romaneios_model');
		$this->load->library('gerarromaneio');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		add_scripts('header', $scriptsPadraoHead);
		add_scripts('footer', $scriptsPadraoFooter);

		$data['ultimosRomaneios'] = $this->Romaneios_model->recebeUltimosRomaneios();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/romaneio/romaneios');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function gerarRomaneioEtiqueta()
	{

		$codigo = time();

		// dados para gravar no banco
		$dados['id_motorista'] = 'pegar por POST vindo';
		$dados['data_romaneio'] = 'pegar por POST vindo';
		$dados['clientes'] = 'pegar por POST vindo'; // Recebe um array e depois passar os dados por JSON
		$dados['codigo'] = $codigo;
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$insereRomaneio = $this->Romaneios_model->insereRomaneio($dados); // grava no banco romaneio que foi gerado	

		if ($insereRomaneio) {
			redirect('romaneios');
		} else {
			// tratar se deu erro na hora de gravar romaneio
		}
	}

	public function gerarRomaneio()
	{
		$codigo = $this->uri->segment(3);
		$this->gerarromaneio->gerarPdf($codigo);
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		add_scripts('header', $scriptsPadraoHead);
		add_scripts('footer', $scriptsPadraoFooter);

		$data['cidades'] = $this->Clientes_model->recebeCidadesCliente();
		$data['etiquetas'] = $this->Etiquetas_model->recebeEtiquetas();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/romaneio/cadastra-romaneio');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function filtrarClientesRomaneio()
	{
		$dados['data_coleta'] = $this->input->post('data_coleta');
		$dados['cidades'] = $this->input->post('cidades');
		$dados['ids_etiquetas'] = $this->input->post('ids_etiquetas');

		echo '<pre>';
		print_r($dados);
	}
}

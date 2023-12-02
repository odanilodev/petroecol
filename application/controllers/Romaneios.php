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

		$this->load->model('EtiquetaCliente_model');
		$this->load->model('Clientes_model');
		$this->load->model('Romaneios_model');
		$this->load->library('gerarromaneio');
	}

	public function gerarRomaneioEtiqueta()
	{
		$idEtiqueta = $this->uri->segment(3);
		$idClientes = $this->EtiquetaCliente_model->recebeTotalEtiquetasId($idEtiqueta);
		$codigo = time();

		// dados para gravar no banco
		$dados['id_motorista'] = $this->uri->segment(4);
		$dados['data_romaneio'] = $this->uri->segment(5);
		$dados['clientes'] = json_encode($idClientes);
		$dados['codigo'] = $codigo;
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$insereRomaneio = $this->Romaneios_model->insereRomaneio($dados); // grava no banco romaneio que foi gerado	

		if ($insereRomaneio) {
			$this->gerarromaneio->gerarPdf($codigo);
		}
	}
}

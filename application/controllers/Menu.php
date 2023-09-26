<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
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
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		add_scripts('header', $scriptsPadraoHead);
		add_scripts('footer', $scriptsPadraoFooter);

		$this->load->view('admin/includes/painel/cabecalho');
		$this->load->view('admin/paginas/menu/cadastra-menu');
		$this->load->view('admin/includes/painel/rodape');
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
	public function formulario()
	{
		$scriptsHead = scriptsUsuarioHead();
		add_scripts('header', $scriptsHead);

		$scriptsFooter = scriptsUsuarioFooter();
		add_scripts('footer', $scriptsFooter);

		$this->load->view('admin/includes/painel/cabecalho');
		$this->load->view('admin/paginas/usuarios/cadastra-usuario');
		$this->load->view('admin/includes/painel/rodape');
	}

}
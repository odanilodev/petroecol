<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function index()
	{
		$scriptsHead = scriptsGeralHead();
		add_scripts('header', $scriptsHead);

		$scriptsFooter = scriptsGeralFooter();
		add_scripts('footer', $scriptsFooter);

		$this->load->view('admin/includes/painel/cabecalho');
		$this->load->view('admin/paginas/admin');
		$this->load->view('admin/includes/painel/rodape');
	}

}

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

		$this->load->model('Menu_model');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		add_scripts('header', $scriptsPadraoHead);
		add_scripts('footer', $scriptsPadraoFooter);

		$data['menus'] = $this->Menu_model->recebeMenus();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/menu/cadastra-menu');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraMenu()
	{
		$id = $this->input->post('id');

		$dados['nome'] = $this->input->post('nome');
		$dados['icone'] = $this->input->post('icone');
		$dados['link'] = $this->input->post('link');
		$dados['ordem'] = $this->input->post('ordem');
		$dados['sub'] = $this->input->post('sub');

		$this->Menu_model->insereMenu($dados);

		echo "deu bom";
		
	}
}

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

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		$scriptsMenuFooter = array('<script src="' . base_url('assets/js/menu/formulario-menu.js') . '"></script>');

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsMenuFooter));

		$data['menus'] = $this->Menu_model->recebeMenus();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/menu/menus');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		$scriptsMenuFooter = array('<script src="' . base_url('assets/js/menu/formulario-menu.js') . '"></script>');

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsMenuFooter));

		$id = $this->uri->segment(3);

		$data['categoriasPai'] = $this->Menu_model->recebeCategoriasPai();
		$data['menu'] = $this->Menu_model->recebeMenu($id);

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

		$retorno = $id ? $this->Menu_model->editaMenu($id, $dados) : $this->Menu_model->insereMenu($dados);

		if ($retorno) { 

			$response = array(
				'success' => true,
				'message' => $id ? 'Menu editado com sucesso!' : 'Menu cadastrado com sucesso!'
			);

		} else { 

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o menu!" : "Erro ao cadastrar o menu!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		
	}

	public function deletaMenu()
	{
		$id = $this->input->post('id');

        $this->Menu_model->deletaMenu($id);
	}

}

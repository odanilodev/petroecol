<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Usuarios_model');
        date_default_timezone_set('America/Sao_Paulo');
	}

	public function index()
	{
		$scriptsHead = scriptsUsuarioHead();
		add_scripts('header', $scriptsHead);

		$scriptsFooter = scriptsUsuarioFooter();
		add_scripts('footer', $scriptsFooter);

		$data['usuarios'] = $this->Usuarios_model->exibeUsuarios();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/usuarios/usuarios');
		$this->load->view('admin/includes/painel/rodape');
	}
	
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

	public function cadastraUsuario()
	{
		$dados['nome'] = $this->input->post('nome');
		$dados['telefone'] = $this->input->post('telefone');
		$dados['email'] = $this->input->post('email');
		$dados['senha'] = $this->input->post('senha');
		$dados['data_criacao'] = date('Y-m-d H:m:s');

		$usuario = $this->Usuarios_model->recebeUsuarioEmail($dados['email']); //Verifica se ja existe existe o email

		if($usuario) {
			echo "email já existe";
			return;
		}

		// verifica se veio imagem
		if (!empty($_FILES['imagem']['name'])) {
			$config['upload_path']   = './uploads/usuarios';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('imagem')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_perfil'] = $dados_imagem['file_name'];
			}
		}

		$this->Usuarios_model->insereUsuario($dados);
	}
}

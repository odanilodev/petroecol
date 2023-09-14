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

		$id = $this->uri->segment(3);

		$data['usuario'] = $this->Usuarios_model->exibeUsuario($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/usuarios/cadastra-usuario');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraUsuario()
	{
		$id = $this->input->post('id');

		$dados['nome'] = $this->input->post('nome');
		$dados['telefone'] = $this->input->post('telefone');
		$dados['email'] = $this->input->post('email');
		$dados['data_criacao'] = date('Y-m-d H:m:s');

		if (!$id) {

			$usuario = $this->Usuarios_model->recebeUsuarioEmail($dados['email']); //Verifica se ja existe existe o email

			if ($usuario) {
				echo "email já existe";
				return;
			}
		}

		// verifica se veio imagem
		if (!empty($_FILES['imagem']['name'])) {
			$config['upload_path']   = './uploads/usuarios';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			// deleta a foto de perfil antiga do server
			if($id) {

				$imagemAntiga = $this->Usuarios_model->imagemAntiga($id);

				$caminho = './uploads/usuarios/' . $imagemAntiga['foto_perfil'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('imagem')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_perfil'] = $dados_imagem['file_name'];
			}

		}

		if ($id) {

			if ($this->input->post('novaSenha')) {
				$dados['senha'] = $this->input->post('novaSenha');
			}

			$this->Usuarios_model->editaUsuario($id, $dados);

			echo "usuario editado";
			
		} else {

			$dados['senha'] = $this->input->post('senha');

			$this->Usuarios_model->insereUsuario($dados);

			echo "usuario cadastrado";
		}
	}

	public function verificaSenhaAntiga()
	{
		$id = $this->input->post('id');
		$senhaAntiga = $this->input->post('senhaAntiga');

		$usuario = $this->Usuarios_model->verificaSenhaAntiga($id, $senhaAntiga);

		if ($usuario) {
			echo "senha encontrada";
		} else {
			echo "senha não encontrada";
		}
	}
}

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

		$data['usuarios'] = $this->Usuarios_model->recebeUsuarios();

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

		$data['usuario'] = $this->Usuarios_model->recebeUsuario($id);

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
		$dados['data_criacao'] = date('Y-m-d H:i:s'); // Corrija o formato da data.

		$usuario = $this->Usuarios_model->recebeUsuarioEmail($dados['email']); // Verifica se já existe o email

		// Verifica se o email já existe e se não é o email do usuário que está sendo editado
		if ($usuario && $usuario['id'] != $id) {
			echo "Email já existe";
			return;
		}

		// Verifica se veio a senha
		if ($this->input->post('senha')) {
			$dados['senha'] = password_hash($this->input->post('senha'), PASSWORD_DEFAULT);
		}

		// Verifica se veio imagem
		if (!empty($_FILES['imagem']['name'])) {
			$config['upload_path']   = './uploads/usuarios';
			$config['allowed_types'] = 'jpg|jpeg|png|';

			$this->load->library('upload', $config);

			// Deleta a foto de perfil antiga do servidor
			if ($id) {
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
				$dados['senha'] = password_hash($this->input->post('novaSenha'), PASSWORD_DEFAULT);
			}

			$this->Usuarios_model->editaUsuario($id, $dados);

			echo "usuario editado";
		} else {
			$this->Usuarios_model->insereUsuario($dados);
			echo "usuario cadastrado";
		}
	}


	public function verificaSenhaAntiga()
	{
		$id = $this->input->post('id');
		$senhaAntiga = $this->input->post('senhaAntiga');

		$usuario = $this->Usuarios_model->recebeUsuario($id);

		if ($usuario) {
			$senha_hash = $usuario['senha']; // O hash da senha armazenado no banco de dados.

			if (password_verify($senhaAntiga, $senha_hash)) {
				// A senha antiga está correta.
				echo "senha encontrada";
			} else {
				// A senha antiga está incorreta.
				echo "senha não encontrada";
			}
		} 
		
	}


	public function deletaUsuario()
	{
		$id = $this->input->post('id');

		$imagemAntiga = $this->Usuarios_model->imagemAntiga($id);

		if ($imagemAntiga['foto_perfil']) {
			$caminho = './uploads/usuarios/' . $imagemAntiga['foto_perfil'];
			unlink($caminho);
		}

		$this->Usuarios_model->deletaUsuario($id);

		redirect('usuarios');
	}
}

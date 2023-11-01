<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// INICIO controle sessão
        $this->load->library('Controle_sessao');
        $res = $this->controle_sessao->controle();
        if($res == 'erro'){ redirect('login/erro', 'refresh');}
        // FIM controle sessão

		$this->load->model('Usuarios_model');
		date_default_timezone_set('America/Sao_Paulo');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();
		
		// scripts para usuarios
		$scriptsUsuarioHead = scriptsUsuarioHead();
		$scriptsUsuarioFooter = scriptsUsuarioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead,$scriptsUsuarioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter,$scriptsUsuarioFooter));

		$data['usuarios'] = $this->Usuarios_model->recebeUsuarios();


		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/usuarios/usuarios');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();
		
		// scripts para usuarios
		$scriptsUsuarioHead = scriptsUsuarioHead();
		$scriptsUsuarioFooter = scriptsUsuarioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsUsuarioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsUsuarioFooter));

		$this->load->model('Empresas_model');
		$this->load->model('Setores_model');

		$id = $this->uri->segment(3);

		$data['usuario'] = $this->Usuarios_model->recebeUsuario($id);

		$data['empresas'] = $this->Empresas_model->recebeEmpresas();

		$data['setores'] = $this->Setores_model->recebeSetores();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/usuarios/cadastra-usuario');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraUsuario()
	{
		$id = $this->input->post('id');

		$nome = $this->input->post('nome');
		$dados['nome'] = mb_convert_case($nome, MB_CASE_TITLE, 'UTF-8');
		$dados['telefone'] = $this->input->post('telefone');
		$dados['email'] = $this->input->post('email');
		$dados['id_empresa'] = $this->session->userdata('id_empresa') > 1 ? $this->session->userdata('id_empresa') : $this->input->post('id_empresa'); // Se for usuário master pela valor do input
		$dados['id_setor'] = $this->input->post('setor');

		$usuario = $this->Usuarios_model->recebeUsuarioEmail($dados['email']); // Verifica se já existe o email

		// Verifica se o email já existe e se não é o email do usuário que está sendo editado
		if ($usuario && $usuario['id'] != $id) {

			$response = array(
				'success' => false,
				'message' => "Este email está vinculado a outra conta! Tente um email diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
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

			$imagemAntiga = $this->Usuarios_model->imagemAntiga($id);
			
			// Deleta a foto de perfil antiga do servidor
			if ($id && $imagemAntiga['foto_perfil']) {
				$caminho = './uploads/usuarios/' . $imagemAntiga['foto_perfil'];
				unlink($caminho);
			}

			if ($this->upload->do_upload('imagem')) {
				$dados_imagem = $this->upload->data();
				$dados['foto_perfil'] = $dados_imagem['file_name'];
			}
		}

		if ($id && $this->input->post('novaSenha')) {
			$dados['senha'] = password_hash($this->input->post('novaSenha'), PASSWORD_DEFAULT);
		}

		$retorno = $id ? $this->Usuarios_model->editaUsuario($id, $dados) : $this->Usuarios_model->insereUsuario($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Usuário editado com sucesso!' : 'Usuário cadastrado com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o usuario!" : "Erro ao cadastrar o usuario!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
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
				$response = array(
					'success' => true
				);

			} else {
				// A senha antiga está incorreta.
				$response = array(
					'success' => false
				);

			}

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));

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

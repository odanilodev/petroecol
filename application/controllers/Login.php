<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function index()
	{
		$this->load->view('admin/login/login');
	}

    public function esqueceuSenha()
	{
		$scriptsHead = scriptsLoginHead();
		add_scripts('header', $scriptsHead);

		$scriptsFooter = scriptsLoginFooter();
		add_scripts('footer', $scriptsFooter);

		$this->load->view('admin/includes/login/cabecalho');
		$this->load->view('admin/login/redefine-senha');
		$this->load->view('admin/includes/login/rodape');
	}

	public function verificaCodigo()
	{
		$codigo = $this->input->post('codigo');

		echo $codigo;
	}

	public function recuperaSenha()
	{
		$email = $this->input->post('email');

		echo $email;
	}

	public function redefineSenha()
	{
		$novaSenha = $this->input->post('senha');

		echo $novaSenha;
	}
	
	public function recebeLogin(){

		$this->load->model('Usuarios_model');

		$email = $this->input->post('email');
		$senha = $this->input->post('senha');

		$usuario = $this->Usuarios_model->recebeUsuarioEmail($email); //Realiza uma busca no DB usando o email digitado

		if($usuario) {
			if ($senha === $usuario['senha']) {
				// As credenciais são válidas, o usuário está autenticado

				$this->session->set_userdata('nome_usuario', $usuario['nome']);
				$this->session->set_userdata('email', $usuario['email']);

				echo 'usuario logado';
			} else {
				// As credenciais estao incorretas, acesso negado
				echo 'senha incorreta';
			}
		} else{
			//Nao retornou nada no recebeUsuarioEmail, portando nao existe um usuario com o email digitado
			echo 'Usuario nao encontrado';
		}

	}
    
}

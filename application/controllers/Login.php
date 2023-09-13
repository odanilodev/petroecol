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

		$this->load->library('EmailSender');
		$emailSender = new EmailSender();

		$this->load->model('Token_model');
		$this->load->model('Usuarios_model');

		$email = $this->input->post('email');
		$assunto = 'Alteração de senha sistema Petroecol';

		$usuario = $this->Usuarios_model->recebeUsuarioEmail($email); //Realiza uma busca no DB usando o email digitado

		if(!$usuario) { //Verifica se o usuario existe no banco de dados.
			echo 'usuario nao encontrado';
			exit;
		} 
	
		// Gere um código de 6 números aleatórios
		$codigo = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);

		// Obtenha a data atual no formato 'Y-m-d H:i:s'
		$dataCriacao = date('Y-m-d H:i:s');
	
		// Calcule a data de expiração (30 minutos a partir da data atual)
		$dataValidade = date('Y-m-d H:i:s', strtotime($dataCriacao) + (30 * 60)); // Adiciona 30 minutos (30 * 60 segundos)
	
		// Crie um array com os dados para inserção
		$dadosToken = array(
			'codigo' => $codigo,
			'email_usuario' => $email,
			'data_criacao' => $dataCriacao,
			'data_validade' => $dataValidade
		);
	
		// Chame a função do modelo para inserir os dados na tabela
		$insercaoBemSucedida = $this->Token_model->insereToken($dadosToken);
	
		if ($insercaoBemSucedida) {
			// Inserção bem-sucedida
			$emailSender->enviarEmail('definicaoSenha', $email, $assunto, $codigo);
			echo 'Token enviado com sucesso';
		} else {
			// Falha na inserção
			echo "Houve um erro ao inserir o token.";
		}


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

		if ($usuario) {
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

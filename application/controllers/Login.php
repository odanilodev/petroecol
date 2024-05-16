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
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();
		$scriptsLoginFooter = array('<script src="' . base_url('assets/js/login/recupera-senha.js') . '"></script>');
		add_scripts('header', $scriptsPadraoHead);
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsLoginFooter));

        $this->load->view('admin/includes/login/cabecalho');
        $this->load->view('admin/login/redefine-senha');
        $this->load->view('admin/includes/login/rodape');
    }

    public function verificaCodigo()
    {
        $this->load->model('Token_model');

        $codigo = $this->input->post('codigo');

        $tokens = $this->Token_model->recebeTokenCodigo($codigo);

        if (!empty($tokens)) {

            $dataAtual = date('Y-m-d H:i:s');

            if ($dataAtual <= $tokens['data_validade']) {
                $response = array(
                    'success' => true,
                    'message' => 'Token válido.'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Token expirado.'
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'Token não encontrado.'
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function recuperaSenha()
    {
        $this->load->library('EmailSender');
        $emailSender = new EmailSender();

        $this->load->model('Token_model');
        $this->load->model('Usuarios_model');

        $email = $this->input->post('email');
        $assunto = 'Alteração de senha sistema Petroecol';

        $usuario = $this->Usuarios_model->recebeUsuarioEmail($email);

        if (!$usuario) {
            $response = array(
                'success' => false,
                'message' => 'Usuário não encontrado'
            );
            return $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }

        $codigo = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
        $dataCriacao = date('Y-m-d H:i:s');
        $dataValidade = date('Y-m-d H:i:s', strtotime($dataCriacao) + (30 * 60));

        $dadosToken = array(
            'codigo' => $codigo,
            'email_usuario' => $email,
            'data_criacao' => $dataCriacao,
            'data_validade' => $dataValidade
        );

        $insercaoBemSucedida = $this->Token_model->insereToken($dadosToken);

        if ($insercaoBemSucedida) {
            $emailSender->enviarEmailAPI('definicaoSenha', $email, $assunto, null, $codigo);
             $response = array(
                'success' => true,
                'message' => 'Token enviado com sucesso'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Houve um erro ao inserir o token.'
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));

    }

    public function redefineSenha()
    {
        $this->load->model('Usuarios_model');

        $novaSenha = $this->input->post('senha');
        $email = $this->input->post('email');

        $usuario = $this->Usuarios_model->recebeUsuarioEmail($email);

        if ($usuario) {
            $id = $usuario['id'];

            // Hash da nova senha
            $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $dados['senha'] = $novaSenhaHash;
            $dados['id_empresa'] = $usuario['id_empresa'];
            
            $resultado = $this->Usuarios_model->redefinirSenha($id, $dados);

            // Verifica se aletrou a senha
            if ($resultado) {
                $response = array(
                'success' => true,
                'message' => "Senha alterada com sucesso!"
                );
            } else {
                $response = array(
                    'success' => true,
                    'message' => "Não foi possível alterar a senha. Tente novamente!"
                );
            }
        } else {
            // Retorna mensagem de erro se o usuário não for encontrado
            $response = array(
                'success' => false,
                'message' => "Usuário não encontrado."
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function recebeLogin()
    {
        $this->load->model('Usuarios_model');
        $this->load->model('Empresas_model');

        $email = $this->input->post('email');
        $senha_digitada = $this->input->post('senha'); // A senha inserida pelo usuário.
        $redirecionamento = $this->input->post('link'); // Pega a url que o usuário tentou acessar
        $usuario = $this->Usuarios_model->recebeUsuarioEmail($email);

        if ($usuario) {
            $senha_hash = $usuario['senha']; // O hash da senha armazenado no banco de dados.

            if (password_verify($senha_digitada, $senha_hash)) {
                // A senha está correta.
                $this->session->set_userdata('logado', true);
                $this->session->set_userdata('nome_usuario', $usuario['nome']);
                $this->session->set_userdata('email', $usuario['email']);
                $this->session->set_userdata('id_usuario', $usuario['id']);
                $this->session->set_userdata('id_empresa', $usuario['id_empresa']);
                $this->session->set_userdata('foto_perfil', $usuario['foto_perfil']);
                $this->session->set_userdata('id_setor', $usuario['id_setor']);
                $this->session->set_userdata('idioma', $usuario['idioma']);
                $this->session->set_userdata('permissao', json_decode($usuario['permissao'], true));

                $dados_empresa = $this->Empresas_model->recebeEmpresa($this->session->userdata('id_empresa'));
                $this->session->set_userdata('nome_empresa', $dados_empresa['nome']);
                $this->session->set_userdata('email_empresa', $dados_empresa['email']);
                $this->session->set_userdata('senha_empresa', $dados_empresa['senha']);
                $this->session->set_userdata('dominio_empresa', $dados_empresa['dominio']);
                $this->session->set_userdata('chave_api', $dados_empresa['chave_api']);
                $this->session->set_userdata('chave_secreta', $dados_empresa['chave_secreta']);

                $url_redirecionamento = explode('login/index/', $redirecionamento);

                if (isset($url_redirecionamento[1])) { // manda o usuário pra url que ele tentou acessar com a senha expirada
                    redirect($url_redirecionamento[1]);
                }
                redirect('admin');
                exit;
            } else {
                // A senha está incorreta.
                $this->session->set_flashdata('mensagem', 'Usuário ou senha incorretos!');
                $this->session->set_flashdata('tipo_alerta', 'danger');
                redirect('login');
                exit;
            }
        } else {
            // Usuário não encontrado.
            $this->session->set_flashdata('mensagem', 'Usuário ou senha incorretos!');
            $this->session->set_flashdata('tipo_alerta', 'danger');
            redirect('login');
            exit;
        }
    }

    public function sair()
    {
        // Destrói a sessão
        $this->session->sess_destroy();

        // Redireciona para login
        redirect('login');
    }

    public function erro()
    {
        // scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

        add_scripts('header', $scriptsPadraoHead);
        add_scripts('footer', $scriptsPadraoFooter);

        
        // Destrói a sessão
        $this->session->sess_destroy();

        // view
        $this->load->view('admin/erros/acesso-negado');
    }
}
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
        $this->load->model('Token_model');

        $codigo = $this->input->post('codigo');

        $tokens = $this->Token_model->recebeTokenCodigo($codigo);

        if (!empty($tokens)) {
    
            $dataAtual = date('Y-m-d H:i:s');

            if ($dataAtual <= $tokens['data_validade']) {
                echo 'Token válido.';
            } else {
                echo 'Token expirado.';
            }
        } else {
            echo 'Token não encontrado.';
        }
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
            echo 'Usuário não encontrado';
            exit;
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
            $emailSender->enviarEmail('definicaoSenha', $email, $assunto, $codigo);
            echo 'Token enviado com sucesso';
        } else {
            echo 'Houve um erro ao inserir o token.';
        }
    }

    public function redefineSenha()
    {
        $this->load->model('Usuarios_model');
        
        $novaSenha = $this->input->post('senha');
        $email = $this->input->post('email');
        
        $usuario = $this->Usuarios_model->recebeUsuarioEmail($email);
        
        if ($usuario) {
            $id = $usuario['id'];
            $usuario['senha'] = $novaSenha;
        
            $resultado = $this->Usuarios_model->editaUsuario($id, $usuario);
        
            // Verifica se a edição foi bem-sucedida
            if ($resultado) {
                return "Editado com sucesso!";
            } else {
                return "Erro ao editar usuário, ou nenhum dado afetado.";
            }
        } else {
            // Retorna mensagem de erro se o usuário não for encontrado
            return "Usuário não encontrado.";
        }
    }

    public function recebeLogin()
    {
        $this->load->model('Usuarios_model');

        $email = $this->input->post('email');
        $senha = $this->input->post('senha');

        $usuario = $this->Usuarios_model->recebeUsuarioEmail($email);

        if ($usuario) {
            if ($senha === $usuario['senha']) {
                $this->session->set_userdata('nome_usuario', $usuario['nome']);
                $this->session->set_userdata('email', $usuario['email']);
                echo 'Usuário logado';
            } else {
                echo 'Senha incorreta';
            }
        } else {
            echo 'Usuário não encontrado';
        }
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmailSender
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('email');
        $this->CI->load->helper('config_master_helper');
    }

    public function enviarEmail($template, $email, $assunto, $opcao = null)
    {

        switch ($template) {
            case 'definicaoSenha':
                $html = $this->redefinicaoSenha($opcao);
                break;
            case 'enviarCertificado':
                $html = $this->enviarCertificado();
                var_dump($opcao);
                $this->CI->email->attach($opcao, 'certificado.pdf', 'application/pdf');
                break;
            default:
                $html =  $this->templatePadrao();
        }

        $emailRemetente = $this->CI->session->userdata('email_empresa') ?? dadosEmpresa('email');;
        $nomeRemetente = $this->CI->session->userdata('nome_empresa') ?? dadosEmpresa('nome');;
        // Define remetente e destinatário
        $this->CI->email->from($emailRemetente, $nomeRemetente); // Remetente
        $this->CI->email->to($email); // Destinatário

        // Define o assunto do email
        $this->CI->email->subject($assunto);

        $this->CI->email->message($html); // conteúdo para mensagem

        if ($this->CI->email->send()) {
            return true;
        } else {
            return false;
        }
    }

    private function redefinicaoSenha($opcao)
    {

        $html = "<h2>Olá, Você solicitou a alteração de senha em nosso sistema.</h2>";

        $html .= "<p>Segue o código para alteração de senha -> " . $opcao . "</p>";

        return $html;
    }

    private function templatePadrao()
    {

        return "<h2>Olá, temos uma mensagem para você!</h2>";
    }

    private function enviarCertificado()
    {

        return "<h2>Olá, segue o certificado em anexo!</h2>";
    }
}

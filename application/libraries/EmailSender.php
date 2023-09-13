<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailSender {
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('email');
    }

    public function enviarEmail($template, $email, $assunto, $codigo = null) {

        switch ($template) {
            case 'definicaoSenha':
                $html = $this->redefinicaoSenha($codigo);
                break;
            default:
                $html =  $this->templatePadrao();
        }

        $emailCopia = 'victor@petroecol.com.br';

        // Define remetente e destinatário
        $this->CI->email->from('contato@petroecol.eco.br', 'Petroecol Site'); // Remetente
        $this->CI->email->to($email); // Destinatário
        $this->CI->email->reply_to($emailCopia);

        // Define o assunto do email
        $this->CI->email->subject($assunto);

        $this->CI->email->message($html); // conteúdo para mensagem

        if ($this->CI->email->send()) {
            return true;
        } else {
            return false;
        }
    }

    private function redefinicaoSenha($codigo){

        $html = "<h2>Olá, Você solicitou a alteração de senha em nosso sistema.</h2>";

        $html .= "<p>Segue o codigo para alteração de senha -> ".$codigo."</p>";

        return $html;

    }

    private function templatePadrao(){

        return "<h2>Olá, temos uma mensagem para você!</h2>";

    }
}

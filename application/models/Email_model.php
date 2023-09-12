<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

	public function email($email,$assunto, $codigo)
	{

      //Configuração mail
      $config['smtp_host'] = 'mail.petroecol.com.br';
      $config['smtp_port'] = '587';
      $config['smtp_user'] = 'contato@petroecol.com.br';
      $config['smtp_pass'] = '@123contatopetroecol';
      $config['protocol'] = 'smtp';
      $config['wordwrap'] = TRUE;
      $config['validate'] = TRUE;
      $config['mailtype'] = 'html';
      $config['charset'] = 'utf-8';
      $config['newline'] = "\r\n";
  
      $html = "<h2>Olá, Você solicitou a alteração de senha em nosso sistema.</h2>";
      
      $html .= "<p>Segue o codigo para alteração de senha -> ".$codigo."</p>";
              
      $email2 = 'victor@petroecol.com.br';
      
      // Inicializa a library Email, passando os parâmetros de configuração
      $this->email->initialize($config);
      
      // Define remetente e destinatário
      $this->email->from('contato@petroecol.com.br', 'Petroecol Site'); // Remetente
      $this->email->to($email2, $email); // Destinatário
      $this->email->reply_to($email);

      // Define o assunto do email
      $this->email->subject($assunto);
  
      $this->email->message($html); // conteudo para mensagem
			
	}
		
}


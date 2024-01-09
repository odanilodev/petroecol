<?php

  $this->CI =& get_instance();
  $this->CI->load->library('session');
  $this->CI->load->helper('config_master_helper');

 //Configuração mail
 $config['smtp_host'] = 'mail.' . $this->CI->session->userdata('dominio_empresa') ?? dadosEmpresa('dominio');
 $config['smtp_port'] = '587';
 $config['smtp_user'] =  $this->CI->session->userdata('email_empresa') ?? dadosEmpresa('email');
 $config['smtp_pass'] = $this->CI->session->userdata('senha_empresa') ?? dadosEmpresa('senha');
 $config['protocol'] = 'smtp';
 $config['wordwrap'] = TRUE;
 $config['validate'] = TRUE;
 $config['mailtype'] = 'html';
 $config['charset'] = 'utf-8';
 $config['newline'] = "\r\n";

?>
<?php

$this->CI = &get_instance();
$this->CI->load->library('session');
$this->CI->load->helper('config_master_helper');

$host = !empty($this->CI->session->userdata('dominio_empresa')) ? $this->CI->session->userdata('dominio_empresa') : dadosEmpresa('dominio');

$emailRemetente = !empty($this->CI->session->userdata('email_empresa')) ? $this->CI->session->userdata('email_empresa') : dadosEmpresa('email');

$senhaRemetente = !empty($this->CI->session->userdata('senha_empresa')) ? $this->CI->session->userdata('senha_empresa') : dadosEmpresa('senha');

//Configuração mail
$config['smtp_host'] = "mail.$host";
$config['smtp_port'] = '587';
$config['smtp_user'] =  $emailRemetente;
$config['smtp_pass'] = $senhaRemetente;
$config['protocol'] = 'smtp';
$config['wordwrap'] = TRUE;
$config['validate'] = TRUE;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";

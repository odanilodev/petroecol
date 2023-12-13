<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Erros extends CI_Controller
{

  public function notFound()
  {
    // scripts padrão
    $scriptsPadraoHead = scriptsPadraoHead();
    $scriptsPadraoFooter = scriptsPadraoFooter();

    add_scripts('header', $scriptsPadraoHead);
    add_scripts('footer', $scriptsPadraoFooter);

    $this->load->view('errors/notfound');
  }
}

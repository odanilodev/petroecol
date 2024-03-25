<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinContasPagar extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		//INICIO controle sessão
        $this->load->library('Controle_sessao');
        $res = $this->controle_sessao->controle();
        if ($res == 'erro') {
            if ($this->input->is_ajax_request()) {
                $this->output->set_status_header(403);
                exit();
            } else {
                redirect('login/erro', 'refresh');
            }
        }
        // FIM controle sessão
	}

	public function index()
	{
		 // scripts padrão
		 $scriptsPadraoHead = scriptsPadraoHead();
		 $scriptsPadraoFooter = scriptsPadraoFooter();
 
		 // Scripts para contas a pagar
		 $scriptsContasPagarFooter = scriptsFinContasPagarFooter();
 
		 add_scripts('header', array_merge($scriptsPadraoHead));
		 add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsContasPagarFooter));

		$this->load->view('admin/includes/painel/cabecalho');
		$this->load->view('admin/paginas/financeiro/contas-pagar.php');
		$this->load->view('admin/includes/painel/rodape');
	}
}

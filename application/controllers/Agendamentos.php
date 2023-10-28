<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agendamentos extends CI_Controller
{ 
    public function index()
    {
        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        // scripts para agendamento
        $scriptsAgendamentoHead = scriptsAgendamentoHead();
        $scriptsAgendamentoFooter = scriptsAgendamentoFooter();

        add_scripts('header', array_merge($scriptsPadraoHead, $scriptsAgendamentoHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsAgendamentoFooter));

        $this->load->view('admin/includes/painel/cabecalho');
        $this->load->view('admin/paginas/agendamentos/index');
		$this->load->view('admin/includes/painel/rodape');

    }
}



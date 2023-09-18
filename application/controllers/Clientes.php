<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function formulario()
    {
        $scriptsHead = scriptsClienteHead();
        add_scripts('header', $scriptsHead);

        $scriptsFooter = scriptsClienteFooter();
        add_scripts('footer', $scriptsFooter);

        // $id = $this->uri->segment(3);

        // $data['usuario'] = $this->Usuarios_model->exibeUsuario($id);

        $this->load->view('admin/includes/painel/cabecalho');
        $this->load->view('admin/paginas/clientes/cadastra-cliente');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function cadastraCliente()
    {
        $dadosEmpresa = $this->input->post('dadosEmpresa');
        $dadosEndereco = $this->input->post('dadosEndereco');
        $dadosResponsavel = $this->input->post('dadosResponsavel');

        // coloca os arrays em uma única variável
        $dados = array_merge($dadosEmpresa, $dadosEndereco, $dadosResponsavel);
        
    }
}

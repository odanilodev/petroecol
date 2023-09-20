<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Clientes_model');
    }

    public function index()
    {
        $scriptsHead = scriptsClienteHead();
        add_scripts('header', $scriptsHead);

        $scriptsFooter = scriptsClienteFooter();
        add_scripts('footer', $scriptsFooter);

        $this->load->view('admin/includes/painel/cabecalho');
        $this->load->view('admin/paginas/clientes/clientes');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function formulario()
    {
        $scriptsHead = scriptsClienteHead();
        add_scripts('header', $scriptsHead);

        $scriptsFooter = scriptsClienteFooter();
        add_scripts('footer', $scriptsFooter);

        // $id = $this->uri->segment(3);

        // $data['usuario'] = $this->Clientes_model->exibeCliente($id);

        $this->load->view('admin/includes/painel/cabecalho');
        $this->load->view('admin/paginas/clientes/cadastra-cliente');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function cadastraCliente()
    {
        $dadosEmpresa = $this->input->post('dadosEmpresa');
        $dadosEndereco = $this->input->post('dadosEndereco');
        $dadosResponsavel = $this->input->post('dadosResponsavel');
    
        // Coloca os arrays em uma única variável
        $dados = array_merge($dadosEmpresa, $dadosEndereco, $dadosResponsavel);
        
        $dataHoraAtual = date('Y-m-d H:i:s');
        
        $dados['data_criacao'] = $dataHoraAtual;
    
        $this->Clientes_model->insereCliente($dados);
    
        echo "Usuário cadastrado com sucesso";
    }
    
    
}

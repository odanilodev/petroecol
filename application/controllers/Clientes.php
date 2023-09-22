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

        $data['clientes'] = $this->Clientes_model->recebeClientes();

        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/clientes/clientes');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function formulario()
    {
        $scriptsHead = scriptsClienteHead();
        add_scripts('header', $scriptsHead);

        $scriptsFooter = scriptsClienteFooter();
        add_scripts('footer', $scriptsFooter);

        $id = $this->uri->segment(3);

        $data['cliente'] = $this->Clientes_model->recebeCliente($id);

        $this->load->view('admin/includes/painel/cabecalho', $data);
        $this->load->view('admin/paginas/clientes/cadastra-cliente');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function cadastraCliente()
    {
        $dadosEmpresa = $this->input->post('dadosEmpresa');
        $dadosEndereco = $this->input->post('dadosEndereco');
        $dadosResponsavel = $this->input->post('dadosResponsavel');
        $id = $this->input->post('id');

        // Coloca os arrays em uma única variável
        $dados = array_merge($dadosEmpresa, $dadosEndereco, $dadosResponsavel);

        $dataHoraAtual = date('Y-m-d H:i:s');

        $dados['data_criacao'] = $dataHoraAtual;

        $resultado = $id ? $this->Clientes_model->editaCliente($id, $dados) : $this->Clientes_model->insereCliente($dados);

        if ($resultado) {
            echo $id ? "Cliente editado com sucesso" : "Cliente cadastrado com sucesso";
        } else {
            echo $id ? "Erro ao editar o cliente" : "Erro ao cadastrar o cliente";
        }

    }

    public function insereSql()
    {
        $this->load->view('admin/paginas/clientes/sql-cliente');
    }    
    
}

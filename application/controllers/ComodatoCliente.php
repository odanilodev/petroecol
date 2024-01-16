<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ComodatoCliente extends CI_Controller
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

		$this->load->model('recipientes_model');

	}

	
	public function cadastraComodato()
    {
        $this->load->model('ComodatoCliente_model');

        $this->load->library('upload_imagem');

        $id_cliente = $this->input->post('id');

        $arrayUpload = [
            'comodato' => ['clientes/comodato', null],
        ];

        $dados = $this->upload_imagem->uploadImagem($arrayUpload);

        $dados['id_empresa'] = $this->session->userdata('id_empresa');

        $dados['id_cliente'] = $id_cliente;

        $retorno = $this->ComodatoCliente_model->insereComodato($dados);

        if ($retorno) {
            $this->session->set_flashdata('tipo_retorno_funcao', 'success');
            $this->session->set_flashdata('redirect_retorno_funcao', '#');
            $this->session->set_flashdata('titulo_retorno_funcao', 'Cadastrado com sucesso!');
            $this->session->set_flashdata('texto_retorno_funcao', 'Comodato cadastrado com sucesso!');
        } else {

            $this->session->set_flashdata('tipo_retorno_funcao', 'error');
            $this->session->set_flashdata('redirect_retorno_funcao', '#');
            $this->session->set_flashdata('titulo_retorno_funcao', 'Não foi possivel deletar!');
            $this->session->set_flashdata('texto_retorno_funcao', 'O comodato nao pode ser deletado no momento!');
        }

        redirect('clientes/detalhes/' . $id_cliente);
    }

	public function  deletaComodato()
    {
        $this->load->model('ComodatoCliente_model');

        $id = $this->uri->segment(3);
        $nome_arquivo = urldecode($this->uri->segment(4));
        $id_cliente = $this->uri->segment(5);

        $retorno = $this->ComodatoCliente_model->deletaComodato($id);

        if ($retorno) {
            $caminho = './uploads/' . $this->session->userdata('id_empresa') . '/' . 'clientes/comodato/' . $nome_arquivo;
            unlink($caminho);
            $this->session->set_flashdata('tipo_retorno_funcao', 'success');
            $this->session->set_flashdata('redirect_retorno_funcao', '#');
            $this->session->set_flashdata('texto_retorno_funcao', 'Deletado com sucesso!');
            $this->session->set_flashdata('titulo_retorno_funcao', 'Sucesso!');
        } else {
            $this->session->set_flashdata('tipo_retorno_funcao', 'error');
            $this->session->set_flashdata('redirect_retorno_funcao', '#');
            $this->session->set_flashdata('texto_retorno_funcao', 'Não foi possivel deletar o comodato!');
            $this->session->set_flashdata('titulo_retorno_funcao', 'Algo deu errado!');
        }

        redirect('clientes/detalhes/' . $id_cliente);
    }

}

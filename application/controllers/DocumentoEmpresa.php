<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DocumentoEmpresa extends CI_Controller
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

    $this->load->model('DocumentoEmpresa_model');
  }

  public function index()
  {
    // scripts padrão
    $scriptsPadraoHead = scriptsPadraoHead();
    $scriptsPadraoFooter = scriptsPadraoFooter();

    // scripts para documentos empresa
    $scriptsDocumentoEmpresaFooter = scriptsDocumentoEmpresaFooter();

    add_scripts('header', array_merge($scriptsPadraoHead));
    add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsDocumentoEmpresaFooter));


    $data['documentos'] = $this->DocumentoEmpresa_model->recebeDocumentosEmpresa();

    $this->load->view('admin/includes/painel/cabecalho', $data);
    $this->load->view('admin/paginas/documento-empresa/documento-empresa');
    $this->load->view('admin/includes/painel/rodape');
  }

  public function formulario()
  {
    // scripts padrão
    $scriptsPadraoHead = scriptsPadraoHead();
    $scriptsPadraoFooter = scriptsPadraoFooter();

    // scripts para documentos empresa
    $scriptsDocumentoEmpresaFooter = scriptsDocumentoEmpresaFooter();

    add_scripts('header', array_merge($scriptsPadraoHead));
    add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsDocumentoEmpresaFooter));

    $id = $this->uri->segment(3);

    $data['documento'] = $this->DocumentoEmpresa_model->recebeDocumentoEmpresa($id);

    $this->load->view('admin/includes/painel/cabecalho', $data);
    $this->load->view('admin/paginas/documento-empresa/cadastra-documento-empresa');
    $this->load->view('admin/includes/painel/rodape');
  }
  public function cadastraDocumentoEmpresa()
  {
    $this->load->library('Upload_imagem');
    
    $nomes_documentos = $this->input->post('nome');
    $vencimento_documentos = $this->input->post('vencimento');
    $documentos = $this->input->post('documento');

    $id_empresa = $this->session->userdata('id_empresa');

    for ($i = 0; $i < count($nomes_documentos); $i++) {


      $dados = [
        'nome' => $nomes_documentos[$i],
        'validade' => DateTime::createFromFormat('d/m/Y', $vencimento_documentos[$i])->format('Y-m-d'),
        'documento' => $documentos,
        'id_empresa' => $id_empresa
      ];

      $retorno = $this->DocumentoEmpresa_model->insereDocumentoEmpresa($dados);
    }

    if ($retorno) {
      $this->session->set_flashdata('titulo_retorno_funcao', 'Sucesso!');
      $this->session->set_flashdata('tipo_retorno_funcao', 'success');
      $this->session->set_flashdata('redirect_retorno_funcao', '#');
      $this->session->set_flashdata('texto_retorno_funcao', 'Documento(s) cadastrado(s) com sucesso!');
      redirect('documentoEmpresa');
    } else {
      $this->session->set_flashdata('titulo_retorno_funcao', 'Algo deu errado!');
      $this->session->set_flashdata('tipo_retorno_funcao', 'error');
      $this->session->set_flashdata('redirect_retorno_funcao', '#');
      $this->session->set_flashdata('texto_retorno_funcao', 'Falha ao cadastrar o(s) documento(s)!');
    }
  }

  public function deletaEtiqueta()
  {
  }
}

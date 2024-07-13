<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DocumentoEmpresa extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    // Carregamento da biblioteca de controle de sessão
    $this->load->library('Controle_sessao');

    // Verificação e controle da sessão do usuário
    $res = $this->controle_sessao->controle();
    if ($res == 'erro') {
      // Se a requisição for AJAX, retorna status 403
      if ($this->input->is_ajax_request()) {
        $this->output->set_status_header(403);
        exit();
      } else {
        // Redireciona para a página de erro de login se não for AJAX
        redirect('login/erro', 'refresh');
      }
    }

    // Carregamento do modelo necessário para operações com documentos da empresa
    $this->load->model('DocumentoEmpresa_model');
  }

  /**
   * Função para carregar a página principal de documentos da empresa.
   */
  public function index()
  {
    // Scripts padrão a serem carregados no cabeçalho e rodapé
    $scriptsPadraoHead = scriptsPadraoHead();
    $scriptsPadraoFooter = scriptsPadraoFooter();

    // Scripts específicos para documentos da empresa
    $scriptsDocumentoEmpresaFooter = scriptsDocumentoEmpresaFooter();

    // Adiciona os scripts necessários ao cabeçalho e rodapé
    add_scripts('header', array_merge($scriptsPadraoHead));
    add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsDocumentoEmpresaFooter));

    // Obtém todos os documentos da empresa para exibição na página
    $data['documentos'] = $this->DocumentoEmpresa_model->recebeDocumentosEmpresa();

    // Carrega as partes da página: cabeçalho, página principal de documentos e rodapé
    $this->load->view('admin/includes/painel/cabecalho', $data);
    $this->load->view('admin/paginas/documento-empresa/documento-empresa');
    $this->load->view('admin/includes/painel/rodape');
  }

  /**
   * Função para exibir o formulário de cadastro ou edição de documentos da empresa.
   */
  public function formulario()
  {
    // Scripts padrão a serem carregados no cabeçalho e rodapé
    $scriptsPadraoHead = scriptsPadraoHead();
    $scriptsPadraoFooter = scriptsPadraoFooter();

    // Scripts específicos para documentos da empresa
    $scriptsDocumentoEmpresaFooter = scriptsDocumentoEmpresaFooter();

    // Adiciona os scripts necessários ao cabeçalho e rodapé
    add_scripts('header', array_merge($scriptsPadraoHead));
    add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsDocumentoEmpresaFooter));

    // Obtém o ID do documento da URL para edição, se existir
    $id = $this->uri->segment(3);

    // Obtém os dados do documento específico para preencher o formulário
    $data['documento'] = $this->DocumentoEmpresa_model->recebeDocumentoEmpresa($id);

    // Carrega as partes da página: cabeçalho, formulário de cadastro/edição e rodapé
    $this->load->view('admin/includes/painel/cabecalho', $data);
    $this->load->view('admin/paginas/documento-empresa/cadastra-documento-empresa');
    $this->load->view('admin/includes/painel/rodape');
  }

  /**
   * Função para cadastrar ou editar um documento da empresa.
   */
  public function cadastraDocumentoEmpresa()
  {
    // Carregamento da biblioteca de upload de imagens
    $this->load->library('Upload_imagem');

    // Obtém os dados do formulário
    $id = $this->input->post('id');
    $nome_documento = $this->input->post('nome');
    $vencimento_documento = $this->input->post('validade');
    $id_empresa = $this->session->userdata('id_empresa');

    // Verificar se o nome do documento já existe
    $documentoExistente = $this->DocumentoEmpresa_model->recebeDocumentoNome($nome_documento, $id);

    if ($documentoExistente) {
      $response = array(
        'success' => false,
        'message' => 'Um documento com este nome já foi cadastrado, tente novamente.'
      );
      return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    // Prepara o upload do documento
    if ($_FILES) {
      $_FILES['single_document'] = $_FILES['documento'];
      $arrayUpload = [
        'single_document' => ['documentos-empresa', null]
      ];
      $retornoDados = $this->upload_imagem->uploadImagem($arrayUpload);
    }

    $documento_antigo = $this->DocumentoEmpresa_model->recebeDocumentoEmpresa($id);

    // Prepara os dados para inserção ou edição
    $dados = [
      'nome' => $nome_documento,
      'validade' => $vencimento_documento,
      'documento' => $_FILES ? $retornoDados['single_document'] : $documento_antigo['documento'],
      'id_empresa' => $id_empresa
    ];

    // Se estiver editando, obtém o nome do documento antigo para exclusão posterior
    $nome_documento_antigo = null;

    if ($id) {
      $nome_documento_antigo = $documento_antigo['documento'];
    }

    // Insere ou edita o documento no banco de dados
    $retorno = $id ? $this->DocumentoEmpresa_model->editaDocumentoEmpresa($id, $dados) : $this->DocumentoEmpresa_model->insereDocumentoEmpresa($dados);

    // Verifica se a operação foi bem sucedida
    if ($retorno) {
      // Exclui o documento antigo, se existir e estiver editando
      if ($id && $nome_documento_antigo && $_FILES) {
        $caminho = './uploads/' . $id_empresa . '/' . 'documentos-empresa/' . $nome_documento_antigo;
        unlink($caminho);
      }

      // Resposta de sucesso
      $response = array(
        'success' => true,
        'message' => $id ? 'Documento editado com sucesso!' : 'Documento cadastrado com sucesso!'
      );
    } else {
      // Resposta de erro
      $response = array(
        'success' => false,
        'message' => $id ? 'Erro ao editar documento!' : 'Erro ao cadastrar documento!'
      );
    }

    // Retorna a resposta em formato JSON
    return $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }

  /**
   * Função para receber os detalhes de um documento específico via AJAX.
   */
  public function recebeDocumentoEmpresa()
  {
    // Obtém o ID do documento enviado via POST
    $id = $this->input->post('id');

    // Obtém os detalhes do documento específico do banco de dados
    $response = $this->DocumentoEmpresa_model->recebeDocumentoEmpresa($id);

    // Retorna os detalhes do documento em formato JSON
    return $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }

  /**
   * Função para deletar um documento da empresa.
   */
  public function deletaDocumentoEmpresa()
  {
    // Obtém o ID do documento enviado via POST
    $id = $this->input->post('id');

    // Obtém o nome do documento para exclusão física
    $nome_documento = $this->DocumentoEmpresa_model->recebeDocumentoEmpresa($id);

    // Deleta o documento do banco de dados
    $retorno = $this->DocumentoEmpresa_model->deletaDocumentoEmpresa($id);

    // Define o caminho do documento físico para exclusão
    $caminho = './uploads/' . $this->session->userdata('id_empresa') . '/' . 'documentos-empresa/' . $nome_documento['documento'];

    // Tenta deletar o documento físico
    $deletou_imagem = unlink($caminho);

    // Verifica se houve erro ao deletar a imagem na pasta
    if (!$deletou_imagem) {
      $response = array(
        'success' => false,
        'title' => 'Erro!',
        'message' => 'Nenhum documento encontrado, informações restantes removidas do banco de dados.',
        'type' => "error"
      );
    }

    // Verifica se a operação de deletar do banco foi bem sucedida
    if ($retorno) {
      // Resposta de sucesso
      $response = array(
        'success' => true,
        'title' => "Sucesso!",
        'message' => "Documento deletado com sucesso!",
        'type' => "success"
      );
    } else {
      // Resposta de erro
      $response = array(
        'success' => false,
        'title' => "Algo deu errado!",
        'message' => "Não foi possível deletar o documento!",
        'type' => "error"
      );
    }

    // Retorna a resposta em formato JSON
    return $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }
}

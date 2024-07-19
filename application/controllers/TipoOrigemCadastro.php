<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TipoOrigemCadastro extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    // INICIO controle sessão
    $this->load->library('Controle_sessao');
    $res = $this->controle_sessao->controle();
    if ($res === 'erro') {
      if ($this->input->is_ajax_request()) {
        $this->output->set_status_header(403);
        exit();
      } else {
        redirect('login/erro', 'refresh');
      }
    }
    // FIM controle sessão

    // Carregando o modelo TipoOrigemCadastro_model
    $this->load->model('TipoOrigemCadastro_model');
  }

  /**
   * Carrega a página inicial de Tipo Origem de Cadastro.
   * Inclui scripts padrão e específicos da página.
   */
  public function index()
  {
    // Scripts padrão
    $scriptsPadraoHead = scriptsPadraoHead();
    $scriptsPadraoFooter = scriptsPadraoFooter();

    // Scripts para Tipo Origem de Cadastro
    $scriptsTipoOrigemCadastroFooter = scriptsTipoOrigemCadastroFooter();

    // Adicionando scripts ao header e footer
    add_scripts('header', array_merge($scriptsPadraoHead));
    add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsTipoOrigemCadastroFooter));

    // Obtendo todos os Tipo Origem de Cadastro
    $data['tiposOrigemCadastros'] = $this->TipoOrigemCadastro_model->recebeTiposOrigemCadastros();

    // Carregando as views com os dados
    $this->load->view('admin/includes/painel/cabecalho', $data);
    $this->load->view('admin/paginas/tipo-origem-cadastro/tipo-origem-cadastro');
    $this->load->view('admin/includes/painel/rodape');
  }

  /**
   * Carrega o formulário de cadastro/edição de Tipo Origem de Cadastro.
   * Inclui scripts padrão e específicos da página.
   */
  public function formulario()
  {
    // Scripts padrão
    $scriptsPadraoHead = scriptsPadraoHead();
    $scriptsPadraoFooter = scriptsPadraoFooter();

    // Scripts para Tipo Origem de Cadastro
    $scriptsTipoOrigemCadastroFooter = scriptsTipoOrigemCadastroFooter();

    // Adicionando scripts ao header e footer
    add_scripts('header', array_merge($scriptsPadraoHead));
    add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsTipoOrigemCadastroFooter));

    // Obtendo o ID do tipo de origem de cadastro da URL
    $id = $this->uri->segment(3);

    // Obtendo o tipo de origem de cadastro específico
    $data['tipoOrigemCadastro'] = $this->TipoOrigemCadastro_model->recebeTipoOrigemCadastro($id);

    // Carregando as views com os dados
    $this->load->view('admin/includes/painel/cabecalho', $data);
    $this->load->view('admin/paginas/tipo-origem-cadastro/cadastra-tipo-origem-cadastro');
    $this->load->view('admin/includes/painel/rodape');
  }

  /**
   * Processa o cadastro ou edição de um Tipo de Origem de Cadastro.
   * Verifica se o nome do Tipo de Origem de Cadastro já existe e insere ou edita conforme necessário.
   * Retorna uma resposta JSON para o JavaScript do lado do cliente.
   */
  public function cadastraTipoOrigemCadastro()
  {
    // Obtendo o ID do tipo de origem de cadastro do formulário
    $id = (int) $this->input->post('id');

    // Preparando os dados para inserção/edição
    $dados['nome'] = trim(mb_convert_case($this->input->post('nome'), MB_CASE_TITLE, 'UTF-8'));
    $dados['id_empresa'] = (int) $this->session->userdata('id_empresa');

    // Verificando se o tipo de origem de cadastro já existe
    $tipoOrigemCadastro = $this->TipoOrigemCadastro_model->recebeNomeTipoOrigemCadastro($dados['nome'], $id);

    if ($tipoOrigemCadastro) {
      // Resposta caso o tipo de origem de cadastro já exista
      $response = array(
        'title' => "Algo deu errado!",
        'type' => "error",
        'success' => false,
        'message' => "Este Tipo de Origem de Cadastro já existe! Tente cadastrar um diferente."
      );

      return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    // Inserindo ou editando o tipo de origem de cadastro
    $retorno = $id ? $this->TipoOrigemCadastro_model->editaTipoOrigemCadastro($id, $dados) : $this->TipoOrigemCadastro_model->insereTipoOrigemCadastro($dados);

    if ($retorno) {
      // Resposta de sucesso
      $response = array(
        'success' => true,
        'title' => 'Sucesso!',
        'message' => $id ? 'Tipo de Origem de Cadastro editado com sucesso!' : 'Tipo de Origem de Cadastro cadastrado com sucesso!',
        'type' => 'success'
      );
    } else {
      // Resposta de erro
      $response = array(
        'success' => false,
        'title' => 'Algo deu errado!',
        'message' => $id ? "Erro ao editar o Tipo de Origem de Cadastro!" : "Erro ao cadastrar o Tipo de Origem de Cadastro!",
        'type' => 'error'
      );
    }

    return $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }

  /**
   * Processa a exclusão de um Tipo de Origem de Cadastro.
   * Retorna uma resposta JSON para o JavaScript do lado do cliente.
   */
  public function deletaTipoOrigemCadastro()
  {
    // Obtendo o ID do tipo de origem de cadastro do formulário
    $id = (int) $this->input->post('id');

    // Deletando o tipo de origem de cadastro
    $retorno = $this->TipoOrigemCadastro_model->deletaTipoOrigemCadastro($id);

    if ($retorno) {
      // Resposta de sucesso
      $response = array(
        'success' => true,
        'title' => "Sucesso!",
        'message' => "Tipo de Origem de Cadastro deletado com sucesso!",
        'type' => "success"
      );
    } else {
      // Resposta de erro
      $response = array(
        'success' => false,
        'title' => "Algo deu errado!",
        'message' => "Não foi possível deletar o Tipo de Origem de Cadastro!",
        'type' => "error"
      );
    }

    return $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }
}

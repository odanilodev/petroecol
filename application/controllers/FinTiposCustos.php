<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinTiposCustos extends CI_Controller
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

    // Carregando o modelo FinTiposCustos_model
    $this->load->model('FinTiposCustos_model');
  }

  /**
   * Carrega a página inicial de Tipos de Custos.
   * Inclui scripts padrão e específicos da página.
   */
  public function index()
  {
    // Scripts padrão
    $scriptsPadraoHead = scriptsPadraoHead();
    $scriptsPadraoFooter = scriptsPadraoFooter();

    // Scripts para Tipos de Custos
    $scriptsFinTiposCustosFooter = scriptsFinTiposCustosFooter();

    // Adicionando scripts ao header e footer
    add_scripts('header', array_merge($scriptsPadraoHead));
    add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinTiposCustosFooter));

    // Obtendo todos os tipos de custos
    $data['tiposCustos'] = $this->FinTiposCustos_model->recebeTiposCustos();

    // Carregando as views com os dados
    $this->load->view('admin/includes/painel/cabecalho', $data);
    $this->load->view('admin/paginas/financeiro/tipos-custos/tipos-custos');
    $this->load->view('admin/includes/painel/rodape');
  }

  /**
   * Carrega o formulário de cadastro/edição de Tipo de Custo.
   * Inclui scripts padrão e específicos da página.
   */
  public function formulario()
  {
    // Scripts padrão
    $scriptsPadraoHead = scriptsPadraoHead();
    $scriptsPadraoFooter = scriptsPadraoFooter();

    // Scripts para Tipos de Custos
    $scriptsFinTiposCustosFooter = scriptsFinTiposCustosFooter();

    // Adicionando scripts ao header e footer
    add_scripts('header', array_merge($scriptsPadraoHead));
    add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinTiposCustosFooter));

    // Obtendo o ID do tipo de custo da URL
    $id = $this->uri->segment(3);

    // Obtendo o tipo de custo específico
    $data['tipoCusto'] = $this->FinTiposCustos_model->recebeTipoCusto($id);

    // Carregando as views com os dados
    $this->load->view('admin/includes/painel/cabecalho', $data);
    $this->load->view('admin/paginas/financeiro/tipos-custos/cadastra-tipos-custos');
    $this->load->view('admin/includes/painel/rodape');
  }

  /**
   * Processa o cadastro ou edição de um Tipo de Custo.
   * Verifica se o nome do Tipo de Custo já existe e insere ou edita conforme necessário.
   * Retorna uma resposta JSON para o JavaScript do lado do cliente.
   *
   */
  public function cadastraTipoCusto()
  {
    // Obtendo o ID do tipo de custo do formulário
    $id = (int) $this->input->post('id');

    // Preparando os dados para inserção/edição
    $dados['nome'] = trim(mb_convert_case($this->input->post('nome'), MB_CASE_TITLE, 'UTF-8'));
    $dados['id_empresa'] = (int) $this->session->userdata('id_empresa');

    // Verificando se o tipo de custo já existe
    $tipoCusto = $this->FinTiposCustos_model->recebeTipoCustoNome($dados['nome'], $id);

    if ($tipoCusto) {
      // Resposta caso o tipo de custo já exista
      $response = array(
        'title' => "Algo deu errado!",
        'type' => "error",
        'success' => false,
        'message' => "Este Tipo de Custo já existe! Tente cadastrar um diferente."
      );

      return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    // Inserindo ou editando o tipo de custo
    $retorno = $id ? $this->FinTiposCustos_model->editaTipoCusto($id, $dados) : $this->FinTiposCustos_model->insereTipoCusto($dados);

    if ($retorno) {
      // Resposta de sucesso
      $response = array(
        'success' => true,
        'title' => 'Sucesso!',
        'message' => $id ? 'Tipo de Custo editado com sucesso!' : 'Tipo de Custo cadastrado com sucesso!',
        'type' => 'success'
      );
    } else {
      // Resposta de erro
      $response = array(
        'success' => false,
        'title' => 'Algo deu errado!',
        'message' => $id ? "Erro ao editar o Tipo de Custo!" : "Erro ao cadastrar o Tipo de Custo!",
        'type' => 'error'
      );
    }

    return $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }

  /**
   * Processa a exclusão de um Tipo de Custo.
   * Retorna uma resposta JSON para o JavaScript do lado do cliente.
   *
   */
  public function deletaTipoCusto()
  {
    // Obtendo o ID do tipo de custo do formulário
    $id = (int) $this->input->post('id');

    // Deletando o tipo de custo
    $retorno = $this->FinTiposCustos_model->deletaTipoCusto($id);

    if ($retorno) {
      // Resposta de sucesso
      $response = array(
        'success' => true,
        'title' => "Sucesso!",
        'message' => "Tipo de Custo deletado com sucesso!",
        'type' => "success"
      );
    } else {
      // Resposta de erro
      $response = array(
        'success' => false,
        'title' => "Algo deu errado!",
        'message' => "Não foi possível deletar o Tipo de Custo!",
        'type' => "error"
      );
    }

    return $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }
}

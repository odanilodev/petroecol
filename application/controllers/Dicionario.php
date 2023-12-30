<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dicionario extends CI_Controller
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

    $this->load->model('Dicionario_model');
  }

  public function chavesGlobais($page = 1)
  {
    // scripts padrão
    $scriptsPadraoHead = scriptsPadraoHead();
    $scriptsPadraoFooter = scriptsPadraoFooter();

    // scripts para Dicionario
    $scriptsDicionarioFooter = scriptsDicionarioFooter();
    $scriptsDicionarioHead = scriptsDicionarioHead();

    add_scripts('header', array_merge($scriptsPadraoHead, $scriptsDicionarioHead));
    add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsDicionarioFooter));

    $this->load->helper('cookie');

    if ($this->input->post()) {
      $this->input->set_cookie('filtro_dicionario', json_encode($this->input->post()), 3600);
    }

    if (is_numeric($page)) {
      $cookie_filtro_dicionario = count($this->input->post()) > 0 ? json_encode($this->input->post()) : $this->input->cookie('filtro_dicionario');
    } else {
      $page = 1;
      delete_cookie('filtro_dicionario');
      $cookie_filtro_dicionario = json_encode([]);
    }

    $data['cookie_filtro_dicionario'] = json_decode($cookie_filtro_dicionario, true);

    // >>>> PAGINAÇÃO <<<<<
    $limit = 12; // Número de chaves por página
    $this->load->library('pagination');
    $config['base_url'] = base_url('dicionario/chavesGlobais');
    $config['total_rows'] = $this->Dicionario_model->recebeDicionarioGlobal($cookie_filtro_dicionario, $limit, $page, true); // true para contar
    $config['per_page'] = $limit;
    $config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
    $this->pagination->initialize($config);
    // >>>> FIM PAGINAÇÃO <<<<<

    $data['dicionarioGlobal'] = $this->Dicionario_model->recebeDicionarioGlobal($cookie_filtro_dicionario, $limit, $page);

    $this->load->view('admin/includes/painel/cabecalho', $data);
    $this->load->view('admin/paginas/dicionarios/dicionarioglobal');
    $this->load->view('admin/includes/painel/rodape');
  }

  public function formulario()
  {
    // scripts padrão
    $scriptsPadraoHead = scriptsPadraoHead();
    $scriptsPadraoFooter = scriptsPadraoFooter();

    // scripts para Dicionario
    $scriptsDicionarioFooter = scriptsDicionarioFooter();

    add_scripts('header', array_merge($scriptsPadraoHead));
    add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsDicionarioFooter));

    $this->load->view('admin/includes/painel/cabecalho');
    $this->load->view('admin/paginas/dicionarios/cadastra-dicionario-global');
    $this->load->view('admin/includes/painel/rodape');
  }

  public function cadastraDicionarioGlobal()
  {
    $id = $this->input->post('id') ?? null;
    //recebe e transforma as informações do js.serialize e as compila em arrays
    parse_str($this->input->post('dadosDicionario'), $array);

    //abre um array para receber informações
    $duplicadas = [];

    //percorre cada valor na  $array criado pelo serialize e caso ele exista no banco, preenche o array 'duplicada' com seu(s) valor(es).
    foreach ($array['chave'] as $chave) {

      $retorno = $this->Dicionario_model->recebeDicionarioGlobalChave(mb_strtolower($chave), $id);

      if ($retorno) {
        $duplicadas[] = $chave;
      }
    }

    //caso encontre valores já existentes -> retorna os valores repetidos para tratamento no front
    if (count($duplicadas)) {
      $response = array(
        'success' => false,
        'message' => count($duplicadas) > 1 ? implode(', ', $duplicadas) . ' já existem' : $duplicadas[0] . ' já existe'
      );

      return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    //percorre de acordo com o numero de chaves no array e grava cada valor simultaneamente no banco caso não estejam repetidos
    for ($i = 0; $i < count($array['chave']); $i++) {

      $dados['chave'] = mb_strtolower($array['chave'][$i]);
      $dados['valor_ptbr'] = mb_strtolower($array['valor-ptbr'][$i]);
      $dados['valor_en'] = mb_strtolower($array['valor-en'][$i]);

      !$id ? $this->Dicionario_model->insereDicionarioGlobal($dados) : $this->Dicionario_model->editaDicionarioGlobal($id, $dados);
    }

    $response = array(
      'success' => true,
      'message' => $id ? "Chave editada com sucesso" : "Chave cadastrada com sucesso! "
    );

    return $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }

  public function deletaDicionarioGlobal()
  {
    $id = $this->input->post('id');

    $retorno = $this->Dicionario_model->deletaDicionarioGlobal($id);

    if ($retorno) {
      $response = array(
        'success' => true,
        'title' => "Sucesso!",
        'message' => "Dicionário deletado com sucesso!",
        'type' => "success"
      );
    } else {

      $response = array(
        'success' => false,
        'title' => "Algo deu errado!",
        'message' => "Não foi possivel deletar o Dicionário!",
        'type' => "error"
      );
    }
    return $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }

  public function recebeIdDicionarioGlobal()
  {
    $id = $this->input->post('id');
    $dicionario = $this->Dicionario_model->recebeIdDicionarioGlobal($id);

    $response = array(
      'dicionario' => $dicionario
    );

    return $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }
}

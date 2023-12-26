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
		}else{
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

		$id = $this->uri->segment(3);

		$data['dicionarioGlobal'] = $this->Dicionario_model->recebeIdDicionarioGlobal($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/dicionarios/cadastra-dicionario-global');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraDicionarioGlobal()
	{
		$id = $this->input->post('id');
		$dados['chave'] = $this->input->post('chave');
		$dados['valor_ptbr'] = $this->input->post('valor_ptbr');
		$dados['valor_en'] = $this->input->post('valor_en');

		$dicionarioGlobalChave = $this->Dicionario_model->recebeDicionarioGlobalChave($dados['chave']); // verifica se já existe a Dicionario

		// Verifica se a Dicionario já existe e se não é a Dicionario que está sendo editada
		if ($dicionarioGlobalChave && $dicionarioGlobalChave['id'] != $id) {

			$response = array(
				'success' => false,
				'message' => "Este Dicionario já existe! Tente cadastrar uma diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->Dicionario_model->editaDicionarioGlobal($id, $dados) : $this->Dicionario_model->insereDicionarioGlobal($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Dicionario editado com sucesso!' : 'Dicionario cadastrado com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar Dicionario!" : "Erro ao cadastrar Dicionario!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletaDicionarioGlobal()
	{
		$id = $this->input->post('id');

		$this->load->model('Dicionario_model');

		$this->Dicionario_model->deletaDicionarioGlobal($id);
	}
}

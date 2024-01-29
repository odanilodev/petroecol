<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grupos extends CI_Controller
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

		$this->load->model('Grupos_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para Grupo Clientes
		$scriptsGruposFooter = scriptsGruposFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsGruposFooter));

		$data['grupos'] = $this->Grupos_model->recebeGrupos();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/grupos/grupos');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para Grupo Clientes
		$scriptsGruposFooter = scriptsGruposFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsGruposFooter));

		$id = $this->uri->segment(3);

		$data['grupo'] = $this->Grupos_model->recebeGrupo($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/grupos/cadastra-grupo');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraGrupo()
	{
		$id = $this->input->post('id');

		$nome = $this->input->post('nome');
		$dados['nome'] = trim(mb_convert_case($nome, MB_CASE_TITLE, 'UTF-8'));
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$grupos = $this->Grupos_model->recebeNomeGrupo($dados['nome'], $id); // verifica se já existe o Grupo de Cliente

		// Verifica se o Grupo de Cliente já existe e se não é o Grupo de Cliente que está sendo editada
		if ($grupos) {

			$response = array(
				'title' => "Algo deu errado!",
				'type' => "error",
				'success' => false,
				'message' => "Este Grupo de Clientes já existe! Tente cadastrar um diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->Grupos_model->editaGrupo($id, $dados) : $this->Grupos_model->insereGrupo($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Grupo de Clientes editado com sucesso!' : 'Grupo de Clientes cadastrado com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o Grupo de Clientes!" : "Erro ao cadastrar o Grupo de Clientes!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaGrupo()
	{

		$id = $this->input->post('id');

		$retorno = $this->Grupos_model->deletaGrupo($id);

		if ($retorno) {

				$response = array(
					'success' => true,
					'title' => "Sucesso!",
					'message' => "Grupo de Clientes deletado com sucesso!",
					'type' => "success"
				);
		} else {

				$response = array(
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Não foi possivel deletar o Grupo de Clientes!",
					'type' => "error"
				);
			}

      return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
  }



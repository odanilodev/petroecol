<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinMacro extends CI_Controller
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
		$this->load->model('FinMacro_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para macros
		$scriptsFinMacroFooter = scriptsFinMacroFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinMacroFooter));

		$data['macros'] = $this->FinMacro_model->recebeMacros();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/macro/macro');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para macros
		$scriptsFinMacroFooter = scriptsFinMacroFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinMacroFooter));

		$id = $this->uri->segment(3);

		$data['macro'] = $this->FinMacro_model->recebeMacro($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/macro/cadastra-macro');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraMacro()
	{
		$id = $this->input->post('id');

		$dados['nome'] = $this->input->post('nomeMacro');

		$dados['id_empresa'] = $this->session->userdata('id_empresa');


		$macro = $this->FinMacro_model->recebeNomeMacro($dados['nome'], $id); // verifica se já existe o macro

		// Verifica se o macro já existe e se não é o macro que está sendo editada
		if ($macro) {

			$response = array(
				'success' => false,
				'message' => "Este Macro já existe! Tente cadastrar um diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->FinMacro_model->editaMacro($id, $dados) : $this->FinMacro_model->insereMacro($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Macro editado com sucesso!' : 'Macro cadastrado com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o Macro!" : "Erro ao cadastrar o Macro!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaMacro()
	{
		$this->load->model('FinMacro_model');

		$id = $this->input->post('id');

		// Verifica se o residuo esta vinculado a um cliente
		$residuoVinculadoCliente = $this->FinMacro_model->verificaMicroMacro($id);

		if ($residuoVinculadoCliente) {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não é possível deletar este Macro pois existem Micros vinculados a ele.",
				'type' => "error"
			);
		} else {

			$retorno = $this->FinMacro_model->deletaMacro($id);

			if ($retorno) {
				$response = array(
					'success' => true,
					'title' => "Sucesso!",
					'message' => "Macro deletado com sucesso!",
					'type' => "success"
				);
			} else {

				$response = array(
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Não foi possivel deletar o Macro!",
					'type' => "error"
				);
			}
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

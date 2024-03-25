<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinMicro extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// INICIO controle sessão
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
		$this->load->model('FinMicro_model');
		$this->load->model('FinMacro_model');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para micros
		$scriptsFinMicroFooter = scriptsFinMicroFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinMicroFooter));

		$id = $this->uri->segment(3);

		$data['micros'] = $this->FinMicro_model->recebeMicros($id);

		$data['macro'] = $this->FinMacro_model->recebeMacro($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/macro/cadastra-micro');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraMicro()
	{

		$id_micro = $this->input->post('idMicro');
		$id_macro = $this->input->post('idMacro');

		$dados['nome'] = !empty($this->input->post('nomeMicroModal')) ? $this->input->post('nomeMicroModal') : $this->input->post('nomeMicro');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		// Se não, estamos cadastrando um novo micro
		$micro = $this->FinMicro_model->recebeNomeMicro($dados['nome'], $id_macro); // verifica se já existe o micro

		// Verifica se o micro já existe
		if ($micro) {
			$response = array(
				'success' => false,
				'message' => "Este Micro já existe! Tente cadastrar um diferente."
			);
			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		// Verifica se o ID do micro foi fornecido
		if ($id_micro) {
			// Se sim, estamos editando, então apenas atualizamos os dados
			$retorno = $this->FinMicro_model->editaMicro($id_micro, $id_macro, $dados);
		} else {
			// Insere o novo micro
			$dados['id'] = $id_micro;
			$dados['id_macro'] = $id_macro;
			$retorno = $this->FinMicro_model->insereMicro($dados);
		}

		// Verifica se a operação foi bem-sucedida
		if ($retorno) {
			$message = $id_micro ? "Micro editado com sucesso!" : "Micro cadastrado com sucesso!";
			$response = array(
				'success' => true,
				'message' => $message
			);
		} else {
			$message = $id_micro ? "Erro ao editar o Micro!" : "Erro ao cadastrar o micro!";
			$response = array(
				'success' => false,
				'message' => $message
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletaMicro()
	{
		$id_micro = $this->input->post('idMicro');
		$id_macro = $this->input->post('idMacro');

		$retorno = $this->FinMicro_model->deletaMicro($id_micro, $id_macro);

		if ($retorno) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Micro deletado com sucesso!",
				'type' => "success"
			);
		} else {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possível deletar o Micro!",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function recebeIdMicro()
	{
		$id = $this->input->post('idMicro');

		$micro = $this->FinMicro_model->recebeIdMicro($id);

		$response = array(
			'micro' => $micro
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

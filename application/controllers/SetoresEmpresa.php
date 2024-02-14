<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SetoresEmpresa extends CI_Controller
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

		$this->load->model('SetoresEmpresa_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para setores
		$scriptsSetoresEmpresaFooter = scriptsSetoresEmpresaFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsSetoresEmpresaFooter));

		$data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/setores-empresa/setores-empresa');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para setores
		$scriptsSetoresEmpresaFooter = scriptsSetoresEmpresaFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsSetoresEmpresaFooter));

		$id = $this->uri->segment(3);

		$data['setorEmpresa'] = $this->SetoresEmpresa_model->recebeSetorEmpresa($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/setores-empresa/cadastra-setor-empresa');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraSetorEmpresa()
	{
		$id = $this->input->post('id');
		$nomeSetorEmpresa = $this->input->post('nomeSetorEmpresa');

		$dados['nome'] = trim(mb_convert_case($nomeSetorEmpresa, MB_CASE_TITLE, 'UTF-8'));
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$setorEmpresa = $this->SetoresEmpresa_model->recebeSetorEmpresaNome($dados['nome'], $id); // verifica se já existe o setor da empresa

		// Verifica se o setor da empresa já existe e se não é o setor da empresa que está sendo editada
		if ($setorEmpresa) {

			$response = array(
				'title' => "Algo deu errado!",
				'type' => "error",
				'success' => false,
				'message' => "Este setor de empresa já existe! Tente cadastrar um diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->SetoresEmpresa_model->editaSetorEmpresa($id, $dados) : $this->SetoresEmpresa_model->insereSetorEmpresa($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Setor de empresa editado com sucesso!' : 'Setor de empresa cadastrado com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o setor de empresa!" : "Erro ao cadastrar o setor de empresa!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaSetorEmpresa()
	{
		$this->load->model('Clientes_model');

		$id = $this->input->post('id');


		$retorno = $this->SetoresEmpresa_model->deletaSetorEmpresa($id);

		if ($retorno) {

			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Setor de empresa deletado com sucesso!",
				'type' => "success"
			);
		} else {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possivel deletar o setor de empresa!",
				'type' => "error"
			);
		}


		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

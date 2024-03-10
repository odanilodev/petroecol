<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinFornecedores extends CI_Controller
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
		$this->load->model('FinFornecedores_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para fornecedores
		$scriptsFinFornecedoresFooter = scriptsFinFornecedoresFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinFornecedoresFooter));

		$data['fornecedores'] = $this->FinFornecedores_model->recebeFornecedores();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/fin-fornecedores/fin-fornecedores');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para fornecedors
		$scriptsFinFornecedoresFooter = scriptsFinFornecedoresFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinFornecedoresFooter));

		$id = $this->uri->segment(3);

		$data['fornecedor'] = $this->FinFornecedores_model->recebeFornecedor($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/fin-fornecedores/cadastra-fin-fornecedores');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraFornecedor()
	{
		$id = $this->input->post('id');

		$dados['nome_empresa'] = $this->input->post('nomeEmpresa');
		$dados['nome_contato'] = $this->input->post('nomeContato');
		$dados['telefone'] = $this->input->post('telefone');
		$dados['cnpj'] = $this->input->post('cnpj');
		$dados['estado'] = $this->input->post('estado');
		$dados['cidade'] = $this->input->post('cidade');
		$dados['rua'] = $this->input->post('rua');
		$dados['conta_bancaria'] = $this->input->post('contaBancaria');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$nomeEmpresaFornecedor = $this->FinFornecedores_model->recebeNomeEmpresaFornecedor($dados['nome_empresa'], $id); // verifica se já existe o fornecedor

		// Verifica se o fornecedor já existe e se não é o fornecedor que está sendo editada
		if ($nomeEmpresaFornecedor) {

			$response = array(
				'success' => false,
				'message' => "Este Fornecedor já existe! Tente cadastrar um diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->FinFornecedores_model->editaFornecedor($id, $dados) : $this->FinFornecedores_model->insereFornecedor($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Fornecedor editado com sucesso!' : 'Fornecedor cadastrado com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o Fornecedor!" : "Erro ao cadastrar o Fornecedor!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaFornecedor()
	{

		$id = $this->input->post('id');

		$retorno = $this->FinFornecedores_model->deletaFornecedor($id);

		if ($retorno) {

			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Fornecedor deletado com sucesso!",
				'type' => "success"
			);
		} else {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possivel deletar o fornecedor!",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

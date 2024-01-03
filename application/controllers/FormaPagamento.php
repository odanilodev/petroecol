<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FormaPagamento extends CI_Controller
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

		$this->load->model('FormaPagamento_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para etiquetas
		$scriptsFormaPagamentoFooter = scriptsFormaPagamentoFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFormaPagamentoFooter));

		$data['formaPagamento'] = $this->FormaPagamento_model->recebeFormasPagamento();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/forma-pagamento/forma-pagamento');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para etiquetas
		$scriptsFormaPagamentoFooter = scriptsFormaPagamentoFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFormaPagamentoFooter));

		$id = $this->uri->segment(3);

		$data['forma_pagamento'] = $this->FormaPagamento_model->recebeFormaPagamento($id);
		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/forma-pagamento/cadastra-forma-pagamento');
		$this->load->view('admin/includes/painel/rodape');
	}
	public function cadastraFormaPagamento()
	{
		$id = $this->input->post('id');
		$forma_pagamento = $this->input->post('formaPagamento');
		$dados['forma_pagamento'] = mb_convert_case($forma_pagamento, MB_CASE_TITLE, 'UTF-8');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$formaPagamento = $this->FormaPagamento_model->recebeFormaPagamentoNome($dados['forma_pagamento']); // verifica se já existe a forma de pagamento

		// Verifica se a forma de pagamento já existe e se não é a forma de pagamento que está sendo editada
		if ($formaPagamento && $formaPagamento['id'] != $id) {

			$response = array(
				'success' => false,
				'message' => "Esta forma de pagamento já existe! Tente cadastrar uma diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->FormaPagamento_model->editaFormaPagamento($id, $dados) : $this->FormaPagamento_model->insereFormaPagamento($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Forma de pagamento editada com sucesso!' : 'Forma de pagamento cadastrada com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar a forma de pagamento!" : "Erro ao cadastrar a forma de pagamento!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletaFormaPagamento()
	{
		$this->load->model('Clientes_model');

		$id = $this->input->post('id');

		// Verifica se a forma de pagamento esta vinculada a um cliente
		$formaPagamentoVinculadaCliente = $this->Clientes_model->verificaFormaPagamentoCliente($id);

		if ($formaPagamentoVinculadaCliente) {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Esta forma de pagamento está vinculada a um cliente, não é possível excluí-la.",
				'type' => "error"
			);
		} else {

			$retorno = $this->FormaPagamento_model->deletaFormaPagamento($id);

			if ($retorno) {

				$response = array(
					'success' => true,
					'title' => "Sucesso!",
					'message' => "Forma de pagamento deletada com sucesso!",
					'type' => "success"
				);
			} else {

				$response = array(
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Não foi possivel deletar a forma de pagamento!",
					'type' => "error"
				);
			}
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

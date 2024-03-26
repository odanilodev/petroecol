<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinTarifasBancarias extends CI_Controller
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
		$this->load->model('FinTarifasBancarias_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para tarifas bancarias
		$scriptsFinTarifasBancariasHead = scriptsFinTarifasBancariasHead();
		$scriptsFinTarifasBancariasFooter = scriptsFinTarifasBancariasFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsFinTarifasBancariasHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinTarifasBancariasFooter));

		$data['tarifas'] = $this->FinTarifasBancarias_model->recebeTarifasBancarias();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/tarifas-bancarias/tarifas-bancarias');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para tarifa bancarias
		$scriptsFinTarifasBancariasHead = scriptsFinTarifasBancariasHead();
		$scriptsFinTarifasBancariasFooter = scriptsFinTarifasBancariasFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsFinTarifasBancariasHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinTarifasBancariasFooter));

		$id = $this->uri->segment(3);

		$data['tarifa'] = $this->FinTarifasBancarias_model->recebeTarifaBancaria($id);

		$this->load->model('FinFormaTransacao_model');
		$data['formasTransacao'] = $this->FinFormaTransacao_model->recebeFormasTransacao();

		$this->load->model('FinContaBancaria_model');
		$data['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/tarifas-bancarias/cadastra-tarifas-bancarias');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraTarifaBancaria()
	{
		$id = $this->input->post('id');

		$dados['nome_tarifa'] = $this->input->post('nomeTarifa');
		$dados['id_conta_bancaria'] = $this->input->post('idContaBancaria');
		$dados['id_forma_transacao'] = $this->input->post('idFormaTransacao');
		$dados['tipo_tarifa'] = $this->input->post('tipoTarifa');
		$dados['valor_minimo_tarifa'] = $this->input->post('valorMinimoTarifa');
		$dados['valor_tarifa'] = $this->input->post('valorTarifa');
		$dados['status'] = $this->input->post('status');

		$dados['id_empresa'] = $this->session->userdata('id_empresa');


		$tarifa = $this->FinTarifasBancarias_model->recebeNomeTarifa($dados['nome_tarifa'], $id); // verifica se já existe a tarifa bancaria

		// Verifica se a tarifa bancaria já existe e se não é o tarifa bancaria que está sendo editada
		if ($tarifa) {

			$response = array(
				'success' => false,
				'message' => "Esta Tarifa já existe! Tente cadastrar uma diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->FinTarifasBancarias_model->editaTarifaBancaria($id, $dados) : $this->FinTarifasBancarias_model->insereTarifaBancaria($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Tarifa editada com sucesso!' : 'Tarifa cadastrada com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar a Tarifa!" : "Erro ao cadastrar a Tarifa!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaTarifaBancaria()
	{

		$id = $this->input->post('id');

		// Verifica se a tarifa possui alguma conta bancaria vinculada a ela
		$tarifaVinculada = $this->FinTarifasBancarias_model->verificaTarifaBancaria($id);

		if ($tarifaVinculada) {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Esta tarifa bancária está vinculada ao Fluxo de Caixa, não é possível excluí-la. Deseja inativa-lá?",
				'type' => "warning",
				'vinculo' => true
			);
		} else {

			$retorno = $this->FinTarifasBancarias_model->deletaTarifaBancaria($id);

			if ($retorno) {
				$response = array(
					'success' => true,
					'title' => "Sucesso!",
					'message' => "Tarifa Bancaria deletada com sucesso!",
					'type' => "success",
					'vinculo' => false

				);
			} else {

				$response = array(
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Não foi possivel deletar a Tarifa Bancaria!",
					'type' => "error"
				);
			}
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function inativaTarifaBancaria()
	{
		$id = $this->input->post('id');


		$retorno = $this->FinTarifasBancarias_model->inativaTarifaBancaria($id);

		if ($retorno) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Tarifa Bancaria inativada com sucesso!",
				'type' => "success"
			);
		} else {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possivel inativar a Tarifa Bancaria!",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

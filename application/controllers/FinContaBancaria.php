<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinContaBancaria extends CI_Controller
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
		$this->load->model('FinContaBancaria_model');
		$this->load->model('FinSaldoBancario_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para contas bancarias
		$scriptsFinContaBancariaFooter = scriptsFinContaBancariaFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinContaBancariaFooter));

		$data['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/conta-bancaria/conta-bancaria');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para contas bancarias
		$scriptsFinContaBancariaHead = scriptsFinContaBancariaHead();
		$scriptsFinContaBancariaFooter = scriptsFinContaBancariaFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsFinContaBancariaHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinContaBancariaFooter));

		//Carregamento de models necessarios
		$this->load->model('FinBancosFinanceiros_model');
		$this->load->model('SetoresEmpresa_model');

		$id = $this->uri->segment(3);

		$data['contaBancaria'] = $this->FinContaBancaria_model->recebeContaBancaria($id);
		$data['bancosFinanceiros'] = $this->FinBancosFinanceiros_model->recebeBancosFinanceiros($id);

		$data['setores'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/conta-bancaria/cadastra-conta-bancaria');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraContaBancaria()
	{
		$id = $this->input->post('id');

		$saldoInicial = $this->input->post('saldoInicial');

		$saldoInicial = str_replace(['.', ','], ['', '.'], $saldoInicial);

		$dados['apelido'] = $this->input->post('apelido');
		$dados['id_banco_financeiro'] = $this->input->post('banco');
		$dados['conta'] = $this->input->post('conta');
		$dados['agencia'] = $this->input->post('agencia');

		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		// Verifica se já existe uma conta bancária com o mesmo apelido (excluindo a conta atual se estiver em modo de edição)
		$contaExistente = $this->FinContaBancaria_model->recebeApelidoContaBancaria($dados['apelido'], $id);

		if ($contaExistente && (!empty($id) && $contaExistente['id'] != $id || empty($id))) {
			$response = [
				'success' => false,
				'message' => "Esse Apelido de Conta Bancária já existe! Tente cadastrar uma diferente."
			];
			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		if (empty($id)) {
			// Insere nova conta bancária
			$resultado = $this->FinContaBancaria_model->insereContaBancaria($dados);
			if ($resultado) {
				$this->FinSaldoBancario_model->insereSaldoBancario($resultado['inserted_id'], $saldoInicial);
				$response = ['success' => true, 'message' => 'Conta Bancária cadastrada com sucesso!'];
			} else {
				$response = ['success' => false, 'message' => "Erro ao cadastrar a Conta Bancária!"];
			}
		} else {
			// Edita conta bancária existente
			$resultado = $this->FinContaBancaria_model->editaContaBancaria($id, $dados);
			if ($resultado) {
				$response = ['success' => true, 'message' => 'Conta Bancária editada com sucesso!'];
			} else {
				$response = ['success' => false, 'message' => "Erro ao editar a Conta Bancária!"];
			}
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaContaBancaria()
	{
		$id = $this->input->post('id');

		// Verifica se a conta bancária está vinculada ao fluxo de caixa
		$contaVinculadaFluxo = $this->FinContaBancaria_model->verificaContaBancariaFluxo($id);

		if ($contaVinculadaFluxo) {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Esta conta bancária está vinculada ao fluxo de caixa, não é possível exclui-la, deseja inativa-la?",
				'type' => "error",
				'vinculo' => true
			);
		} else {
			// Tenta inativar o saldo bancário
			$retornoSaldo = $this->FinContaBancaria_model->deletaSaldoBancario($id);

			// Tenta inativar a conta bancária
			$retornoConta = $this->FinContaBancaria_model->deletaContaBancaria($id);

			// Verifica se ambas as operações foram bem-sucedidas
			if ($retornoConta && $retornoSaldo) {
				$response = array(
					'success' => true,
					'title' => "Sucesso!",
					'message' => "Conta bancária e saldo bancário excluídos com sucesso!",
					'type' => "success"
				);
			} else {
				// Se houve um problema em uma das operações
				$response = array(
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Não foi possível excluir a conta bancária ou o saldo bancário.",
					'type' => "error"
				);
			}
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function inativaContaBancaria()
	{
		$id = $this->input->post('id');

		// Tenta inativar a conta bancária
		$retornoConta = $this->FinContaBancaria_model->inativaContaBancaria($id);
		// Tenta inativar o saldo bancário
		$retornoSaldo = $this->FinContaBancaria_model->inativaSaldoBancario($id);

		// Verifica se ambas as operações foram bem-sucedidas
		if ($retornoConta && $retornoSaldo) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Conta bancária e saldo bancário inativados com sucesso!",
				'type' => "success"
			);
		} else {
			// Se houve um problema em uma das operações
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possível inativar a conta bancária ou o saldo bancário.",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

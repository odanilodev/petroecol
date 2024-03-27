<?php
defined('BASEPATH') or exit ('No direct script access allowed');

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

		$id = $this->uri->segment(3);

		$data['contaBancaria'] = $this->FinContaBancaria_model->recebeContaBancaria($id);

		$this->load->model('SetoresEmpresa_model');
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
		$dados['banco'] = $this->input->post('banco');
		$dados['conta'] = $this->input->post('conta');
		$dados['agencia'] = $this->input->post('agencia');
		$dados['id_setor_empresa'] = $this->input->post('setorEmpresa');

		$dados['id_empresa'] = $this->session->userdata('id_empresa');


		$contaBancaria = $this->FinContaBancaria_model->recebeApelidoContaBancaria($dados['apelido'], $id); // verifica se já existe a conta bancaria

		// Verifica se a conta bancaria já existe e se não é a conta bancaria que está sendo editada
		if ($contaBancaria) {

			$response = array(
				'success' => false,
				'message' => "Esta Conta Bancária já existe! Tente cadastrar uma diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->FinContaBancaria_model->editaContaBancaria($id, $dados) : $this->FinContaBancaria_model->insereContaBancaria($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			!$id ? $this->FinSaldoBancario_model->insereSaldoBancario($retorno['inserted_id'], $saldoInicial) : '';

			$response = array(
				'success' => true,
				'message' => $id ? 'Conta Bancaria editada com sucesso!' : 'Conta Bancaria cadastrada com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar a Conta Bancaria!" : "Erro ao cadastrar a Conta Bancaria!"
			);
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
							'id_vinculado' => $id,
							'message' => "Esta conta bancária está vinculada ao fluxo de caixa, não é possível inativá-la.",
							'type' => "error"
					);
			} else {
					// Tenta inativar a conta bancária
					$retornoConta = $this->FinContaBancaria_model->deletaContaBancaria($id);
					
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
			}
	
			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}	

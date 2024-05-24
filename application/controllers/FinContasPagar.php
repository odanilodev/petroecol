<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinContasPagar extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		//INICIO controle sessão
		$this->load->library('Controle_sessao');
		$this->load->model('FinContasPagar_model');
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
		$this->load->model('FinDadosFinanceiros_model');
		$this->load->model('FinContasPagar_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// Scripts para contas a pagar
		$scriptsContasPagarHead = scriptsFinContasPagarHead();
		$scriptsContasPagarFooter = scriptsFinContasPagarFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsContasPagarHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsContasPagarFooter));

		// Define as datas padrão caso não sejam recebidas via POST
		$dataInicio = new DateTime();
		$dataInicio->modify('-15 days');
		$dataInicioFormatada = $dataInicio->format('Y-m-d');

		$dataFim = new DateTime();
		$dataFim->modify('+15 days');
		$dataFimFormatada = $dataFim->format('Y-m-d');

		// Verifica se as datas foram recebidas via POST
		if ($this->input->post('data_inicio') && $this->input->post('data_fim')) {
			// Recebe as datas do POST
			$dataInicioFormatada = $this->input->post('data_inicio');
			$dataFimFormatada = $this->input->post('data_fim');

			// Converte as datas para o formato americano (Y-m-d)
			$dataInicioFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataInicioFormatada)));
			$dataFimFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataFimFormatada)));
		}

		$data['dataInicio'] = $this->input->post('data_inicio');
		$data['dataFim'] = $this->input->post('data_fim');

		// Verifica se o tipo de movimentação foi recebido via POST
		$statusConta = $this->input->post('status');

		// Se não houver nenhum valor recebido via POST, define 'ambas' como valor padrão
		if ($statusConta === null || $statusConta === '') {
			$statusConta = 'ambas';
		}
		
		// Setores Empresa 
        $this->load->model('SetoresEmpresa_model');
        $data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

		$data['status'] = $statusConta;

		$this->load->model('FinMacro_model');
		$data['macros'] = $this->FinMacro_model->recebeMacros();

		$this->load->model('FinGrupos_model');
		$data['grupos'] = $this->FinGrupos_model->recebeGrupos();
		$data['dadosFinanceiro'] = $this->FinDadosFinanceiros_model->recebeDadosFinanceiros();

		$this->load->model('FinFormaTransacao_model');
		$this->load->model('FinContaBancaria_model');
		$this->load->model('FinContasPagar_model');

		$data['formasTransacao'] = $this->FinFormaTransacao_model->recebeFormasTransacao();
		$data['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();

		$data['contasPagar'] = $this->FinContasPagar_model->recebeContasPagar($dataInicioFormatada, $dataFimFormatada, $statusConta);

		$this->load->library('finDadosFinanceiros');

		$data['saldoTotal'] = $this->findadosfinanceiros->somaSaldosBancarios();

		$data['totalPago'] = $this->findadosfinanceiros->totalDadosFinanceiro('valor', 'fin_contas_pagar', 1, $dataInicioFormatada, $dataFimFormatada); // soma o valor total pago
		$data['emAberto'] = $this->findadosfinanceiros->totalDadosFinanceiro('valor', 'fin_contas_pagar', 0, $dataInicioFormatada, $dataFimFormatada); // soma o valor total em aberto

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/contas-pagar');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraContasPagar()
	{
		$dadosLancamento = $this->input->post('dados');

		$data['id_dado_financeiro'] = $dadosLancamento['recebido'];
		$data['id_empresa'] = $this->session->userdata('id_empresa');
		$data['valor'] = str_replace(['.', ','], ['', '.'], $dadosLancamento['valor']);
		$data['id_micro'] = $dadosLancamento['micros'];
		$data['id_macro'] = $dadosLancamento['macros'];
		$data['nome'] = $dadosLancamento['nome-recebido'];
		$data['id_setor_empresa'] = $dadosLancamento['setor'];
		$data['observacao'] = $dadosLancamento['observacao'];
		$data['data_vencimento'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_vencimento'])));
		$data['data_emissao'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_emissao'])));

		$success = true;

		for ($i = 0; $i < $dadosLancamento['parcelas']; $i++) {

			if ($i > 0) {
				$data['data_vencimento'] = date('Y-m-d', strtotime($data['data_vencimento'] . ' +30 days'));
			}

			$retorno = $this->FinContasPagar_model->insereConta($data);

			// para o loop se der erro em alguma
			if ($i == 0 && !$retorno) {
				$success = false;
			}
		}

		if ($success) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Contas inseridas com sucesso!",
				'type' => "success"
			);
		} else {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Falha ao inserir contas recebidas. Por favor, tente novamente.",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function editaConta()
	{
		$id = $this->input->post('idConta');
		$dadosLancamento = $this->input->post('dados');

		$data['valor'] = str_replace(['.', ','], ['', '.'], $dadosLancamento['valor']);
		$data['observacao'] = $dadosLancamento['observacao'];
		$data['id_setor_empresa'] = $dadosLancamento['setor'];
		$data['data_vencimento'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_vencimento'])));
		$data['data_emissao'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_emissao'])));


		$retorno = $this->FinContasPagar_model->editaConta($id, $data);

		if ($retorno) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Conta editada com sucesso!",
				'type' => "success"
			);
		} else {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Falha ao editar conta. Por favor, tente novamente.",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function recebeTodosClientesAll()
	{
		$this->load->model('Clientes_model');
		$todosClientes = $this->Clientes_model->recebeTodosClientesAll();

		if ($todosClientes) {

			$response = array(
				'clientes' => $todosClientes,
				'success' => true
			);
		} else {
			$response = array(
				'success' => false
			);
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	public function recebeContaPagar()
	{
		$id = $this->input->post('id');
		$retorno = $this->FinContasPagar_model->recebeContaPagar($id);


		if ($retorno) {

			$response = array(
				'conta' => $retorno,
				'success' => true
			);
		} else {
			$response = array(
				'success' => false
			);
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function realizarPagamento()
	{
		$this->load->model('FinFluxo_model');
		$this->load->model('FinContasPagar_model');
		$this->load->model('FinSaldoBancario_model');

		$contasBancarias = $this->input->post('contasBancarias');
		$formasPagamento = $this->input->post('formasPagamento');
		$valores = $this->input->post('valores');
		$obs = $this->input->post('obs');
		$idConta = $this->input->post('idConta');
		$idDadoFinanceiro = $this->input->post('idDadoFinanceiro');

		$dataPagamento = $this->input->post('dataPagamento');

		$dataPagamentoFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataPagamento)));

		$valorTotalPago = 0;

		$micro = $this->FinContasPagar_model->recebeIdMicroContaPagar($idConta);

		$macro = $this->FinContasPagar_model->recebeIdMacroContaPagar($idConta);


		foreach ($formasPagamento as $key => $formaPagamento) {

			//Informacoes do saldo bancario
			$saldoAtual = $this->FinSaldoBancario_model->recebeSaldoBancario($contasBancarias[$key]);
			$valorPagoFormatado = str_replace(['.', ','], ['', '.'], $valores[$key]); //Muda para o tipo float

			$novoSaldo = $saldoAtual['saldo'] - $valorPagoFormatado;
			$this->FinSaldoBancario_model->atualizaSaldoBancario($contasBancarias[$key], $novoSaldo);

			$valorTotalPago += $valorPagoFormatado;

			//Informacoes do fluxo
			$dados['id_empresa'] = $this->session->userdata('id_empresa');
			$dados['id_conta_bancaria'] = $contasBancarias[$key];
			$dados['id_vinculo_conta'] = $idConta;
			$dados['id_forma_transacao'] = $formasPagamento[$key];
			$dados['id_macro'] = $macro['id_macro'];
			$dados['id_micro'] = $micro['id_micro'];
			$dados['valor'] = $valorPagoFormatado;
			$dados['movimentacao_tabela'] = 0;
			$dados['data_movimentacao'] = $dataPagamentoFormatada;
			$dados['id_dado_financeiro'] = $idDadoFinanceiro;
			$dados['observacao'] = $obs;

			$this->FinFluxo_model->insereFluxo($dados);
		}

		//Informacoes da conta a pagar
		$conta['valor_pago'] = $valorTotalPago;
		$conta['status'] = 1;
		$conta['id_forma_transacao'] = 2;
		$conta['data_pagamento'] = $dataPagamentoFormatada;

		$this->FinContasPagar_model->editaConta($idConta, $conta);

		// retorno conta paga
		$response = array(
			'success' => true,
			'message' => "Pagamento realizado com sucesso!",
			'type' => "success"

		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function realizarMultiPagamentos()
	{

		$this->load->model('FinFluxo_model');
		$this->load->model('FinContasPagar_model');
		$this->load->model('FinSaldoBancario_model');

		$operacoes = $this->input->post('operacoes');


		foreach ($operacoes as $operacao) {

			$dataPagamentoFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $operacao['dataPagamento'])));

			$micro = $this->FinContasPagar_model->recebeIdMicroContaPagar($operacao['idConta']);

			$macro = $this->FinContasPagar_model->recebeIdMacroContaPagar($operacao['idConta']);

			$valorTotalPago = 0;

			foreach ($operacao['formasPagamento'] as $key => $formaPagamento) {

				$saldoAtual = $this->FinSaldoBancario_model->recebeSaldoBancario($operacao['contasBancarias'][$key]);

				$valoPagoFormatado = str_replace(['.', ','], ['', '.'], $operacao['valores'][$key]); //Muda para o tipo float

				$valorTotalPago += $valoPagoFormatado;

				$novoSaldo = $saldoAtual['saldo'] - $valoPagoFormatado;
				$this->FinSaldoBancario_model->atualizaSaldoBancario($operacao['contasBancarias'][$key], $novoSaldo);

				//Informacoes do fluxo
				$dados['id_empresa'] = $this->session->userdata('id_empresa');
				$dados['id_conta_bancaria'] = $operacao['contasBancarias'][$key];
				$dados['id_macro'] = $macro['id_macro'];
				$dados['id_micro'] = $micro['id_micro'];
				$dados['id_vinculo_conta'] = $operacao['idConta'];
				$dados['id_forma_transacao'] = $formaPagamento;
				$dados['valor'] = $valoPagoFormatado;
				$dados['movimentacao_tabela'] = 0;
				$dados['data_movimentacao'] = $dataPagamentoFormatada;
				$dados['id_dado_financeiro'] = $operacao['idDadoFinanceiro'];
				$dados['observacao'] = $operacao['observacao'];

				$this->FinFluxo_model->insereFluxo($dados);

				$conta['valor_pago'] = $valorTotalPago;
			}

			$conta['status'] = 1;
			$conta['data_pagamento'] = $dataPagamentoFormatada;

			$this->FinContasPagar_model->editaConta($operacao['idConta'], $conta);
		}

		// retorno conta paga
		$response = array(
			'title' => 'Sucesso!',
			'success' => true,
			'message' => "Pagamento realizado com sucesso!",
			'type' => "success"

		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}



	public function insereContaPagar()
	{

		$id = $this->input->post('id_conta');

		$dados['id_empresa'] = $this->session->userdata('id_empresa');
		$dados['id_setor_empresa'] = $this->input->post('id_setor_empresa');
		$dados['id_micro'] = $this->input->post('id_micro');
		$dados['id_dado_financeiro'] = $this->input->post('id_dado_financeiro');
		$dados['valor'] = $this->input->post('valor');
		$dados['valor_pago'] = $this->input->post('valor_pago');
		$dados['status'] = $this->input->post('status');
		$dados['id_forma_transacao'] = $this->input->post('id_forma_transacao');
		$dados['data_emissao'] = $this->input->post('data_emissao');
		$dados['data_vencimento'] = $this->input->post('data_vencimento');
		$dados['data_pagamento'] = $this->input->post('data_pagamento');
		$dados['observacao'] = $this->input->post('observacao');

		$retorno = $id ? $this->FinFluxo_model->editaConta($dados) : $this->FinFluxo_model->insereConta($dados);

		if ($retorno) {

			$response = array(
				'success' => true,
				'message' => $id ? "Conta editada com sucesso!" : "Conta cadastrada com sucesso!"
			);
		} else {

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar a Conta!" : "Erro ao cadastrar a Conta!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function visualizarConta()
	{
		$idConta = $this->input->post('idConta');

		$conta = $this->FinContasPagar_model->recebeContaPagar($idConta);

		if ($conta) {
			$response = array(
				'success' => true,
				'conta' => $conta
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletarConta()
	{
		$idsContas = $this->input->post('ids');

		$retorno = $this->FinContasPagar_model->deletaConta($idsContas);

		if ($retorno) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Conta(s) deletada(s) com sucesso!",
				'type' => "success"
			);
		} else {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possivel deletar a(s) conta(s)!",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

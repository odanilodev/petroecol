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

	public function index($page = 1)
	{
		$this->load->helper('cookie');

		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// Scripts para contas a pagar
		$scriptsContasPagarHead = scriptsFinContasPagarHead();
		$scriptsContasPagarFooter = scriptsFinContasPagarFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsContasPagarHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsContasPagarFooter));

		// Define as datas padrão caso não sejam recebidas via POST
		$dataInicioFormatada = '';
		$dataFimFormatada = '';

		$data['dataInicio'] = "";
		$data['status'] = 'ambas';
		$data['idSetor'] = 'todos';
		$statusConta = 'ambas';
		$setorEmpresa = 'todos';

		if ($page != "all") {


			// dados no cookie para refazer o filtro
			$cookieDataInicio = json_decode($this->input->cookie('filtro_data_inicio_pagar'));
			$cookieDataFim = json_decode($this->input->cookie('filtro_data_fim_pagar'));
			$cookieStatus = json_decode($this->input->cookie('filtro_status_pagar'));
			$cookieSetor = json_decode($this->input->cookie('filtro_setor_pagar'));
			$cookieNomeSetor = json_decode($this->input->cookie('filtro_nome_setor_pagar'));

			$dataInicio = $this->input->post('data_inicio') ?? $cookieDataInicio;
			$dataFim = $this->input->post('data_fim') ?? $cookieDataFim;
			$statusConta = $this->input->post('status') ?? $cookieStatus;
			$setorEmpresa = $this->input->post('setor') ?? $cookieSetor;
			$nomeSetorEmpresa = $this->input->post('nomeSetor') ?? $cookieNomeSetor;

			// define os cookies para filtrar por datas
			if ($dataInicio) {

				$this->input->set_cookie('filtro_data_inicio_pagar', json_encode($dataInicio), 3600);
				$this->input->set_cookie('filtro_data_fim_pagar', json_encode($dataFim), 3600);
				$this->input->set_cookie('filtro_status_pagar', json_encode($statusConta), 3600);
				$this->input->set_cookie('filtro_setor_pagar', json_encode($setorEmpresa), 3600);
				$this->input->set_cookie('filtro_nome_setor_pagar', json_encode($nomeSetorEmpresa), 3600);
				// converte as datas para o formato americano (Y-m-d)
				$dataInicioFormatada = $dataInicio ? date('Y-m-d', strtotime(str_replace('/', '-', $dataInicio))) : "";
				$dataFimFormatada = $dataFim ? date('Y-m-d', strtotime(str_replace('/', '-', $dataFim))) : "";
				// dados para exibir no formulário novamente
				$data['dataInicio'] = $dataInicio;
				$data['dataFim'] = $dataFim;
				$data['nomeSaldoSetor'] = $nomeSetorEmpresa;
				$data['status'] = $statusConta;
				$data['idSetor'] = $setorEmpresa;
			}


		} else {

			delete_cookie('filtro_data_inicio_pagar');
			delete_cookie('filtro_data_fim_pagar');
			delete_cookie('filtro_status_pagar');
			delete_cookie('filtro_setor_pagar');
			delete_cookie('filtro_nome_setor_pagar');
		}


		// Setores Empresa 
		$this->load->model('SetoresEmpresa_model');
		$data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

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

		// search com cookie
		if ($this->input->post()) {
			$this->input->set_cookie('filtro_contas_pagar', json_encode($this->input->post()), 3600);
		}

		if (is_numeric($page)) {
			$cookie_filtro_contas_pagar = $this->input->post() ? json_encode($this->input->post()) : $this->input->cookie('filtro_contas_pagar');
		} else {
			$page = 1;
			delete_cookie('filtro_contas_pagar');
			$cookie_filtro_contas_pagar = json_encode([]);
		}

		$data['cookie_filtro_contas_pagar'] = json_decode($cookie_filtro_contas_pagar, true);


		// >>>> PAGINAÇÃO <<<<<
		$limit = 10; // Número de clientes por página
		$this->load->library('pagination');
		$config['base_url'] = base_url('finContasPagar/index/');
		$config['total_rows'] = $this->FinContasPagar_model->recebeContasPagar($dataInicioFormatada, $dataFimFormatada, $statusConta, $setorEmpresa, $cookie_filtro_contas_pagar, $limit, $page, true); // true para contar
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
		$this->pagination->initialize($config);
		// >>>> FIM PAGINAÇÃO <<<<<

		$data['contasPagar'] = $this->FinContasPagar_model->recebeContasPagar($dataInicioFormatada, $dataFimFormatada, $statusConta, $setorEmpresa, $cookie_filtro_contas_pagar, $limit, $page);

		$this->load->library('finDadosFinanceiros');
		$data['saldoTotal'] = $this->findadosfinanceiros->somaSaldosBancarios();

		if ($statusConta == '1' || $statusConta == 'ambas') {

			$data['totalPago'] = $this->findadosfinanceiros->totalDadosFinanceiro('valor', 'fin_contas_pagar', 1, $dataInicioFormatada, $dataFimFormatada, $setorEmpresa); // soma o valor total pago

		} else {
			$data['totalPago']['valor'] = '00';
		}

		if ($statusConta == '0' || $statusConta == 'ambas') {

			$data['emAberto'] = $this->findadosfinanceiros->totalDadosFinanceiro('valor', 'fin_contas_pagar', 0, $dataInicioFormatada, $dataFimFormatada, $setorEmpresa); // soma o valor total em aberto

		} else {
			$data['emAberto']['valor'] = '00';
		}

		$data['porSetor'] = $this->findadosfinanceiros->somaSaldosBancariosSetor($setorEmpresa); // soma o valor total do setor específico

		// contas recorrentes
		$this->load->model('FinContasRecorrentes_model');
		$data['contasRecorrentes'] = $this->FinContasRecorrentes_model->recebeContasRecorrentes();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/contas-pagar');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraContasPagar()
	{
		$dadosLancamento = $this->input->post('dados');

		if ($dadosLancamento['grupo-recebido'] == 'clientes') {
			$data['id_cliente'] = $dadosLancamento['recebido'];
		} else {
			$data['id_dado_financeiro'] = $dadosLancamento['recebido'];
		}

		$data['id_empresa'] = $this->session->userdata('id_empresa');
		$data['valor'] = str_replace(['.', ','], ['', '.'], $dadosLancamento['valor']);
		$data['id_micro'] = $dadosLancamento['micros'];
		$data['id_macro'] = $dadosLancamento['macros'];
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

	public function cadastraMultiplasContasPagar()
	{
		$dadosLancamento = $this->input->post('dados');

		$data['id_empresa'] = $this->session->userdata('id_empresa');

		$success = true;

		for ($i = 0; $i < count($dadosLancamento['data_vencimento']); $i++) {

			$data['data_vencimento'] = $dadosLancamento['data_vencimento'][$i];
			$data['id_dado_financeiro'] = $dadosLancamento['recebido'][$i];
			$data['id_cliente'] = $dadosLancamento['cliente'][$i];
			$data['valor'] = str_replace(['.', ','], ['', '.'], $dadosLancamento['valor'][$i]);
			$data['id_micro'] = $dadosLancamento['micros'][$i];
			$data['id_macro'] = $dadosLancamento['macros'][$i];
			$data['id_setor_empresa'] = $dadosLancamento['setor'][$i];
			$data['data_vencimento'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_vencimento'][$i])));

			$retorno = $this->FinContasPagar_model->insereConta($data);

			// para o loop se der erro em alguma
			if (!$retorno) {
				$success = false;
				break; // interrompe o loop se ocorrer um erro
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

		if ($dadosLancamento['grupo-recebido'] == 'clientes') {
			$data['id_cliente'] = $dadosLancamento['recebido'];
		} else {
			$data['id_dado_financeiro'] = $dadosLancamento['recebido'];
		}

		$data['valor'] = str_replace(['.', ','], ['', '.'], $dadosLancamento['valor']);
		$data['observacao'] = $dadosLancamento['observacao'];
		$data['id_setor_empresa'] = $dadosLancamento['setor'];
		$data['data_vencimento'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_vencimento'])));
		$data['data_emissao'] = $dadosLancamento['data_emissao'] ? date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_emissao']))) : "";
		$data['id_empresa'] = $this->session->userdata('id_empresa');
		$data['id_micro'] = $dadosLancamento['micros'];
		$data['id_macro'] = $dadosLancamento['macros'];


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
		$dados['id_setor_empresa'] = $this->input->post('idSetor');

		$idConta = $this->input->post('idConta');
		$idDadoFinanceiro = $this->input->post('idDadoFinanceiro');
		$idCliente = $this->input->post('idDadoCliente');

		$dataPagamento = $this->input->post('dataPagamento');

		$dataPagamentoFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataPagamento)));

		$valorTotalPago = 0;

		$observacaoconta = $this->FinContasPagar_model->recebeObsContaPagar($idConta);

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
			$dados['id_cliente'] = $idCliente;

			if (empty($obs)) {
				$dados['observacao'] = $observacaoconta['observacao'];
			} else {
				$dados['observacao'] = $obs;
			}

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

			$observacaoconta = $this->FinContasPagar_model->recebeObsContaPagar($operacao['idConta']);

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
				$dados['id_setor_empresa'] = $operacao['id_setor_empresa'];


				if (empty($operacao['observacao'])) {
					$dados['observacao'] = $observacaoconta['observacao'];
				} else {
					$dados['observacao'] = $operacao['observacao'];
				}

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

	public function geraExcelContasPagar()
	{
		// Recebe as datas e filtros via POST
		$dataInicio = $this->input->post('data_inicio');
		$dataFim = $this->input->post('data_fim');
		$statusConta = $this->input->post('status');
		$setorEmpresa = $this->input->post('setor');

		// Define valores padrão caso os filtros não sejam fornecidos
		$statusConta = $statusConta ? $statusConta : 'ambas';
		$setorEmpresa = $setorEmpresa ? $setorEmpresa : 'todos';

		// Formata as datas para o formato Y-m-d
		$dataInicioFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataInicio)));
		$dataFimFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataFim)));

		// Carrega o modelo e obtém os dados filtrados
		$this->load->model('FinContasPagar_model');
		$contasPagar = $this->FinContasPagar_model->recebeContasPagarExcel($dataInicioFormatada, $dataFimFormatada, $statusConta, $setorEmpresa);

		// Cria o conteúdo do Excel usando XML
		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x="urn:schemas-microsoft-com:office:excel">';
		$xml .= '<Worksheet ss:Name="ContasPagar">';
		$xml .= '<Table>';

		// Cabeçalhos das colunas
		$xml .= '<Row>';
		$xml .= '<Cell><Data ss:Type="String">ID</Data></Cell>';
		$xml .= '<Cell><Data ss:Type="String">Valor</Data></Cell>';
		$xml .= '<Cell><Data ss:Type="String">Data Vencimento</Data></Cell>';
		$xml .= '<Cell><Data ss:Type="String">Valor Pago</Data></Cell>';
		$xml .= '<Cell><Data ss:Type="String">Setor</Data></Cell>';
		$xml .= '<Cell><Data ss:Type="String">Status</Data></Cell>';
		$xml .= '<Cell><Data ss:Type="String">Data Pagamento</Data></Cell>';
		$xml .= '<Cell><Data ss:Type="String">Recebido/Cliente</Data></Cell>';
		$xml .= '<Cell><Data ss:Type="String">Nome Micro</Data></Cell>';
		$xml .= '<Cell><Data ss:Type="String">Observação</Data></Cell>';
		$xml .= '</Row>';

		// Preenche os dados no Excel
		foreach ($contasPagar as $contaPagar) {
			if (is_array($contaPagar)) {
				$xml .= '<Row>';
				$xml .= '<Cell><Data ss:Type="String">' . ($contaPagar['id'] ?? 'N/A') . '</Data></Cell>';

				// Converte o valor para o formato brasileiro
				$valorFormatado = number_format($contaPagar['valor'], 2, ',', '');
				$xml .= '<Cell><Data ss:Type="Number">' . str_replace(',', '.', $valorFormatado) . '</Data></Cell>';

				$xml .= '<Cell><Data ss:Type="String">' . (isset($contaPagar['data_vencimento']) ? date('d/m/Y', strtotime($contaPagar['data_vencimento'])) : 'N/A') . '</Data></Cell>';

				$valorPagoFormatado = number_format($contaPagar['valor_pago'], 2, ',', '');
				$xml .= '<Cell><Data ss:Type="Number">' . str_replace(',', '.', $valorPagoFormatado) . '</Data></Cell>';

				$xml .= '<Cell><Data ss:Type="String">' . ($contaPagar['SETOR'] ?? 'N/A') . '</Data></Cell>';
				$xml .= '<Cell><Data ss:Type="String">' . ($contaPagar['status'] ? "Pago" : "Em aberto") . '</Data></Cell>';
				$xml .= '<Cell><Data ss:Type="String">' . (isset($contaPagar['data_pagamento']) ? date('d/m/Y', strtotime($contaPagar['data_pagamento'])) : '-') . '</Data></Cell>';
				$xml .= '<Cell><Data ss:Type="String">' . ($contaPagar['RECEBIDO'] ? ucfirst($contaPagar['RECEBIDO']) : ucfirst($contaPagar['CLIENTE'])) . '</Data></Cell>';
				$xml .= '<Cell><Data ss:Type="String">' . ($contaPagar['NOME_MICRO'] ?? 'N/A') . '</Data></Cell>';
				$xml .= '<Cell><Data ss:Type="String">' . ($contaPagar['observacao'] ?? '-') . '</Data></Cell>';
				$xml .= '</Row>';
			}
		}

		// Fecha a tabela e a planilha
		$xml .= '</Table>';
		$xml .= '</Worksheet>';
		$xml .= '</Workbook>';

		// Define o nome do arquivo
		$fileName = 'ContasPagar_' . date('Ymd') . '.xls';

		// Define os cabeçalhos para o download do arquivo
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');

		// Limpa o buffer de saída para evitar corrupção do arquivo
		ob_end_clean();

		// Imprime o conteúdo XML gerado
		echo $xml;
		exit;
	}



}

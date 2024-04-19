<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinContasReceber extends CI_Controller
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
		$this->load->model('FinDadosFinanceiros_model');
		$this->load->model('FinContasReceber_model');
	}

	public function index()
	{

		$this->load->model('FinContaBancaria_model');
		$this->load->model('FinFormaTransacao_model');

		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// Scripts para contas a receber
		$scriptsContasReceberHead = scriptsFinContasReceberHead();
		$scriptsContasReceberFooter = scriptsFinContasReceberFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsContasReceberHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsContasReceberFooter));

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

		$data['status'] = $statusConta;



		$this->load->model('FinMacro_model');
		$data['macros'] = $this->FinMacro_model->recebeMacros();
		$this->load->model('FinGrupos_model');
		$data['grupos'] = $this->FinGrupos_model->recebeGrupos();

		$data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();
		$data['dadosFinanceiro'] = $this->FinDadosFinanceiros_model->recebeDadosFinanceiros();
		$data['contasReceber'] = $this->FinContasReceber_model->recebeContasReceber($dataInicioFormatada, $dataFimFormatada, $statusConta);

		$data['formasTransacao'] = $this->FinFormaTransacao_model->recebeFormasTransacao();
		$data['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();

		$this->load->library('finDadosFinanceiros');

		$data['saldoTotal'] = $this->findadosfinanceiros->somaSaldosBancarios();

		$data['totalRecebido'] = $this->findadosfinanceiros->totalDadosFinanceiro('valor_recebido', 'fin_contas_receber', 1); // soma o valor total recebido
		$data['emAberto'] = $this->findadosfinanceiros->totalDadosFinanceiro('valor', 'fin_contas_receber', 0); // soma o valor total em aberto

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/contas-receber');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraContasReceber()
	{
		$dadosLancamento = $this->input->post('dados');

		$data['id_dado_financeiro'] = $dadosLancamento['recebido'];
		$data['id_empresa'] = $this->session->userdata('id_empresa');

		$data['valor'] = str_replace(['.', ','], ['', '.'], $dadosLancamento['valor']);

		$data['id_macro'] = $dadosLancamento['macros'];
		$data['id_micro'] = $dadosLancamento['micros'];
		$data['observacao'] = $dadosLancamento['observacao'];
		$data['data_vencimento'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_vencimento'])));
		$data['data_emissao'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_emissao'])));

		$success = true;

		for ($i = 0; $i < $dadosLancamento['parcelas']; $i++) {

			if ($i > 0) {
				$data['data_vencimento'] = date('Y-m-d', strtotime($data['data_vencimento'] . ' +30 days'));
			}

			$retorno = $this->FinContasReceber_model->insereContasReceber($data);

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

	public function receberConta()
	{
		$this->load->model('FinFluxo_model');
		$this->load->model('FinContasReceber_model');
		$this->load->model('FinSaldoBancario_model');

		$contasBancarias = $this->input->post('contasBancarias');
		$formasPagamento = $this->input->post('formasPagamento');
		$valores = $this->input->post('valores');
		$obs = $this->input->post('obs');
		$idConta = $this->input->post('idConta');
		$idDadoFinanceiro = $this->input->post('idDadoFinanceiro');

		$dataRecebimento = $this->input->post('dataRecebimento');

		$dataRecebimentoFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataRecebimento)));

		$valorTotalRecebido = 0;

		foreach ($formasPagamento as $key => $formaPagamento) {

			//Informacoes do saldo bancario
			$saldoAtual = $this->FinSaldoBancario_model->recebeSaldoBancario($contasBancarias[$key]);
			$valoPagoFormatado = str_replace(['.', ','], ['', '.'], $valores[$key]); //Muda para o tipo float

			$novoSaldo = $saldoAtual['saldo'] + $valoPagoFormatado;
			$this->FinSaldoBancario_model->atualizaSaldoBancario($contasBancarias[$key], $novoSaldo);

			$valorTotalRecebido += $valoPagoFormatado;


			//Informacoes do fluxo
			$dados['id_empresa'] = $this->session->userdata('id_empresa');
			$dados['id_conta_bancaria'] = $contasBancarias[$key];
			$dados['id_vinculo_conta'] = $idConta;
			$dados['id_forma_transacao'] = $formasPagamento[$key];
			$dados['data_movimentacao'] = $dataRecebimentoFormatada;
			$dados['valor'] = $valoPagoFormatado;
			$dados['movimentacao_tabela'] = 1;
			$dados['id_dado_financeiro'] = $idDadoFinanceiro;
			$dados['observacao'] = $obs;

			$this->FinFluxo_model->insereFluxo($dados);

		}

		//Informacoes da a receber
		$conta['valor_recebido'] = $valorTotalRecebido;
		$conta['status'] = 1;
		$conta['id_forma_transacao'] = 2;
		$conta['data_recebimento'] = $dataRecebimentoFormatada;

		$this->FinContasReceber_model->editaConta($idConta, $conta);

		// retorno conta paga
		$response = array(
			'success' => true,
			'message' => "Recebimento realizado com sucesso!",
			'type' => "success"
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));

	}


}

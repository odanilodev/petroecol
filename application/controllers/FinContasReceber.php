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

	public function index($page = 1)
	{
		$this->load->helper('cookie');

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

		$dataInicioFormatada = '';
		$dataFimFormatada = '';

		$data['dataInicio'] = "";
		$data['status'] = 'ambas';
		$data['idSetor'] = 'todos';

		$statusConta = 'ambas';
		$setorEmpresa = 'todos';

		if ($page != "all") {
			// dados no cookie para refazer o filtro
			$cookieDataInicio = json_decode($this->input->cookie('filtro_data_inicio_receber'));
			$cookieDataFim = json_decode($this->input->cookie('filtro_data_fim_receber'));
			$cookieStatus = json_decode($this->input->cookie('filtro_status_receber'));
			$cookieSetor = json_decode($this->input->cookie('filtro_setor_receber'));
			$cookieNomeSetor = json_decode($this->input->cookie('filtro_nome_setor_receber'));

			$dataInicio = $this->input->post('data_inicio') ?? $cookieDataInicio;
			$dataFim = $this->input->post('data_fim') ?? $cookieDataFim;
			$statusConta = $this->input->post('status') ?? $cookieStatus;
			$setorEmpresa = $this->input->post('setor') ?? $cookieSetor;
			$nomeSetorEmpresa = $this->input->post('nomeSetor') ?? $cookieNomeSetor;

			// define os cookies para filtrar por datas
			if ($dataInicio) {

				$this->input->set_cookie('filtro_data_inicio_receber', json_encode($dataInicio), 3600);
				$this->input->set_cookie('filtro_data_fim_receber', json_encode($dataFim), 3600);
				$this->input->set_cookie('filtro_status_receber', json_encode($statusConta), 3600);
				$this->input->set_cookie('filtro_setor_receber', json_encode($setorEmpresa), 3600);
				$this->input->set_cookie('filtro_nome_setor_receber', json_encode($nomeSetorEmpresa), 3600);
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
			delete_cookie('filtro_data_inicio_receber');
			delete_cookie('filtro_data_fim_receber');
			delete_cookie('filtro_status_receber');
			delete_cookie('filtro_setor_receber');
			delete_cookie('filtro_nome_setor_receber');
		}

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
		$data['nomeSaldoSetor'] = $this->input->post('nomeSetor');

		// Verifica se o tipo de movimentação foi recebido via POST
		$statusConta = $this->input->post('status');

		// Se não houver nenhum valor recebido via POST, define 'ambas' como valor padrão
		if ($statusConta === null || $statusConta === '') {
			$statusConta = 'ambas';
		}

		$data['status'] = $statusConta;

		$setorEmpresa = $this->input->post('setor');

		if ($setorEmpresa === null || $setorEmpresa === '') {
			$setorEmpresa = 'todos';
		}

		$data['idSetor'] = $setorEmpresa;

		// Setores Empresa 
		$this->load->model('SetoresEmpresa_model');
		$data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

		$this->load->model('FinMacro_model');
		$data['macros'] = $this->FinMacro_model->recebeMacros();
		$this->load->model('FinGrupos_model');
		$data['grupos'] = $this->FinGrupos_model->recebeGrupos();

		$data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();
		$data['dadosFinanceiro'] = $this->FinDadosFinanceiros_model->recebeDadosFinanceiros();
		
		$data['formasTransacao'] = $this->FinFormaTransacao_model->recebeFormasTransacao();
		$data['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();
		
		// search com cookie
		if ($this->input->post()) {
			$this->input->set_cookie('filtro_contas_receber', json_encode($this->input->post()), 3600);
		}
		
		if (is_numeric($page)) {
			$cookie_filtro_contas_receber = $this->input->post() ? json_encode($this->input->post()) : $this->input->cookie('filtro_contas_receber');
		} else {
			$page = 1;
			delete_cookie('filtro_contas_receber');
			$cookie_filtro_contas_receber = json_encode([]);
		}
		
		$data['cookie_filtro_contas_receber'] = json_decode($cookie_filtro_contas_receber, true);
		
		
		// >>>> PAGINAÇÃO <<<<<
		$limit = 15; // Número de clientes por página
		$this->load->library('pagination');
		$config['base_url'] = base_url('finContasReceber/index/');
		$config['total_rows'] = $this->FinContasReceber_model->recebeContasReceber($dataInicioFormatada, $dataFimFormatada, $statusConta, $setorEmpresa, $cookie_filtro_contas_receber, $limit, $page, true); // true para contar
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
		$this->pagination->initialize($config);
		// >>>> FIM PAGINAÇÃO <<<<<
		
		$data['contasReceber'] = $this->FinContasReceber_model->recebeContasReceber($dataInicioFormatada, $dataFimFormatada, $statusConta, $setorEmpresa,$cookie_filtro_contas_receber, $limit, $page);

		$this->load->library('finDadosFinanceiros');

		$data['saldoTotal'] = $this->findadosfinanceiros->somaSaldosBancarios();

		if ($statusConta == '1' || $statusConta == 'ambas') {
			$data['totalRecebido'] = $this->findadosfinanceiros->totalDadosFinanceiro('valor_recebido', 'fin_contas_receber', 1, $dataInicioFormatada, $dataFimFormatada, $setorEmpresa); // soma o valor total recebido

		} else {
			$data['totalRecebido']['valor_recebido'] = '00';
		}

		if ($statusConta == '0' || $statusConta == 'ambas') {

			$data['emAberto'] = $this->findadosfinanceiros->totalDadosFinanceiro('valor', 'fin_contas_receber', 0, $dataInicioFormatada, $dataFimFormatada, $setorEmpresa); // soma o valor total a receber

		} else {
			$data['emAberto']['valor'] = '00';
		}

		$data['porSetor'] = $this->findadosfinanceiros->somaSaldosBancariosSetor($setorEmpresa); // soma o valor total do setor específico

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/contas-receber');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraContasReceber()
	{
		$dadosLancamento = $this->input->post('dados');

		if ($dadosLancamento['grupo-recebido'] == 'clientes') {
			$data['id_cliente'] = $dadosLancamento['recebido'];
		} else if ($dadosLancamento['grupo-recebido'] == 'funcionarios') {
			$data['id_funcionario'] = $dadosLancamento['recebido'];
		} else {
			$data['id_dado_financeiro'] = $dadosLancamento['recebido'];
		}

		$data['id_empresa'] = $this->session->userdata('id_empresa');

		$data['valor'] = str_replace(['.', ','], ['', '.'], $dadosLancamento['valor']);

		$data['id_macro'] = $dadosLancamento['macros'];
		$data['id_micro'] = $dadosLancamento['micros'];
		$data['observacao'] = $dadosLancamento['observacao'];
		$data['id_setor_empresa'] = $dadosLancamento['setor'];
		$data['data_vencimento'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_vencimento'])));
		$data['data_emissao'] = !empty($dadosLancamento['data_emissao'])
			? date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_emissao'])))
			: null;


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

	public function visualizarConta()
	{
		$idConta = $this->input->post('idConta');

		$conta = $this->FinContasReceber_model->recebeContaReceber($idConta);

		if ($conta) {
			$response = array(
				'success' => true,
				'conta' => $conta
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
		$idDadoCliente = $this->input->post('idDadoCliente');
		$idFuncionario = $this->input->post('idFuncionario');

		$dataRecebimento = $this->input->post('dataRecebimento');

		$dataRecebimentoFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataRecebimento)));

		$valorTotalRecebido = 0;

		$micro = $this->FinContasReceber_model->recebeIdMicroContaReceber($idConta);

		$macro = $this->FinContasReceber_model->recebeIdMacroContaReceber($idConta);

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
			$dados['id_macro'] = $macro['id_macro'];
			$dados['id_micro'] = $micro['id_micro'];
			$dados['data_movimentacao'] = $dataRecebimentoFormatada;
			$dados['valor'] = $valoPagoFormatado;
			$dados['movimentacao_tabela'] = 1;
			$dados['id_dado_financeiro'] = $idDadoFinanceiro;
			$dados['id_cliente'] = $idDadoCliente;
			$dados['id_funcionario'] = $idFuncionario;
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

	public function recebeContaReceber()
	{
		$id = $this->input->post('id');
		$retorno = $this->FinContasReceber_model->recebeContaReceber($id);


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

	public function editaConta()
	{
		$id = $this->input->post('idConta');
		$dadosLancamento = $this->input->post('dados');

		$data = [
			'valor' => str_replace(['.', ','], ['', '.'], $dadosLancamento['valor']),
			'observacao' => $dadosLancamento['observacao'],
			'data_vencimento' => date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_vencimento']))),
			'data_emissao' => !empty($dadosLancamento['data_emissao'])
				? date('Y-m-d', strtotime(str_replace('/', '-', $dadosLancamento['data_emissao'])))
				: null,
			'id_setor_empresa' => $dadosLancamento['setor']
		];

		$retorno = $this->FinContasReceber_model->editaConta($id, $data);

		$response = [
			'success' => (bool) $retorno,
			'title' => $retorno ? "Sucesso!" : "Algo deu errado!",
			'message' => $retorno ? "Conta editada com sucesso!" : "Falha ao editar conta. Por favor, tente novamente.",
			'type' => $retorno ? "success" : "error"
		];

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletarConta()
	{
		$idConta = $this->input->post('idConta');

		$retorno = $this->FinContasReceber_model->deletaConta($idConta);

		if ($retorno) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Conta deletada com sucesso!",
				'type' => "success"
			);
		} else {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possivel deletar a conta!",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

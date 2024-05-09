<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinDre extends CI_Controller
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
		$this->load->library('finDadosFinanceiros');
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

		$data['dataInicio'] = $this->input->post('data_inicio');
        $data['dataFim'] = $this->input->post('data_fim');

		// define as datas padrão caso não sejam recebidas via POST
		$dataInicio = new DateTime();
		$dataInicio->modify('-30 days');
		$dataInicioFormatada = $dataInicio->format('Y-m-d');

		$dataFim = new DateTime();
		$dataFimFormatada = $dataFim->format('Y-m-d');

		// verifica se as datas foram recebidas via POST
		if ($this->input->post('data_inicio') && $this->input->post('data_fim')) {
			$dataInicioFormatada = $this->input->post('data_inicio');
			$dataFimFormatada = $this->input->post('data_fim');

			// converte as datas para o formato americano (Y-m-d)
			$dataInicioFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataInicioFormatada)));
			$dataFimFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataFimFormatada)));
		}

		//soma as movimentacoes da tabela fluxo.
		$data['totalSaida'] = $this->findadosfinanceiros->totalFluxoFinanceiro('valor', 0, $dataInicioFormatada, $dataFimFormatada);
		$data['totalEntrada'] = $this->findadosfinanceiros->totalFluxoFinanceiro('valor', 1, $dataInicioFormatada, $dataFimFormatada);

		$data['balancoFinanceiro'] = $data['totalEntrada']['valor'] - $data['totalSaida']['valor'];

		if (!empty($data['totalEntrada']['valor'])) {

			$data['porcentagemFaturamento'] = ($data['totalEntrada']['valor'] - $data['totalSaida']['valor']) / $data['totalEntrada']['valor'] * 100;
		} else {
			$data['porcentagemFaturamento'] = 0;
		}

		

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/dre');
		$this->load->view('admin/includes/painel/rodape');
	}
}

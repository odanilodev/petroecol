<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Mpdf\Mpdf;

class Relatorios extends CI_Controller
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
		$this->load->model('Permissao_model');
		date_default_timezone_set('America/Sao_Paulo');
	}

	public function relColetas()
	{
		$this->load->model('Clientes_model');
		$this->load->model('Grupos_model');

		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts romaneio
		$scriptsRelColetasHead = scriptsRelColetasHead();
		$scriptsRelColetasFooter = scriptsRelColetasFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsRelColetasHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsRelColetasFooter));

		$data['clientes'] = $this->Clientes_model->recebeTodosClientes();
		$data['grupos'] = $this->Grupos_model->recebeGrupos();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/relatorios/relcoletas/relcoletas');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function gerarRelatorioColetas()
	{

		$this->load->model('GrupoCliente_model');

		$clientes = explode(',', $this->input->post('clientes'));
		$grupos = explode(',', $this->input->post('grupos'));
		$data_inicio = $this->input->post('data_inicio');
		$data_fim = $this->input->post('data_fim');

		if (!empty($this->input->post('grupos'))) {
			$clientes = array_column($this->GrupoCliente_model->recebeIdClientesPorGrupos($grupos), 'id_cliente');
		}

		$this->load->model('Coletas_model');
		$idsColetasClientes = array_column($this->Coletas_model->recebeIdColetasClientesAll($clientes, $data_inicio, $data_fim), 'id');

		$this->gerarPdfRelatorioColetas($idsColetasClientes);
	}

	public function gerarPdfRelatorioColetas($idColetaClientes)
	{
		$this->load->library('detalhesColeta');
		$this->load->library('formasPagamentoChaveId');
		$this->load->library('residuoChaveId');
		$this->load->library('residuoPagamentoCliente');

		$dados = [];
		$clientes = [];
		foreach ($idColetaClientes as $idColeta) {
			$historicoColeta = $this->detalhescoleta->detalheColeta($idColeta);
			$array['dataColeta'] = date('d/m/Y', strtotime($historicoColeta['coleta']['data_coleta']));
			$array['residuos'] = json_decode($historicoColeta['coleta']['residuos_coletados'], true);
			$array['quantidade_coletada'] = json_decode($historicoColeta['coleta']['quantidade_coletada'], true);
			$array['pagamentos'] = json_decode($historicoColeta['coleta']['forma_pagamento'], true);
			$array['valor_pagamento'] = json_decode($historicoColeta['coleta']['valor_pago'], true);
			$array['cliente'] = $historicoColeta['coleta'];
			$clientes[] = $historicoColeta['coleta']['id_cliente'];
			$dados[] = $array;
		}

		// todos residuos cadastrado na empresa
		$data['residuos'] = $this->residuochaveid->residuoArrayChaveId();
		// todas formas de pagamento cadastrado na empresa
		$data['formasPagamento'] = $this->formaspagamentochaveid->formaPagamentoArrayChaveId();
		// Forma de pagamento por residuo
		$data['residuoPagamentoCliente'] = $this->residuopagamentocliente->residuoPagamentoClienteArrayChaveId(array_unique($clientes));


		$data['dados'] = $this->estruturaColetas($dados);

		echo '<pre>';
		print_r($data);
		exit;

		if ($dados) {

			$mpdf = new Mpdf;
			$html = $this->load->view('admin/paginas/relatorios/relcoletas/relcoletas-pdf', $data, true);
			$mpdf->WriteHTML($html);

			// Retorna o conteúdo do PDF
			return $mpdf->Output('', \Mpdf\Output\Destination::INLINE, "L");
		} else {

			// scripts padrão
			$scriptsPadraoHead = scriptsPadraoHead();
			$scriptsPadraoFooter = scriptsPadraoFooter();

			add_scripts('header', $scriptsPadraoHead);
			add_scripts('footer', $scriptsPadraoFooter);

			$data['titulo'] = "Dados não encontrado!";
			$data['descricao'] = "Não foi possível localizar coleta para este(s) cliente(s)!";

			$this->load->view('admin/erros/erro-pdf', $data);
		}
	}

	public function estruturaColetas($data)
	{

		// echo '<pre>';
		// print_r($data);
		// exit;
		$array = [];
		$dados = [];
		foreach ($data as $dado) {

			if (in_array($dado['cliente']['id'], $array)) {
				array_push($dados[$dado['cliente']['id']]['coletas'], $dado['dataColeta']);
			} else {
				array_push($array, $dado['cliente']['id']);
				$dados[$dado['cliente']['id']] = $dado['cliente'];
				$dados[$dado['cliente']['id']]['coletas'][] = $dado['dataColeta'];
			}
		}
		return $dados;
	}
}

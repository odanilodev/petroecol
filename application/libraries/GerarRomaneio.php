<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Mpdf\Mpdf;

class GerarRomaneio
{
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('Romaneios_model');
		$this->CI->load->model('Clientes_model');
		$this->CI->load->model('Agendamentos_model');
		$this->CI->load->model('RecipienteCliente_model');
	}

	public function gerarPdf($codigo, $IA = false)
	{
		$romaneio = $this->CI->Romaneios_model->recebeRomaneioCod($codigo);

		$data['id_cliente_prioridade'] = $this->CI->Agendamentos_model->recebeAgendamentoPrioridade($romaneio['data_romaneio']);

		if ($romaneio) {

			$idClientes = json_decode($romaneio['clientes'], true);

			$this->CI->load->model('Coletas_model');

			$data['ultimas_coletas'] = $this->CI->Coletas_model->ultimaColetaCLiente($idClientes);

			$data['clientes'] = $this->CI->Clientes_model->recebeClientesIds($idClientes, $romaneio['id_setor_empresa']);

			if ($IA) {
				$this->CI->load->library('apiChatGpt');
				$idsClientesOrdenadoPelaIA = $this->CI->apichatgpt->organizarCoordenadas($data['clientes'], $this->CI->session->userdata('latitude'), $this->CI->session->userdata('longitude'));
				$data['clientes'] = $this->ordenarClientesPorArrayDeIds($data['clientes'], $idsClientesOrdenadoPelaIA);
			}

			$data['obsAgendamento'] = $this->CI->Agendamentos_model->recebeObservacaoAgendamentoCliente($romaneio['data_romaneio']);

			$recipientes_clientes = $this->CI->RecipienteCliente_model->recebeRecipientesCliente($idClientes) ?? [];

			$data['recipientes_clientes'] = $this->recipientesClientes($recipientes_clientes);

			$data['codigo'] = $codigo;
			$data['data_romaneio'] = $romaneio['data_romaneio'];
			$data['responsavel'] = $romaneio['RESPONSAVEL'];
			$data['placa'] = $romaneio['placa'];

			$mpdf = new Mpdf(['orientation' => 'L']);
			$html = $this->CI->load->view('admin/paginas/romaneio/romaneio-pdf', $data, true);
			$mpdf->WriteHTML($html);

			// Retorna o conteúdo do PDF
			return $mpdf->Output('', \Mpdf\Output\Destination::INLINE);
		} else {

			// scripts padrão
			$scriptsPadraoHead = scriptsPadraoHead();
			$scriptsPadraoFooter = scriptsPadraoFooter();

			add_scripts('header', $scriptsPadraoHead);
			add_scripts('footer', $scriptsPadraoFooter);

			$data['titulo'] = "Romaneio não encontrado!";
			$data['descricao'] = "Não foi possível localizar um romaneio!";

			$this->CI->load->view('admin/erros/erro-pdf', $data);
		}
	}

	public function recipientesClientes(array $recipientes_clientes): array
	{
		$recipientesAgrupados = [];
		foreach ($recipientes_clientes as $recipiente) {

			$idCliente = $recipiente['id_cliente'];

			$recipientesAgrupados[$idCliente][] = $recipiente;
		}

		return $recipientesAgrupados;
	}

	public function ordenarClientesPorArrayDeIds($clientes, $idsClientesOrdenadoPelaIA)
	{
		$clientesOrdenados = [];
		foreach ($idsClientesOrdenadoPelaIA as $idOrdenado) {
			foreach ($clientes as $cliente) {
				if ($cliente['id'] == $idOrdenado) {
					$clientesOrdenados[] = $cliente;
					break;
				}
			}
		}
		return $clientesOrdenados;
	}
}

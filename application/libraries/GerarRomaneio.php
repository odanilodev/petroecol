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
	}

	public function gerarPdf($codigo)
	{
		$romaneio = $this->CI->Romaneios_model->recebeRomaneioCod($codigo);
		$data['id_cliente_prioridade'] = $this->CI->Agendamentos_model->recebeAgendamentoPrioridade($romaneio['data_romaneio']);

		if ($romaneio) {

			$idClientes = json_decode($romaneio['clientes'], true);

			$data['clientes'] = $this->CI->Clientes_model->recebeClientesIds($idClientes);

			$this->CI->load->model('RecipienteCliente_model');
			$data['recipientes_clientes'] = $this->CI->RecipienteCliente_model->recebeRecipientesCliente($idClientes);

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
}

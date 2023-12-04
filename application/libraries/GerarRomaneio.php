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
	}

	public function gerarPdf($codigo)
	{
		$romaneio = $this->CI->Romaneios_model->recebeRomaneioCod($codigo);

		if ($romaneio) {

			$idClientes = json_decode($romaneio['clientes'], true);

			$data['clientes'] = $this->CI->Clientes_model->recebeClientesIds($idClientes);
			$data['codigo'] = $codigo;

			$mpdf = new Mpdf(['orientation' => 'L']);
			$html = $this->CI->load->view('admin/romaneios/romaneio-etiquetas', $data, true);
			$mpdf->WriteHTML($html);
			$mpdf->Output('romaneio-etiqueta.pdf', \Mpdf\Output\Destination::INLINE);
		} else {

			echo 'Criar uma view para romaneio não encontrado';
			exit;
		}
	}
}

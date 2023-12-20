<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Mpdf\Mpdf;

class GerarCertificadoColeta
{
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('Clientes_model');
		$this->CI->load->model('Coletas_model');
	}

	public function gerarPdf($idCliente)
	{
		$data['cliente'] = $this->CI->Clientes_model->recebeCliente($idCliente);
		$data['coletas'] = $this->CI->Coletas_model->recebeColetasClienteResiduos($idCliente);

		if ($data['cliente']) {
			
			$mpdf = new Mpdf;
			$html = $this->CI->load->view('admin/paginas/certificados/certificados', $data, true);
			$mpdf->WriteHTML($html);

			// Retorna o conteúdo do PDF
			return $mpdf->Output('', \Mpdf\Output\Destination::INLINE);
		} else {
			echo 'Criar uma view para romaneio não encontrado';
			exit;
		}
	}

	


}

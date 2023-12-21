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
		$data['clientes_coletas'] = $this->CI->Coletas_model->recebeColetasClienteResiduos($idCliente);

		if ($data['clientes_coletas']) {

			$data['residuos_coletados'] = explode(',', $data['clientes_coletas'][0]['nomes_residuos']);
			$data['quantidade_residuos_coletados'] = json_decode($data['clientes_coletas'][0]['quantidade_coletada'], true);
			$data['medida_residuos_coletados'] =  explode(',', $data['clientes_coletas'][0]['unidade_medida']);


			$mpdf = new Mpdf;
			$html = $this->CI->load->view('admin/paginas/certificados/certificados', $data, true);
			$mpdf->WriteHTML($html);

			// Retorna o conteúdo do PDF
			return $mpdf->Output('', \Mpdf\Output\Destination::INLINE);
		} else {

			$data['titulo'] = "Certificado não encontrado!";
			$data['descricao'] = "Não foi possível localizar um certificado de coleta para este cliente!";

			$this->CI->load->view('admin/erros/erro-pdf', $data);
		}
	}
}

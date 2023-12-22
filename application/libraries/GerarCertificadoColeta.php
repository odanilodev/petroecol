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

	public function gerarPdf($idColeta)
	{
		$data['clientes_coletas'] = $this->CI->Coletas_model->recebeColetasClienteResiduos($idColeta);

		if ($data['clientes_coletas']) {

			$data['residuos_coletados'] = explode(',', $data['clientes_coletas']['nomes_residuos']);
			$data['quantidade_residuos_coletados'] = json_decode($data['clientes_coletas']['quantidade_coletada'], true);
			$data['medida_residuos_coletados'] =  explode(',', $data['clientes_coletas']['unidade_medida']);


			$mpdf = new Mpdf;
			$html = $this->CI->load->view('admin/paginas/certificados/certificados', $data, true);
			$mpdf->WriteHTML($html);

			// Retorna o conteúdo do PDF
			return $mpdf->Output('', \Mpdf\Output\Destination::INLINE);
		} else {

			// scripts padrão
			$scriptsPadraoHead = scriptsPadraoHead();
			$scriptsPadraoFooter = scriptsPadraoFooter();

			add_scripts('header', $scriptsPadraoHead);
			add_scripts('footer', $scriptsPadraoFooter);

			$data['titulo'] = "Certificado não encontrado!";
			$data['descricao'] = "Não foi possível localizar um certificado de coleta para este cliente!";

			$this->CI->load->view('admin/erros/erro-pdf', $data);
		}
	}
}

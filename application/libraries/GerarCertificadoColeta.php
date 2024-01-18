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
		$this->CI->load->model('Certificados_model');
	}

	public function gerarPdfPadrao($idColeta, $idModelo)
	{
		$this->CI->load->library('detalhesColeta');

		if (strpos($idColeta, '-') !== false) { // mais de uma coleta
			$idsColetas = explode("-", $idColeta);
		} else {
			$idsColetas = [$idColeta];
		}

		$dados = [];
		foreach ($idsColetas as $id) {
			$historicoColeta = $this->CI->detalhescoleta->detalheColeta($id);
			$array['dataColeta'] = date('d/m/Y', strtotime($historicoColeta['coleta']['data_coleta']));
			$array['residuos'] = json_decode($historicoColeta['coleta']['residuos_coletados'], true);
			$array['quantidade_coletada'] = json_decode($historicoColeta['coleta']['quantidade_coletada'], true);
			$dados[] = $array;
		}

		$data['dados'] = $dados;

		// todos residuos cadastrado na empresa
		$data['residuosColetatos'] = $historicoColeta['residuos'];
		// dados cliente
		$data['clientes_coletas'] = $historicoColeta['coleta'];
		// modelo do certificado
		$data['modelo_certificado'] = $this->CI->Certificados_model->recebeCertificadoId($idModelo);

		if ($data['clientes_coletas']) {

			$mpdf = new Mpdf;

			if ($data['modelo_certificado']['orientacao'] == 'horizontal') {

				$mpdf->AddPage('L');
				$html = $this->CI->load->view('admin/paginas/certificados/certificado-horizontal', $data, true);
			} else {

				$html = $this->CI->load->view('admin/paginas/certificados/certificado-pdf', $data, true);
			}

			$mpdf->WriteHTML($html);

			// marca d'água no PDF
			if ($data['modelo_certificado']['marca_agua']) {
				$marcaDagua = base_url_upload('certificados/marcas-agua/' . $data['modelo_certificado']['marca_agua']);
				$rotacao = 45;
				$mpdf->SetWatermarkImage($marcaDagua);
				$mpdf->showWatermarkImage = true;
			}


			// Retorna o conteúdo do PDF
			return $mpdf->Output('', \Mpdf\Output\Destination::INLINE, "L");
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

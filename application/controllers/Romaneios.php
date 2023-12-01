<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Romaneios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// INICIO controle sessão
		$this->load->library('Controle_sessao');
		$res = $this->controle_sessao->controle();
		if ($res == 'erro') {
			redirect('login/erro', 'refresh');
		}
		// FIM controle sessão

		require FCPATH . 'vendor/autoload.php';
	}

	public function gerarRomaneioEtiqueta()
	{
		$this->load->model('EtiquetaCliente_model');
		$this->load->model('Clientes_model');
		$this->load->model('Romaneios_model');


		$idEtiqueta = $this->uri->segment(3);

		$etiquetas = $this->EtiquetaCliente_model->recebeTotalEtiquetasId($idEtiqueta);

		// Criar um array para armazenar os id_cliente
		$idClientes = array();

		// Iterar sobre o array de etiquetas para coletar os id_cliente
		foreach ($etiquetas as $etiqueta) {
			$idClientes[] = $etiqueta['id_cliente'];
		}

		$data['clientes'] = $this->Clientes_model->recebeClientesIds($idClientes);
		
		$dados['clientes'] = json_encode($data['clientes']);

		$dados['codigo'] = date('ymd').$this->Romaneios_model->recebeUltimoIdCadastrado();
		
		$data['codigo'] = $dados['codigo'];

		$this->Romaneios_model->insereRomaneio($dados);

		$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); // 'L' indica paisagem

		// Carregar a visualização no mPDF
		$html = $this->load->view('admin/romaneios/romaneio-etiquetas', $data, true);
		$mpdf->WriteHTML($html);

		$mpdf->Output('romaneio-etiqueta.pdf', \Mpdf\Output\Destination::INLINE);
	}

	public function verificaRomaneioEtiqueta()
	{
		$this->load->model('EtiquetaCliente_model');

		$idEtiqueta = $this->input->post('id');

		$etiquetas = $this->EtiquetaCliente_model->recebeTotalEtiquetasId($idEtiqueta);

		if(!$etiquetas) {
			
			$response = array(
				'retorno' => false
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}
}

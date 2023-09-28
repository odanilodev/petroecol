<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EtiquetaCliente extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// INICIO controle sessão
        $this->load->library('Controle_sessao');
        $res = $this->controle_sessao->controle();
        if($res == 'erro'){ redirect('login/erro', 'refresh');}
        // FIM controle sessão

		$this->load->model('EtiquetaCliente_model');
	}

	public function cadastraEtiquetaCliente()
	{
		$dados['id_cliente'] = $this->input->post('id_cliente');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$nomeEtiqueta = $this->input->post('nome_etiqueta');

		$id_etiqueta = $this->input->post('id_etiqueta');

		foreach ($id_etiqueta as $v) {

			$dados['id_etiqueta'] = $v;

			$etiqueta = $this->EtiquetaCliente_model->recebeIdEtiquetaCliente($dados['id_etiqueta'], $dados['id_cliente']); // verifica se a etiqueta já está vinculada ao cliente

			// se a etiqueta já está vinculada, retorna um aviso
			if ($etiqueta) {
				
				$response = array(
					'success' => false,
					'message' => "Esta etiqueta já está atribuída. Tente uma diferente!"
				);

			} else {

				$this->EtiquetaCliente_model->insereEtiquetaCliente($dados);

				$novaEtiqueta[] = '
				<span class="fw-bold fs--1 text-light lh-2 mr-5 badge rounded-pill bg-secondary my-1 mx-1"> 
					' . array_shift($nomeEtiqueta) . 
				'</span>';

				$response = array(
					'success' => true,
					'message' => $novaEtiqueta
				);

			}

		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaEtiquetaCliente()
	{
		$id = $this->input->post('id');

		$this->EtiquetaCliente_model->deletaEtiquetaCliente($id);
	}

	// exibe as etiquetas de cada cliente dentro do modal
	public function recebeEtiquetaCliente()
	{
		$id_cliente = $this->input->post('id_cliente');

		$etiquetas = $this->EtiquetaCliente_model->recebeEtiquetaCliente($id_cliente);

		foreach($etiquetas as $v) {
			echo '
			<span class="fw-bold fs--1 text-light lh-2 mr-5 badge rounded-pill bg-secondary my-1 mx-1 etiqueta-' . $v['id'] . '"> 
				' . $v['nome'] . '
				<a href="#" class="text-light">
					<i class="fas fa-times-circle delete-icon" onclick="deletaEtiquetaCliente(' . $v['id'] . ')"></i>
				</a>
			</span>';

		}
	}
}

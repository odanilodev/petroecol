<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EtiquetaCliente extends CI_Controller
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

		$this->load->model('EtiquetaCliente_model');
	}

	public function cadastraEtiquetaCliente()
	{
		$dados['id_cliente'] = $this->input->post('id_cliente');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$nomeEtiqueta = $this->input->post('nome_etiqueta');
		$id_etiqueta = $this->input->post('id_etiqueta');

		// todas etiquetas do cliente
		$etiquetasNoBanco = $this->EtiquetaCliente_model->recebeEtiquetaCliente($dados['id_cliente']);

		// verifica se a etiqueta já existe para esse cliente
		if (in_array($id_etiqueta, array_column($etiquetasNoBanco, 'id_etiqueta'))) {

			$response = array(
				'success' => false,
				'message' => 'Esta etiqueta já está cadastrado para o cliente.'
			);

		} else {

			$dados['id_etiqueta'] = $id_etiqueta;
			$inseridoId = $this->EtiquetaCliente_model->insereEtiquetaCliente($dados);

			if ($inseridoId) {

				$novaEtiqueta = '
                <span class="badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 etiqueta-' . $inseridoId . '">
                    <span class="badge-label">
                        ' . $nomeEtiqueta . '
                        <a href="#">
                            <i class="fas fa-times-circle delete-icon" onclick="deletaEtiquetaCliente(' . $inseridoId . ')"></i>
                        </a>
                    </span>
                </span>';

				$response = array(
					'success' => true,
					'message' => $novaEtiqueta
				);

			} else {
				$response = array(
					'success' => false,
					'message' => 'Falha ao cadastrar a etiqueta.'
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

		foreach ($etiquetas as $v) {
			echo '
			<span class="fw-bold lh-2 mr-5 badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 etiqueta-' . $v['id'] . '"> 
				' . $v['nome'] . '
				<a href="#">
					<i class="fas fa-times-circle delete-icon" onclick="deletaEtiquetaCliente(' . $v['id'] . ')"></i>
				</a>
			</span>';
		}
	}

	public function recebeClientesEtiqueta ()
	{
		$id_etiqueta = $this->input->post('id_etiqueta');

		$clientesEtiqueta = $this->EtiquetaCliente_model->recebeClientesEtiqueta($id_etiqueta);

		$response = array(
			'success' => true,
			'clientesEtiqueta' => $clientesEtiqueta
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));

	}
}

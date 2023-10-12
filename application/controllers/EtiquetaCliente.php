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
		if ($res == 'erro') {
			redirect('login/erro', 'refresh');
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

		$etiquetasRepetidas = []; // Array para rastrear as etiquetas já cadastradas
		$etiquetasInseridas = []; // Array para rastrear as etiquetas que foram inseridas

		$c = 0;
		foreach ($id_etiqueta as $v) {

			$dados['id_etiqueta'] = $v;

			$etiqueta = $this->EtiquetaCliente_model->recebeIdEtiquetaCliente($dados['id_etiqueta'], $dados['id_cliente']); // verifica se a etiqueta já está vinculada ao cliente

			if ($etiqueta) {

				// Se a etiqueta já está vinculada, adicione-a ao array de etiquetas cadastradas
				$etiquetasRepetidas[] = $etiqueta['nome'];

			} else {

				$inseridoId = $this->EtiquetaCliente_model->insereEtiquetaCliente($dados);

				if ($inseridoId) {

					// Exibe a etiqueta no front com o ID
					$novaEtiqueta = '
					<span class="badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 etiqueta-' . $inseridoId . '">
						<span class="badge-label">
							' . $nomeEtiqueta[$c] . '
							<a href="#">
								<i class="fas fa-times-circle delete-icon" onclick="deletaEtiquetaCliente(' . $inseridoId . ')"></i>
							</a>
						</span>
					</span>';

					$etiquetasInseridas[] = $novaEtiqueta;
				}
			}

			$c++;
		}

		// Crie uma string com as etiquetas inseridas
		$etiquetasInseridasString = implode('', $etiquetasInseridas);

		if (!empty($etiquetasRepetidas)) {

			// Se houver etiquetas cadastradas, retorne um aviso com as etiquetas que já estão cadastradas
			$response = array(
				'success' => false,
				'etiqueta' => $etiquetasInseridasString,
				'message' => 'As seguintes etiquetas já estão cadastradas: ' . implode(', ', $etiquetasRepetidas),
			);
		} else {
			// Se não houver etiquetas cadastradas, retorne as etiquetas inseridas
			$response = array(
				'success' => true,
				'message' => $etiquetasInseridasString
			);
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
}

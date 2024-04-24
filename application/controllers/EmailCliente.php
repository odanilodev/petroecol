<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmaiCliente extends CI_Controller
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

		$this->load->model('EmailCliente_model');
	}

	public function cadastraEmailCliente()
	{

		$dados['id_cliente'] = $this->input->post('id_cliente');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$email_cliente = $this->input->post('emailCliente');
		$dados['grupo'] = $this->input->post('grupo');

		// todos os emails do cliente
		$emailsNoBanco = $this->EmailCliente_model->recebeEmailCliente($dados['id_cliente']);

		// verifica se o email já existe para esse cliente
		if (in_array($email_cliente, array_column($emailsNoBanco, 'email'))) {

			$response = array(
				'success' => false,
				'message' => 'Este email já está cadastrado para o cliente.'
			);
		} else {

			$dados['email'] = $email_cliente;
			$inseridoId = $this->EmailCliente_model->insereEmailCliente($dados);

			if ($inseridoId) {

				$novoEmail = '
                <span class="badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 email-' . $dados['email'] . '">
                    <span class="badge-label">
                        ' . $email_cliente . '
                        <a href="#">
                            <i class="fas fa-times-circle delete-icon" onclick="deletaEmailCliente(' . $inseridoId . ')"></i>
                        </a>
												<a href="#" class="btn-ver-email" title="Editar Email">
														<i class="fas fa-pencil-alt edita-email edita-email-' . $email_cliente . '" onclick="verEmailCliente(\'' . $email_cliente . '\')"></i>
												</a>
                    </span>
                </span>';

				$response = array(
					'success' => true,
					'message' => $novoEmail
				);
			} else {
				$response = array(
					'success' => false,
					'message' => 'Falha ao cadastrar o email.'
				);
			}
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaEmailCliente()
	{
		$id = $this->input->post('id');

		$this->EmailCliente_model->deletaEmailCliente($id);
	}

	// exibe as etiquetas de cada cliente dentro do modal
	public function recebeEmailCliente()
	{
		$id_cliente = $this->input->post('id_cliente');

		$emails = $this->EmailCliente_model->recebeEmailCliente($id_cliente);

		foreach ($emails as $v) {
			echo '
			<span class="fw-bold lh-2 mr-5 badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 email-' . $v['id'] . '"> 
				' . $v['email'] . '
				<a href="#">
					<i class="fas fa-times-circle delete-icon" onclick="deletaEmailCliente(' . $v['id'] . ')"></i>
				</a>
				<a href="#" class="btn-ver-email" title="Editar Email">
					<i class="fas fa-pencil-alt edita-email edita-email-' . $v['id'] . '" onclick="verResiduoCliente(\'' . $emailCliente . '\')"></i>
				</a>
			</span>';
		}
	}

	// public function recebeClientesEtiqueta()
	// {
	// 	$id_etiqueta = $this->input->post('id_etiqueta');
	// 	$id_setor = $this->input->post('id_setor');

	// 	$clientesEtiqueta = $this->EtiquetaCliente_model->recebeClientesEtiqueta($id_etiqueta, $id_setor);

	// 	$response = array(
	// 		'success' => true,
	// 		'clientesEtiqueta' => $clientesEtiqueta
	// 	);

	// 	return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	// }
}

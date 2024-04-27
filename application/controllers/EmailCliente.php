<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmailCliente extends CI_Controller
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
		$dados['id_cliente'] = $this->input->post('idCliente');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');
		$dados['email'] = strtolower($this->input->post('emailCliente'));
		$verificarEmail = $this->input->post('verificaEmail');
		$dados['id_grupo'] = $this->input->post('idGrupo');
		$nomeGrupo = $this->input->post('nomeGrupo');
		$idEmail = $this->input->post('idEmail');

		$emailCliente = $dados['email'];
		$grupoCliente = $dados['id_grupo'];

		// todos os emails do cliente
		$emailsNoBanco = $this->EmailCliente_model->recebeEmailCliente($dados['id_cliente']);

		// Verifica se o email existe ao cadastrar ou editar
		if ((in_array($dados['email'], array_column($emailsNoBanco, 'email'))) && $verificarEmail != 'true') {

			$response = array(
				'success' => false,
				'message' => 'Este email já está cadastrado para o cliente.'
			);
			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		// verifica se existe id do email, para editar e se o email já existe para esse cliente
		if ($idEmail) {

			$editado = $this->EmailCliente_model->editaEmailCliente($idEmail, $dados['id_cliente'], $dados);

			$response = array(
				'success' => $editado,
				'id' => $idEmail,
				'message' => 'Email editado com sucesso',
				'email' => $emailCliente,
				'nomeGrupo' => $nomeGrupo,
				'grupoEmail' => $grupoCliente,
				'editado' => true
			);
		} else {

			$inseridoId = $this->EmailCliente_model->insereEmailCliente($dados);

			if ($inseridoId) {

				$novoEmail = '
					<span class="badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 email-' . $inseridoId . '">
						<span class="badge-label">
								<span class="txt-email-' . $inseridoId . '">' . $emailCliente . ' - ' . $nomeGrupo . ' </span>
								<a href="#">
										<i class="fas fa-times-circle delete-icon" onclick="deletaEmailCliente(' . $inseridoId . ')"></i>
								</a>
								<a href="#" class="btn-ver-email" title="Editar Email">
										<i class="fas fa-pencil-alt edita-email edita-email-' . $inseridoId . '" onclick="verEmailCliente(\'' . $emailCliente . '\', \'' . $grupoCliente . '\', \'' . $inseridoId . '\')"></i>
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

	// exibe os emails do cliente dentro do modal
	public function recebeEmailCliente()
	{
		$id_cliente = $this->input->post('id_cliente');

		$emails = $this->EmailCliente_model->recebeEmailCliente($id_cliente);

		foreach ($emails as $v) {
			echo '
			<span class="fw-bold lh-2 mr-5 badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 email-' . $v['id'] . '"> 
				<span class="txt-email-' . $v['id'] . '">' . $v['email'] . ' - ' . $v['grupo'] . '</span>
				<a href="#">
					<i class="fas fa-times-circle delete-icon" onclick="deletaEmailCliente(' . $v['id'] . ')"></i>
				</a>
				<a href="#" class="btn-ver-email" title="Editar Email">
					<i class="fas fa-pencil-alt edita-email edita-email-' . $v['id'] . '" onclick="verEmailCliente(\'' . $v['email'] . '\', \'' . $v['ID_GRUPO'] . '\',\'' . $v['id'] . '\')"></i>
				</a>
			</span>';
		}
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RecipienteCliente extends CI_Controller
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

		$this->load->model('RecipienteCliente_model');
		$this->load->model('recipientes_model');

	}

	public function cadastraRecipienteCliente()
	{
		$dados['id_cliente'] = $this->input->post('id_cliente');
		$dados['quantidade'] = $this->input->post('quantidade');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$nomeRecipiente = $this->input->post('nome_recipiente');
		$id_recipiente = $this->input->post('id_recipiente');


		if ($dados['quantidade'] == 0 or $dados['quantidade'] == '') {

			$response = array(
				'success' => false,
				'message' => 'Digite uma quantidade de recipiente maior que zero'
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));

		}

		// todos recipientes do cliente
		$recipientesNoBanco = $this->RecipienteCliente_model->recebeRecipienteCliente($dados['id_cliente']);

		// verifica se o recipiente já existe para esse cliente
		if (in_array($id_recipiente, array_column($recipientesNoBanco, 'id_recipiente'))) {

			$response = array(
				'success' => false,
				'message' => 'Este recipiente já está cadastrado para o cliente.'
			);
		} else {

			$recipiente = $this->recipientes_model->recebeRecipiente($id_recipiente);

			if ($recipiente['quantidade'] < $dados['quantidade']) {

				$response = array(
					'success' => false,
					'message' => "Não existe a quantidade solicitada do recipiente em estoque!"
				);
	
				return $this->output->set_content_type('application/json')->set_output(json_encode($response));
			}
			

			$dados['id_recipiente'] = $id_recipiente;
			$inseridoId = $this->RecipienteCliente_model->insereRecipienteCliente($dados);

			if ($inseridoId) {

				$data['quantidade'] = $recipiente['quantidade'] - $dados['quantidade'];

				$this->recipientes_model->editaRecipiente($id_recipiente, $data);

				$novoRecipiente = '
                <span class="badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 recipiente-' . $inseridoId . '">
                    <span class="badge-label">
                        ' . $nomeRecipiente . " - " .  $dados['quantidade'] . " Uni" . '
                        <a href="#">
                            <i class="fas fa-times-circle delete-icon" onclick="deletaRecipienteCliente(' . $inseridoId . ')"></i>
                        </a>
                    </span>
                </span>';

				$response = array(
					'success' => true,
					'message' => $novoRecipiente
				);
			} else {
				$response = array(
					'success' => false,
					'message' => 'Falha ao cadastrar o recipiente.'
				);
			}
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaRecipienteCliente()
	{
		$id = $this->input->post('id');

		$recipienteCliente = $this->RecipienteCliente_model->recebeRecipiente($id);

		$dados = $this->recipientes_model->recebeRecipiente($recipienteCliente['id_recipiente']);

		$dados['quantidade'] = $recipienteCliente['quantidade'] + $dados['quantidade'];

		$this->recipientes_model->editaRecipiente($recipienteCliente['id_recipiente'], $dados);

		$this->RecipienteCliente_model->deletaRecipienteCliente($id);
	}

	// exibe os recipientes de cada cliente dentro do modal
	public function recebeRecipienteCliente()
	{
		$id_cliente = $this->input->post('id_cliente');

		$recipientes = $this->RecipienteCliente_model->recebeRecipienteCliente($id_cliente);

		foreach ($recipientes as $v) {
			echo '
			<span class="fw-bold lh-2 mr-5 badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 recipiente-' . $v['id'] . '"> 
				' . $v['nome_recipiente'] . " - " .  $v['quantidade'] . " Uni" .  '
				<a href="#">
					<i class="fas fa-times-circle delete-icon" onclick="deletaRecipienteCliente(' . $v['id'] . ')"></i>
				</a>
			</span>';
		}
	}
}
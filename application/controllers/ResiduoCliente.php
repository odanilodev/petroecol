<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ResiduoCliente extends CI_Controller
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

		$this->load->model('ResiduoCliente_model');
	}

	public function cadastraResiduoCliente()
	{
		$dados['id_cliente'] = $this->input->post('id_cliente');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$nomeResiduo = $this->input->post('nome_residuo');
		$id_residuo = $this->input->post('id_residuo');

		// todos resíduos do cliente
		$residuosNoBanco = $this->ResiduoCliente_model->recebeResiduoCliente($dados['id_cliente']);

		// verifica se o resíduo já existe para esse cliente
		if (in_array($id_residuo, array_column($residuosNoBanco, 'id_residuo'))) {

			$response = array(
				'success' => false,
				'message' => 'Este resíduo já está cadastrado para o cliente.'
			);

		} else {
			
			$dados['id_residuo'] = $id_residuo;
			$inseridoId = $this->ResiduoCliente_model->insereResiduoCliente($dados);

			if ($inseridoId) {

				$novoResiduo = '
                <span class="badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 residuo-' . $inseridoId . '">
                    <span class="badge-label">
                        ' . $nomeResiduo . '
                        <a href="#">
                            <i class="fas fa-times-circle delete-icon" onclick="deletaResiduoCliente(' . $inseridoId . ')"></i>
                        </a>
                    </span>
                </span>';
				
				$response = array(
					'success' => true,
					'message' => $novoResiduo
				);

			} else {
				$response = array(
					'success' => false,
					'message' => 'Falha ao cadastrar o resíduo.'
				);
			}
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaResiduoCliente()
	{
		$id = $this->input->post('id');

		$this->ResiduoCliente_model->deletaResiduoCliente($id);
	}

	// exibe os redisuos de cada cliente dentro do modal
	public function recebeResiduoCliente()
	{
		$id_cliente = $this->input->post('id_cliente');

		$residuos = $this->ResiduoCliente_model->recebeResiduoCliente($id_cliente);

		foreach ($residuos as $v) {
			echo '
			<span class="fw-bold lh-2 mr-5 badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 residuo-' . $v['id'] . '"> 
				' . $v['nome'] . '
				<a href="#">
					<i class="fas fa-times-circle delete-icon" onclick="deletaResiduoCliente(' . $v['id'] . ')"></i>
				</a>
			</span>';
		}
	}
}

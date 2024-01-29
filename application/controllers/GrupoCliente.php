<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GrupoCliente extends CI_Controller
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

		$this->load->model('GrupoCliente_model');
	}

	public function cadastraGrupoCliente()
	{
		$dados['id_cliente'] = $this->input->post('id_cliente');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$nomeGrupo = $this->input->post('nome_grupo');
		$id_grupo = $this->input->post('grupo');

		// todos os grupos do cliente
		$gruposNoBanco = $this->GrupoCliente_model->recebeGrupoCliente($dados['id_cliente']);

		// verifica se o grupo já existe para esse cliente
		if (in_array($id_grupo, array_column($gruposNoBanco, 'id_grupo'))) {

			$response = array(
				'success' => false,
				'message' => 'Este Grupo já está cadastrado para o cliente.'
			);

		} else {

			$dados['id_grupo'] = $id_grupo;
			$inseridoId = $this->GrupoCliente_model->insereGrupoCliente($dados);

			if ($inseridoId) {

				$novoGrupo = '
                <span class="badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 etiqueta-' . $inseridoId . '">
                    <span class="badge-label">
                        ' . $nomeGrupo . '
                        <a href="#">
                            <i class="fas fa-times-circle delete-icon" onclick="deletaGrupoCliente(' . $inseridoId . ')"></i>
                        </a>
                    </span>
                </span>';

				$response = array(
					'success' => true,
					'message' => $novoGrupo
				);

			} else {
				$response = array(
					'success' => false,
					'message' => 'Falha ao cadastrar o grupo.'
				);
			}
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaGrupoCliente()
	{
		$id = $this->input->post('id');

		$this->GrupoCliente_model->deletaGrupoCliente($id);
	}

	// exibe os grupos de cada cliente dentro do modal
	public function recebeGrupoCliente()
	{
		$id_cliente = $this->input->post('id_cliente');

		$grupos = $this->GrupoCliente_model->recebeGrupoCliente($id_cliente);

		foreach ($grupos as $v) {
			echo '
			<span class="fw-bold lh-2 mr-5 badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 grupo-' . $v['id'] . '"> 
				' . $v['nome'] . '
				<a href="#">
					<i class="fas fa-times-circle delete-icon" onclick="deletaGrupoCliente(' . $v['id'] . ')"></i>
				</a>
			</span>';
		}
	}

	public function recebeGruposClientes ()
	{
		$id_grupo = $this->input->post('id_grupo');

		$clientesGrupo = $this->EtiquetaCliente_model->recebeGruposClientes($id_grupo);

		$response = array(
			'success' => true,
			'clientesGrupos' => $clientesGrupo
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));

	}
}

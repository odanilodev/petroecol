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
		$dados['id_empresa'] = $this->session->userdata('id_esmpresa');

		$nomeResiduo = $this->input->post('nome_residuo');
		$id_residuo = $this->input->post('id_residuo');
		$editar = $this->input->post('editarResiduo');

		$dados['id_residuo'] = $id_residuo;
		$dados['id_forma_pagamento'] = $this->input->post('forma_pagamento');
		$dados['valor_forma_pagamento'] = $this->input->post('valor_pagamento');

		// todos resíduos do cliente
		$residuosNoBanco = $this->ResiduoCliente_model->recebeResiduoCliente($dados['id_cliente']);

		// verifica se o resíduo já existe para esse cliente
		if (in_array($id_residuo, array_column($residuosNoBanco, 'id_residuo'))) {

			if ($editar == 'editando') {

				if($this->ResiduoCliente_model->editaResiduoCliente($id_residuo, $dados['id_cliente'], $dados)){

					$response = array(
						'success' => true,
						'id_residuo' => $id_residuo,
						'message' => 'Resíduo registrado com sucesso',
						'nome_residuo' => $nomeResiduo,
						'forma_pagamento' => $dados['id_forma_pagamento'],
						'valor_pagamento' => $dados['valor_forma_pagamento'],
						'editado' => true
					);
					
				}

			} else {
				$response = array(
					'success' => false,
					'message' => 'Este resíduo já está cadastrado para o cliente.'
				);
			}

		} else {

			$inseridoId = $this->ResiduoCliente_model->insereResiduoCliente($dados);

			if ($inseridoId) {

				$novoResiduo = '
                <span class="badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 residuo-' . $inseridoId . '">
                    <span class="badge-label">
                        ' . $nomeResiduo . '
                        <a href="#">
                            <i class="fas fa-times-circle delete-icon" onclick="deletaResiduoCliente(' . $inseridoId . ')"></i>
                        </a>
						<a href="#" class="btn-ver-residuo" title="Editar Resíduo">
                            <i class="fas fa-pencil-alt edita-residuo edita-residuo-' . $id_residuo . '" onclick="verResiduoCliente(\'' . $nomeResiduo . '\', \'' . $dados['id_forma_pagamento'] . '\', \'' . $dados['valor_forma_pagamento'] . '\')"></i>
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
				<a href="#" class="btn-deleta-recipiente">
					<i class="fas fa-times-circle delete-icon" onclick="deletaResiduoCliente(' . $v['id'] . ')"></i>
				</a>
				<a href="#" class="btn-ver-residuo" title="Editar Resíduo">
					<i class="fas fa-pencil-alt edita-residuo edita-residuo-' . $v['id_residuo'] . '" onclick="verResiduoCliente(\'' . $v['nome'] . '\', \'' . $v['id_forma_pagamento'] . '\', \'' . $v['valor_forma_pagamento'] . '\')"></i>
				</a>
			</span>';
		}
	}
}

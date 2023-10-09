<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ResiduoCliente extends CI_Controller
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

		$this->load->model('ResiduoCliente_model');
	}

	public function cadastraResiduoCliente()
	{
		$dados['id_cliente'] = $this->input->post('id_cliente');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$nomeResiduo = $this->input->post('nome_residuo');

		$id_residuo = $this->input->post('id_residuo');

		$residuosRepetidos = []; // Array para rastrear as residuos já cadastradas
		$residuosInseridos = []; // Array para rastrear as residuos que foram inseridas

		$c = 0;
		foreach ($id_residuo as $v) {

			$dados['id_residuo'] = $v;

			$residuo = $this->ResiduoCliente_model->recebeIdResiduoCliente($dados['id_residuo'], $dados['id_cliente']); // verifica se o residuo já está vinculada ao cliente

			if ($residuo) {

				// Se a residuo já está vinculada, adicione-a ao array de residuos cadastradas
				$residuosRepetidos[] = $residuo['nome'];

			} else {

				$inseridoId = $this->ResiduoCliente_model->insereResiduoCliente($dados);

				if ($inseridoId) {

					// Exibe o residuo no front com o ID
					$novoResiduo = '
					<span class="badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 residuo-' . $inseridoId . '">
						<span class="badge-label">
							' . $nomeResiduo[$c] . '
							<a href="#">
								<i class="fas fa-times-circle delete-icon" onclick="deletaResiduoCliente(' . $inseridoId . ')"></i>
							</a>
						</span>
					</span>';

					$residuosInseridos[] = $novoResiduo;
				}
			}

			$c++;
		}

		// Crie uma string com os redisuos inseridas
		$residuosInseridosString = implode('', $residuosInseridos);

		if (!empty($residuosRepetidos)) {

			// Se houver residuos cadastradas, retorne um aviso com os redisuos que já estão cadastradas
			$response = array(
				'success' => false,
				'residuo' => $residuosInseridosString,
				'message' => 'Os seguintes resíduos já estão cadastradas: ' . implode(', ', $residuosRepetidos),
			);
		} else {
			// Se não houver residuos cadastradas, retorne os redisuos inseridas
			$response = array(
				'success' => true,
				'message' => $residuosInseridosString 
			);
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

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SetoresEmpresaCliente extends CI_Controller
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

		$this->load->model('SetoresEmpresaCliente_model');
	}

	public function cadastraSetorEmpresaCliente()
	{
		$dados['id_cliente'] = $this->input->post('id_cliente');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$nomeSetorEmpresa = $this->input->post('nomeSetorEmpresa');
		$idFrequenciaColetaSetorEmpresa = $this->input->post('idFrequenciaColeta');
		$idSetorEmpresa = $this->input->post('idSetorEmpresa');
		$dados['dia_coleta_fixo'] = $this->input->post('diaFixoSemana');

		$dados['id_setor_empresa'] = $idSetorEmpresa;
		$dados['id_frequencia_coleta'] = $idFrequenciaColetaSetorEmpresa;

		// todas setores do cliente
		$setoresEmpresaNoBanco = $this->SetoresEmpresaCliente_model->recebeSetoresEmpresaCliente($dados['id_cliente']);

		// verifica se o setor já existe para esse cliente
		if (in_array($idSetorEmpresa, array_column($setoresEmpresaNoBanco, 'id_setor_empresa'))) {

			$response = array(
				'success' => false,
				'message' => 'Este setor empresa já está cadastrado para o cliente.'
			);
		} else {

			$inseridoId = $this->SetoresEmpresaCliente_model->insereSetorEmpresaCliente($dados);

			if ($inseridoId) {

				$novoSetorEmpresa = '
                <span class="badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 setor-empresa-' . $inseridoId . '">
                    <span class="badge-label">
                        ' . $nomeSetorEmpresa . '
                        <a href="#">
                            <i class="fas fa-times-circle delete-icon" onclick="deletaSetorEmpresaCliente(' . $inseridoId . ')"></i>
                        </a>
												<a href="#" class="btn-ver-setor-empresa" title="Editar Setor Empresa">
												<i class="fas fa-pencil-alt edita-setor edita-setor-empresa-' . $inseridoId . '" onclick="verSetorEmpresaCliente(\'' . $nomeSetorEmpresa . '\', \'' . $idFrequenciaColetaSetorEmpresa . '\')"></i>
											</a>
                    </span>
                </span>';

				$response = array(
					'success' => true,
					'message' => $novoSetorEmpresa
				);
			} else {
				$response = array(
					'success' => false,
					'message' => 'Falha ao cadastrar o setor de empresa.'
				);
			}
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaSetorEmpresaCliente()
	{
		$id = $this->input->post('id');

		$this->SetoresEmpresaCliente_model->deletaSetorEmpresaCliente($id);
	}

	// exibe os setores de cada cliente dentro do modal
	public function recebeSetoresEmpresaCliente()
	{
		$id_cliente = $this->input->post('idCliente');

		$setoresEmpresa = $this->SetoresEmpresaCliente_model->recebeSetoresEmpresaCliente($id_cliente);

		foreach ($setoresEmpresa as $v) {
			echo '
			<span class="fw-bold lh-2 mr-5 badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 setor-empresa-' . $v['id'] . '"> 
				' . $v['nome'] . '
				<a href="#">
					<i class="fas fa-times-circle delete-icon" onclick="deletaSetorEmpresaCliente(' . $v['id'] . ')"></i>
				</a>
				<a href="#" class="btn-ver-setor-empresa" title="Editar Setor Empresa">
				<i class="fas fa-pencil-alt edita-setor edita-setor-empresa-' . $v['id_setor_empresa'] . '" onclick="verSetorEmpresaCliente(\'' . $v['nome'] . '\', \'' . $v['id_frequencia_coleta'] . '\')"></i>
			</a>
			</span>';
		}
	}
}

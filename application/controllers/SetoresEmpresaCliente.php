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

		$editar = $this->input->post('editarSetorEmpresa');
		$nomeSetorEmpresa = $this->input->post('nomeSetorEmpresa');
		$idFrequenciaColetaSetorEmpresa = $this->input->post('idFrequenciaColeta');
		$idSetorEmpresa = $this->input->post('idSetorEmpresa');
		$transacaoColeta = $this->input->post('transacaoColeta');
		$diaPagamento = $this->input->post('diaPagamento');
		$idFormaPagamento = $this->input->post('idFormaPagamento');
		$observacaoFormaPagamento = $this->input->post('observacaoFormaPagamento');
		$diaColetaFixo = $this->input->post('diaFixoSemana');

		$dados['dia_coleta_fixo'] = $diaColetaFixo;
		$dados['transacao_coleta'] = $transacaoColeta;
		$dados['id_setor_empresa'] = $idSetorEmpresa;
		$dados['id_frequencia_coleta'] = $idFrequenciaColetaSetorEmpresa;
		$dados['dia_pagamento'] = $diaPagamento;
		$dados['id_forma_pagamento'] = $idFormaPagamento;
		$dados['observacao_pagamento'] = $observacaoFormaPagamento;


		// todos setores de empresa do cliente
		$setoresEmpresaNoBanco = $this->SetoresEmpresaCliente_model->recebeSetoresEmpresaCliente($dados['id_cliente']);


		$response = array('success' => false, 'message' => 'Este setor de empresa já está cadastrado para o cliente.');

		if (!empty($setoresEmpresaNoBanco) && in_array($idSetorEmpresa, array_column($setoresEmpresaNoBanco, 'id_setor_empresa'))) {

			if ($editar == 'editando' && $this->SetoresEmpresaCliente_model->editaSetorEmpresaCliente($idSetorEmpresa, $dados['id_cliente'], $dados)) {
				$response = array(
					'success' => true,
					'id_setor_empresa' => $idSetorEmpresa,
					'message' => 'Setor de Empresa registrado com sucesso',
					'nome_setor_empresa' => $nomeSetorEmpresa,
					'id_frequencia_coleta' => $idFrequenciaColetaSetorEmpresa,
					'dia_coleta_fixo' => $dados['dia_coleta_fixo'],
					'transacao_coleta' => $transacaoColeta,
					'dia_pagamento' => $diaPagamento,
					'id_forma_pagamento' => $idFormaPagamento,
					'observacao_pagamento' => $observacaoFormaPagamento,
					'editado' => true
				);
			}
		} else {

			$inseridoId = $this->SetoresEmpresaCliente_model->insereSetorEmpresaCliente($dados);

			if ($inseridoId) {

				$novoSetorEmpresa = '
				<span class="badge rounded-pill badge-phoenix fs--2 badge-phoenix-info my-1 mx-1 p-2 setor-empresa-' . $inseridoId . ' ">
						<span class="badge-label">
								' . $nomeSetorEmpresa . '
								<a href="#" style="margin-left:4px;">
										<i class="fas fa-times-circle delete-icon" onclick="deletaSetorEmpresaCliente(' . $inseridoId . ')"></i>
								</a>
								<a href="#" class="btn-ver-setor-empresa" title="Editar Setor" >
										<i class="fas fa-pencil-alt input-edita-setor-empresa-' . $idSetorEmpresa . '" style="margin-left:4px; margin-right:4px;" onclick="verSetorEmpresaCliente(\'' . $nomeSetorEmpresa . '\', \'' . $idFrequenciaColetaSetorEmpresa . '\', \'' . $diaColetaFixo . '\', \'' . $transacaoColeta . '\', \'' . $diaPagamento . '\', \'' . $idFormaPagamento . '\', \'' . $observacaoFormaPagamento . '\')"></i>
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
				<a href="#" style="margin-left:4px;">
					<i class="fas fa-times-circle delete-icon" onclick="deletaSetorEmpresaCliente(' . $v['id'] . ')"></i>
				</a>
				<a href="#" class="btn-ver-setor-empresa" title="Editar Setor Empresa" style="margin-left:4px; margin-right:4px;">
				<i class="fas fa-pencil-alt input-edita-setor-empresa-' . $v['id_setor_empresa'] . '"  onclick="verSetorEmpresaCliente(\'' . $v['nome'] . '\', \'' . $v['id_frequencia_coleta'] . '\', \'' . $v['dia_coleta_fixo'] . '\', \'' . $v['transacao_coleta'] . '\', \'' . $v['dia_pagamento'] . '\', \'' . $v['id_forma_pagamento'] . '\', \'' . $v['observacao_pagamento'] . '\')"></i>
			</a>
			</span>';
		}
	}

	public function recebeClientesSetor ()
	{
		$id_setor = $this->input->post('id_setor');

		if ($id_setor == "todos") {

			$this->load->model('Clientes_model');
			$this->load->model('Grupos_model');

			$clientesSetor = $this->SetoresEmpresaCliente_model->recebeClientesColeta();

			$gruposCliente = $this->Grupos_model->recebeGrupos();

		} else {
			
			$clientesSetor = $this->SetoresEmpresaCliente_model->recebeClientesSetoresEmpresaColeta($id_setor);
			$gruposCliente = $this->SetoresEmpresaCliente_model->recebeGruposClienteSetor($id_setor);

		}


		$response = array(
			'success' => true,
			'clientesSetor' => $clientesSetor,
			'gruposCliente' => $gruposCliente
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));

	}
	

	public function recebeClientesEtiquetaSetor ()
	{
		$id_setor = $this->input->post('id_setor');

		$clientesEtiquetaSetor = $this->SetoresEmpresaCliente_model->recebeClientesEtiquetaSetoresEmpresa($id_setor);

		$response = array(
			'success' => true,
			'clientesEtiquetaSetor' => $clientesEtiquetaSetor
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));

	}
}

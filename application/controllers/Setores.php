<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setores extends CI_Controller
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

		$this->load->model('Setores_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para setores
		$scriptsSetorFooter = scriptsSetorFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsSetorFooter));

		$data['setores'] = $this->Setores_model->recebeSetores();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/setores/setores');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para setores
		$scriptsSetorFooter = scriptsSetorFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsSetorFooter));

		$id = $this->uri->segment(3);

		$data['setor'] = $this->Setores_model->recebeSetor($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/setores/cadastra-setor');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraSetor()
	{
		$id = $this->input->post('id');

		$nome = $this->input->post('nome');
		$dados['nome'] = trim(mb_convert_case($nome, MB_CASE_TITLE, 'UTF-8'));
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$setor = $this->Setores_model->recebeSetorNome($dados['nome'], $id); // verifica se já existe o setor

		// Verifica se o setor já existe e se não é o setor que está sendo editada
		if ($setor) {

			$response = array(
				'title' => "Algo deu errado!",
				'type' => "error",
				'success' => false,
				'message' => "Este setor já existe! Tente cadastrar um diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->Setores_model->editaSetor($id, $dados) : $this->Setores_model->insereSetor($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Setor editado com sucesso!' : 'Setor cadastrado com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o setor!" : "Erro ao cadastrar o setor!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaSetor()
	{
		$this->load->model('Usuarios_model');

		$ids = $this->input->post('ids');

		$vinculados = [];
		$naoVinculados = [];

		foreach ($ids as $id) {
			$retorno = $this->Usuarios_model->verificaSetorUsuario($id);

			if ($retorno) {
				$vinculados[] = $id;
			} else {
				$naoVinculados[] = $id;
			}
		}

		if (count($vinculados) == 1) {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'id_vinculado' => $vinculados[0],
				'message' => "Existem um ou mais usuários vinculados a este setor. Não é possível excluí-lo.",
				'type' => "error",
				'redirect' => false
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		if (!empty($naoVinculados)) {
			$retornoSetorDeletado = $this->Setores_model->deletaSetor($naoVinculados);

			if ($retornoSetorDeletado) {
				$message = "Setor(es) deletado(s) com sucesso!";
				$type = "success";

				if (!empty($vinculados)) {
					$nomesSetores = $this->Usuarios_model->verificaSetorUsuario($vinculados);

					$nomeSetor = '';

					for ($i = 0; $i < count($nomesSetores); $i++) {

						$nomeSetor .= $nomesSetores[$i]['NOMES_SETORES'];

						if ($i < count($nomesSetores) - 1) {
							$nomeSetor .= ', ';
						}
					}

					$message = "Os seguintes setores não foram deletadas pois estão vinculados a usuários: " . $nomeSetor;
					$type = "warning";
				}


				$response = array(
					'success' => true,
					'title' => "Atenção!",
					'message' => $message,
					'type' => $type,
					'redirect' => false
				);
			}

		} else {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possível deletar as etiquetas pois existem Clientes vinculados a elas!",
				'type' => "error",
				'redirect' => false
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

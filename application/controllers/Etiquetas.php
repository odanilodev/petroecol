<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Etiquetas extends CI_Controller
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

		$this->load->model('Etiquetas_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para etiquetas
		$scriptsEtiquetaFooter = scriptsEtiquetaFooter();
		$scriptsEtiquetaHead = scriptsEtiquetaHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsEtiquetaHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsEtiquetaFooter));


		$data['etiquetas'] = $this->Etiquetas_model->recebeEtiquetas();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/etiquetas/etiquetas');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para etiquetas!
		$scriptsEtiquetaFooter = scriptsEtiquetaFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsEtiquetaFooter));

		$this->load->model('Empresas_model');

		$id = $this->uri->segment(3);

		$data['etiqueta'] = $this->Etiquetas_model->recebeEtiqueta($id);
		$data['empresas'] = $this->Empresas_model->recebeEmpresas();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/etiquetas/cadastra-etiqueta');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraEtiqueta()
	{
		$id = $this->input->post('id');
		$nome = $this->input->post('nome');
		$dados['nome'] = mb_convert_case(trim($nome), MB_CASE_TITLE, 'UTF-8');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$etiqueta = $this->Etiquetas_model->recebeEtiquetaNome($dados['nome'], $id); // verifica se já existe a etiqueta

		// Verifica se a etiqueta já existe e se não é a etiqueta que está sendo editada!
		if ($etiqueta) {

			$response = array(
				'title' => "Algo deu errado!",
				'type' => "error",
				'success' => false,
				'message' => "Esta etiqueta já existe! Tente cadastrar uma diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}


		$retorno = $id ? $this->Etiquetas_model->editaEtiqueta($id, $dados) : $this->Etiquetas_model->insereEtiqueta($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Etiqueta editada com sucesso!' : 'Etiqueta cadastrada com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar etiqueta!" : "Erro ao cadastrar etiqueta!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaEtiqueta()
	{
		$this->load->model('EtiquetaCliente_model');

		$ids = $this->input->post('ids');

		$vinculadas = [];
		$naoVinculadas = [];

		foreach ($ids as $id) {
			$retorno = $this->EtiquetaCliente_model->verificaEtiquetaCliente($id);

			if ($retorno) {
				$vinculadas[] = $id;
			} else {
				$naoVinculadas[] = $id;
			}
		}

		if (count($vinculadas) == 1) {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'id_vinculado' => $vinculadas[0],
				'message' => "Existem um ou mais clientes vinculados a esta etiqueta. Não é possível excluí-la.",
				'type' => "error",
				'redirect' => true
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		if (!empty($naoVinculadas)) {
			$retornoEtiquetaDeletada = $this->Etiquetas_model->deletaEtiqueta($naoVinculadas);

			if ($retornoEtiquetaDeletada) {
				$message = "Etiqueta(s) deletada(s) com sucesso!";
				$type = "success";

				if (!empty($vinculadas)) {
					$nomesEtiquetas = $this->EtiquetaCliente_model->verificaEtiquetaCliente($vinculadas);

					$nomeEtiqueta = '';

					for ($i = 0; $i < count($nomesEtiquetas); $i++) {

						$nomeEtiqueta .= $nomesEtiquetas[$i]['nomes_etiquetas'];

						if ($i < count($nomesEtiquetas) - 1) {
							$nomeEtiqueta .= ', ';
						}
					}

					$message = "As seguintes etiquetas não foram deletadas pois estão vinculadas a clientes: " . $nomeEtiqueta;
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

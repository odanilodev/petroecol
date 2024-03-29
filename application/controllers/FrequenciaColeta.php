<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FrequenciaColeta extends CI_Controller
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

		$this->load->model('FrequenciaColeta_model');
	}
	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para frequencia de coleta
		$scriptsFrequenciaColetaFooter = scriptsFrequenciaColetaFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFrequenciaColetaFooter));

		$data['frequencia'] = $this->FrequenciaColeta_model->recebeFrequenciasColeta();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/frequencia-coleta/frequencia');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para frequencia de coleta
		$scriptsFrequenciaColetaFooter = scriptsFrequenciaColetaFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFrequenciaColetaFooter));

		$id = $this->uri->segment(3);

		$data['frequencia'] = $this->FrequenciaColeta_model->recebeFrequenciaColeta($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/frequencia-coleta/cadastra-frequencia');
		$this->load->view('admin/includes/painel/rodape');
	}
	public function cadastraFrequenciaColeta()
	{
		$id = $this->input->post('id');
		$frequencia = $this->input->post('frequenciaColeta');

		$dados['dia'] = trim($this->input->post('diaColeta'));
		$dados['frequencia'] = mb_convert_case(trim($frequencia), MB_CASE_TITLE, 'UTF-8');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$frequencia = $this->FrequenciaColeta_model->recebeFrequenciaColetaNome($dados['frequencia'], $dados['dia'], $id); // verifica se já existe a frenquencia

		// Verifica se a frequencia ja existe e se não é a frequencia que está sendo editada
		if ($frequencia) {

			$response = array(
				'title' => "Algo deu errado!",
				'type' => "error",
				'success' => false,
				'message' => "Esta frequencia já existe! Tente cadastrar uma diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->FrequenciaColeta_model->editaFrequenciaColeta($id, $dados) : $this->FrequenciaColeta_model->insereFrequenciaColeta($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'title' => "Sucesso!",
				'type' => "success",
				'success' => true,
				'message' => $id ? 'Frequência editada com sucesso!' : 'Frequência cadastrada com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'title' => "Algo deu errado!",
				'type' => "error",
				'success' => false,
				'message' => $id ? "Erro ao editar a frequência!" : "Erro ao cadastrar a frequência!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletaFrequenciaColeta()
	{
		$id = $this->input->post('id');

		// Verifica se a frequência esta vinculada a um cliente
		$frequenciaVinculadaCliente = $this->FrequenciaColeta_model->verificaFrequenciaColetaCliente($id);

		if ($frequenciaVinculadaCliente) {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Esta frequência está vinculada a um cliente, não é possível excluí-la.",
				'type' => "error"
			);
		} else {

			$retorno = $this->FrequenciaColeta_model->deletaFrequenciaColeta($id);

			if ($retorno) {

				$response = array(
					'success' => true,
					'title' => "Sucesso!",
					'message' => "Frequência deletada com sucesso!",
					'type' => "success"
				);

			} else {
				
				$response = array(
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Não foi possível deletar esta frequência de coleta.",
					'type' => "error"
				);

			}
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

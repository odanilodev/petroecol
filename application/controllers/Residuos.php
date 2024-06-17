<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Residuos extends CI_Controller
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

		$this->load->model('Residuos_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para residuos
		$scriptsResiduoFooter = scriptsResiduoFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsResiduoFooter));

		$data['residuos'] = $this->Residuos_model->recebeResiduos();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/residuos/residuos');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para residuos
		$scriptsResiduoFooter = scriptsResiduoFooter();
		$scriptsResiduoHead = scriptsResiduoHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsResiduoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsResiduoFooter));

		$id = $this->uri->segment(3);

		$data['residuo'] = $this->Residuos_model->recebeResiduo($id);
		$data['grupo_residuos'] = $this->Residuos_model->recebeGruposResiduo();

		// Setores Empresa 
		$this->load->model('SetoresEmpresa_model');
		$data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

		$this->load->model('SetoresEmpresaCliente_model');
		$data['setoresEmpresaCliente'] = $this->SetoresEmpresaCliente_model->recebeSetoresEmpresaClientes();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/residuos/cadastra-residuos');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraResiduo()
	{
		$id = $this->input->post('id');

		$nome = $this->input->post('residuo');
		$dados['nome'] = mb_convert_case(trim($nome), MB_CASE_TITLE, 'UTF-8');
		$dados['id_grupo'] = $this->input->post('grupo');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');
		$dados['unidade_medida'] = $this->input->post('unidade');
		$dados['id_setor_empresa'] = $this->input->post('idSetor');

		$residuo = $this->Residuos_model->recebeResiduoNome($dados['nome'], $id); // verifica se já existe o residuo

		// Verifica se o residuo já existe e se não é o residuo que está sendo editada
		if ($residuo) {

			$response = array(
				'title' => "Algo deu errado!",
				'type' => "error",
				'success' => false,
				'message' => "Este residuo já existe! Tente cadastrar um diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->Residuos_model->editaResiduo($id, $dados) : $this->Residuos_model->insereResiduo($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Resíduo editado com sucesso!' : 'Resíduo cadastrado com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o Resíduo!" : "Erro ao cadastrar o Resíduo!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaResiduo()
	{
		$id = $this->input->post('id');

		// Verifica se o residuo esta vinculado a um cliente
		$residuoVinculadoCliente = $this->Residuos_model->verificaResiduoCliente($id);

		if ($residuoVinculadoCliente) {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'id_vinculado' => $id,
				'message' => "Este residuo está vinculado a um cliente, não é possível excluí-lo.",
				'type' => "error"
			);
		} else {

			$retorno = $this->Residuos_model->deletaResiduo($id);

			if ($retorno) {
				$response = array(
					'success' => true,
					'title' => "Sucesso!",
					'message' => "Resíduo deletado com sucesso!",
					'type' => "success"
				);
			} else {

				$response = array(
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Não foi possivel deletar o resíduo!",
					'type' => "error"
				);
			}
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function recebeResiduosSetor()
	{

	 $idSetor = $this->input->post('idSetor');

	 $retorno = $this->Residuos_model->recebeResiduoSetor($idSetor);

	 if ($retorno) {
		$response = array(
			'success' => true,
			'residuos' => $retorno
		);
	} else {

		$response = array(
			'success' => false,
			'residuos' => []
		);
	}
	 
	 
	 return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

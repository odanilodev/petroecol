<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Certificados extends CI_Controller
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

		$this->load->model('Certificados_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para Certificados
		$scriptsCertificadosFooter = scriptsCertificadosFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsCertificadosFooter));

		$data['certificados'] = $this->Certificados_model->recebeCertificados();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/certificados/certificados');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para Certificados
		$scriptsCertificadosFooter = scriptsCertificadosFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsCertificadosFooter));

		$id = $this->uri->segment(3);

		$data['certificado'] = $this->Certificados_model->recebeCertificadoId($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/certificados/cadastra-certificado');
		$this->load->view('admin/includes/painel/rodape');
	}
	public function cadastraCertificado()
	{
		$id = $this->input->post('id') ?? null;
		$modelo = $this->input->post('modeloCertificado');
		
		$dados['modelo'] = mb_convert_case($modelo, MB_CASE_TITLE, 'UTF-8');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$certificado_modelo = $this->Certificados_model->recebeCertificadoModelo($dados['modelo'], $id); // verifica se já existe o certificado

		// Verifica se o certificado já existe e se não é o certificado que está sendo editada
		if ($certificado_modelo) {

			$response = array(
				'success' => false,
				'message' => "Este modelo de certificado já existe! Tente cadastrar um diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->Certificados_model->editaCertificado($id, $dados) : $this->Certificados_model->insereCertificado($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Certificado editado com sucesso!' : 'Certificado cadastrado com sucesso!'
			);

		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o certificado!" : "Erro ao cadastrar o certificado!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletaCertificado()
	{
		$id = $this->input->post('id');

		$this->Certificados_model->deletaCertificado($id);

		$response = array(
			'success' => true,
			'title' => "Sucesso!",
			'message' => "Certificado deletado com sucesso!",
			'type' => "success"
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

}
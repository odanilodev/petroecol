<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Etiquetas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// INICIO controle sessão
        $this->load->library('Controle_sessao');
        $res = $this->controle_sessao->controle();
        if($res == 'erro'){ redirect('login/erro', 'refresh');}
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

		add_scripts('header', array_merge($scriptsPadraoHead));
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

		// scripts para etiquetas
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

		$dados['nome'] = $this->input->post('nome');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

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
		$id = $this->input->post('id');

		$this->Etiquetas_model->deletaEtiqueta($id);

		redirect('etiquetas');
	}
}
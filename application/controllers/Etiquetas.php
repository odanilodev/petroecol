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
	}

	public function index()
	{
		$scriptsHead = scriptsUsuarioHead();
		add_scripts('header', $scriptsHead);

		$scriptsFooter = scriptsUsuarioFooter();
		add_scripts('footer', $scriptsFooter);

		$data['etiquetas'] = $this->Etiquetas_model->recebeEtiquetas();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/etiquetas/etiquetas');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		$scriptsHead = scriptsUsuarioHead();
		add_scripts('header', $scriptsHead);

		$scriptsFooter = scriptsUsuarioFooter();
		add_scripts('footer', $scriptsFooter);

		$this->load->model('Etiquetas_model');

		$id = $this->uri->segment(3);

		$data['etiqueta'] = $this->Etiquetas_model->recebeEtiqueta($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/etiquetas/cadastra-etiqueta');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraEtiqueta()
	{
		$id = $this->input->post('id');

		$dados['nome'] = $this->input->post('nome');

		$retorno = $id ? $this->Etiquetas_model->editaEtiqueta($id, $dados) : $this->Etiquetas_model->insereEtiqueta($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Etiqueta editado com sucesso!' : 'Etiqueta cadastrado com sucesso!'
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

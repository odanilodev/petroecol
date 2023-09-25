<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setores extends CI_Controller
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

		$data['setores'] = $this->Setores_model->recebeSetores();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/setores/setores');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		$scriptsHead = scriptsUsuarioHead();
		add_scripts('header', $scriptsHead);

		$scriptsFooter = scriptsUsuarioFooter();
		add_scripts('footer', $scriptsFooter);

		$this->load->model('Setores_model');

		$id = $this->uri->segment(3);

		$data['setor'] = $this->Setores_model->recebeSetor($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/setores/cadastra-setor');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraSetor()
	{
		$id = $this->input->post('id');

		$dados['nome'] = $this->input->post('nome');

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
		$id = $this->input->post('id');

		$this->Setores_model->deletaSetor($id);

		redirect('setores');
	}
}

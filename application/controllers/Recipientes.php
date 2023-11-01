<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recipientes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// INICIO controle sessão
        $this->load->library('Controle_sessao');
        $res = $this->controle_sessao->controle();
        if($res == 'erro'){ redirect('login/erro', 'refresh');}
        // FIM controle sessão

		$this->load->model('recipientes_model');

	}

	public function index($page = 1)
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para setores
		$scriptsRecipienteFooter = scriptsRecipienteFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsRecipienteFooter));

		// >>>> PAGINAÇÃO <<<<<
        $limit = 12; // Número de recipientes por página
        $this->load->library('pagination');
        $config['base_url'] = base_url('recipientes/index');
        $config['total_rows'] = $this->recipientes_model->recebeRecipientes($limit, $page, true); // true para contar
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
        $this->pagination->initialize($config);
        // >>>> FIM PAGINAÇÃO <<<<<

		$data['recipientes'] = $this->recipientes_model->recebeRecipientes($limit, $page);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/recipientes/recipientes');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para setores
		$scriptsRecipienteFooter = scriptsRecipienteFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsRecipienteFooter));

		$id = $this->uri->segment(3);

		$data['recipiente'] = $this->recipientes_model->recebeRecipiente($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/recipientes/cadastra-recipiente');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraRecipiente()
	{
		$id = $this->input->post('id');

		$nome = $this->input->post('nome_recipiente');
		$dados['nome_recipiente'] = mb_convert_case($nome, MB_CASE_TITLE, 'UTF-8');
		$dados['quantidade'] = $this->input->post('quantidade');
		$dados['volume_suportado'] = $this->input->post('volume_suportado');
		$dados['unidade_peso'] = $this->input->post('unidade_peso');

		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$recipiente = $this->recipientes_model->recebeRecipienteNome($dados['nome_recipiente'], $dados['volume_suportado'], $dados['unidade_peso']); // verifica se já existe o recipiente

		// Verifica se o recipiente já existe e se não é o recipiente que está sendo editada
		if ($recipiente && $recipiente['id'] != $id) {

			$response = array(
				'success' => false,
				'message' => "Este recipiente já existe! Tente cadastrar um diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->recipientes_model->editaRecipiente($id, $dados) : $this->recipientes_model->insereRecipiente($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Recipiente editado com sucesso!' : 'Recipiente cadastrado com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o Recipiente!" : "Erro ao cadastrar o Recipiente!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaRecipiente()
	{
		$id = $this->input->post('id');

		$this->recipientes_model->deletaRecipiente($id);

		redirect('recipientes');
	}
}

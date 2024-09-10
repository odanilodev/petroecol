<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trajetos extends CI_Controller
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

		$this->load->model('Trajetos_model');
	}

	public function index($page = 1)
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para trajetos
		$scriptsTrajetoFooter = scriptsTrajetoFooter();
		$scriptsTrajetoHead = scriptsTrajetoHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsTrajetoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsTrajetoFooter));

		$this->load->helper('cookie');

        if ($this->input->post()) {
            $this->input->set_cookie('filtro_trajetos', json_encode($this->input->post()), 3600);
        }

        if (is_numeric($page)) {
            $cookie_filtro_trajetos = count($this->input->post()) > 0 ? json_encode($this->input->post()) : $this->input->cookie('filtro_trajetos');
        } else {
            $page = 1;
            delete_cookie('filtro_trajetos');
            $cookie_filtro_trajetos = json_encode([]);
        }

        $data['cookie_filtro_trajetos'] = json_decode($cookie_filtro_trajetos, true);

        // >>>> PAGINAÇÃO <<<<<
        $limit = 12; // Número de trajetos por página
        $this->load->library('pagination');
        $config['base_url'] = base_url('trajetos/index');
        $config['total_rows'] = $this->Trajetos_model->recebeTrajetos($cookie_filtro_trajetos, $limit, $page, true); // true para contar
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
        $this->pagination->initialize($config);
        // >>>> FIM PAGINAÇÃO <<<<<


		$data['trajetos'] = $this->Trajetos_model->recebeTrajetos($cookie_filtro_trajetos, $limit, $page);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/trajetos/trajetos');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para trajetos
		$scriptsTrajetoFooter = scriptsTrajetoFooter();
		$scriptsTrajetoHead = scriptsTrajetoHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsTrajetoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsTrajetoFooter));

		$this->load->model('Empresas_model');

		$id = $this->uri->segment(3);

		$data['trajeto'] = $this->Trajetos_model->recebeTrajeto($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/trajetos/cadastra-trajeto');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraTrajeto()
	{
		$id = $this->input->post('id');
		$nome = $this->input->post('nome');
		$dados['nome'] = mb_convert_case(trim($nome), MB_CASE_TITLE, 'UTF-8');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$trajeto = $this->Trajetos_model->recebeTrajetoNome($dados['nome'], $id); // verifica se já existe a trajeto

		// Verifica se o trajeto já existe e se não é a trajeto que está sendo editada!
		if ($trajeto) {

			$response = array(
				'title' => "Algo deu errado!",
				'type' => "error",
				'success' => false,
				'message' => "Este trajeto já existe! Tente cadastrar uma diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}


		$retorno = $id ? $this->Trajetos_model->editaTrajeto($id, $dados) : $this->Trajetos_model->insereTrajeto($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Trajeto editado com sucesso!' : 'Trajeto cadastradp com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o trajeto!" : "Erro ao cadastrar o trajeto!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaTrajeto()
	{
		$id = $this->input->post('id');

		$retorno = $this->Trajetos_model->deletaTrajeto($id);

		if ($retorno) {
		
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Trajeto deletado com sucesso!",
				'type' => "success"
			);
		} else {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possível deletar o Trajeto!",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permissao extends CI_Controller
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
		$this->load->model('Permissao_model');
		date_default_timezone_set('America/Sao_Paulo');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		add_scripts('header', $scriptsPadraoHead);
		add_scripts('footer', $scriptsPadraoFooter);

		$data['componentes'] = $this->Permissao_model->recebeComponetes();


		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/permissoes/componentes');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function permissaoComponentes()
	{
		$id = $this->uri->segment(3);

		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		$scriptsPermissaoFooter = scriptsPermissaoFooter();

		add_scripts('header', $scriptsPadraoHead);
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsPermissaoFooter));

		$this->load->model('Usuarios_model');

		$data['usuarios'] = $this->Usuarios_model->recebeTodosUsuarios();
		$componente = $this->Permissao_model->recebeComponente($id);
		$data['id_usuarios'] = [];

		if ($componente) {
			$id_usuário = json_decode($componente['usuarios'], true);
			$data['id_usuarios'] = $id_usuário ?? [];
		}

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/permissoes/permissao-componetes');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function atualizaPermissoes()
	{
		$id_componente = $this->input->post('id_componente');
		$permissoes = $this->input->post('permissoes');

		$dados['usuarios'] = json_encode($permissoes);

		$retorno = $this->Permissao_model->editaComponente($id_componente, $dados);

		if ($retorno) { // editou
			$response = array(
				'success' => true,
				'message' => "Permissão editada com sucesso!"
			);
		} else { // erro ao editar

			$response = array(
				'success' => false,
				'message' => "Erro ao editar a permissão do usuario!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

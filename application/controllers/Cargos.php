<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Cargos extends CI_Controller
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
			$this->load->model('Cargos_model');
		}

		public function index()
		{
			// scripts padrão
			$scriptsPadraoHead = scriptsPadraoHead();
			$scriptsPadraoFooter = scriptsPadraoFooter();

			// scripts para Cargos
			$scriptsCargosFooter = scriptsCargosFooter();

			add_scripts('header', array_merge($scriptsPadraoHead));
			add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsCargosFooter));

			$data['cargos'] = $this->Cargos_model->recebeCargos();

			$this->load->view('admin/includes/painel/cabecalho', $data);
			$this->load->view('admin/paginas/cargos/cargos');
			$this->load->view('admin/includes/painel/rodape');
		}

		public function formulario()
		{
			// scripts padrão
			$scriptsPadraoHead = scriptsPadraoHead();
			$scriptsPadraoFooter = scriptsPadraoFooter();

			// scripts para cargos
			$scriptsCargosFooter = scriptsCargosFooter();

			add_scripts('header', array_merge($scriptsPadraoHead));
			add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsCargosFooter));

			$id = $this->uri->segment(3);

			$data['cargo'] = $this->Cargos_model->recebeCargo($id);

			$this->load->view('admin/includes/painel/cabecalho', $data);
			$this->load->view('admin/paginas/cargos/cadastra-cargos');
			$this->load->view('admin/includes/painel/rodape');
		}

		public function cadastraCargos()
		{
			$id = $this->input->post('id');

			$dados['nome'] = trim(mb_convert_case($this->input->post('nome'), MB_CASE_TITLE, 'UTF-8'));
			$dados['id_empresa'] = $this->session->userdata('id_empresa');
			$dados['responsavel_agendamento'] = $this->input->post('responsavelAgendamento');

			$cargo = $this->Cargos_model->recebeCargoNome($dados['nome']); // verifica se já existe o cargo

			// Verifica se o cargo já existe e se não é o cargo que está sendo editada
			if ($cargo && $cargo['id'] != $id) {

				$response = array(
					'success' => false,
					'message' => "Este cargo já existe! Tente cadastrar um diferente."
				);

				return $this->output->set_content_type('application/json')->set_output(json_encode($response));
			}

			$retorno = $id ? $this->Cargos_model->editaCargo($id, $dados) : $this->Cargos_model->insereCargo($dados); // se tiver ID edita se não INSERE

			if ($retorno) { // inseriu ou editou

				$response = array(
					'success' => true,
					'message' => $id ? 'Cargo editado com sucesso!' : 'Cargo cadastrado com sucesso!'
				);
			} else { // erro ao inserir ou editar

				$response = array(
					'success' => false,
					'message' => $id ? "Erro ao editar o cargo!" : "Erro ao cadastrar o cargo!"
				);
			}

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}


		public function deletaCargos()
		{
			$this->load->model('Funcionarios_model');

			$id = $this->input->post('id');

		// Verifica se o Cargo esta vinculada a um funcionario
		$cargoVinculadoFuncionario = $this->Funcionarios_model->verificaCargoFuncionario($id);

		if ($cargoVinculadoFuncionario) {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Este cargo está vinculado a um funcionário, não é possível excluí-lo.",
				'type' => "error"
			);

		} else {

			$retorno = $this->Cargos_model->deletaCargo($id);
	
			if ($retorno) {

				$response = array(
					'success' => true,
					'title' => "Sucesso!",
					'message' => "Cargo deletado com sucesso!",
					'type' => "success"
				);

			} else {
						
				$response = array(
					'success' => false,
					'title' => "Algo deu errado!",
					'message' => "Não foi possivel deletar o cargo!",
					'type' => "error"
				);
			}
		}
		
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));

	}
}
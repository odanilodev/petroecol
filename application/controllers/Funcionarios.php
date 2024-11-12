<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Funcionarios extends CI_Controller
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

		$this->load->model('Funcionarios_model');
		date_default_timezone_set('America/Sao_Paulo');
	}

	private function formatarInformacaoData($dataString)
	{
		if ($dataString && $dataString != '0000-00-00') {
			$dataTimestamp = strtotime($dataString);
			$dataAtual = strtotime(date('Y-m-d'));

			$texto = date('d/m/Y', $dataTimestamp);

			if ($dataTimestamp < $dataAtual) {
				$texto = $texto . ' (Vencido)';
			}
		} else {
			$texto = 'Não cadastrado';
		}

		return $texto;
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para Funcionarios
		$scriptsFuncionarioHead = scriptsFuncionarioHead();
		$scriptsFuncionarioFooter = scriptsFuncionarioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsFuncionarioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFuncionarioFooter));

		$data['funcionarios'] = $this->Funcionarios_model->recebeFuncionarios();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/funcionarios/funcionarios');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function detalhes()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para Funcionarios
		$scriptsFuncionarioHead = scriptsFuncionarioHead();
		$scriptsFuncionarioFooter = scriptsFuncionarioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsFuncionarioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFuncionarioFooter));

		$id = $this->uri->segment(3);
		
		if ($this->uri->segment(4) == '0') {
			$data['funcionario'] = $this->Funcionarios_model->recebeFuncionario($id, 1);
		} else {
			$data['funcionario'] = $this->Funcionarios_model->recebeFuncionario($id);
		}

		$data['documentos'] = ['cnh', 'cpf', 'aso', 'epi', 'registro', 'carteira', 'vacinacao', 'certificados', 'ordem'];

		$data['info_cnh'] = $this->formatarInformacaoData($data['funcionario']['data_cnh']);

		$data['info_aso'] = $this->formatarInformacaoData($data['funcionario']['data_aso']);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/funcionarios/ver_funcionario');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function inativados()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para Funcionarios
		$scriptsFuncionarioHead = scriptsFuncionarioHead();
		$scriptsFuncionarioFooter = scriptsFuncionarioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsFuncionarioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFuncionarioFooter));

		$data['funcionariosInativados'] = $this->Funcionarios_model->recebeFuncionariosInativados();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/funcionarios/funcionarios-inativos');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para funcionarios
		$scriptsFuncionarioHead = scriptsFuncionarioHead();
		$scriptsFuncionarioFooter = scriptsFuncionarioFooter();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsFuncionarioHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFuncionarioFooter));

		$this->load->model('Empresas_model');
		$this->load->model('Cargos_model');


		$id = $this->uri->segment(3);

		$data['funcionario'] = $this->Funcionarios_model->recebeFuncionario($id);

		$data['empresas'] = $this->Empresas_model->recebeEmpresas();

		$data['cargos'] = $this->Cargos_model->recebeCargos();


		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/funcionarios/cadastra-funcionarios');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraFuncionario()
	{

		$this->load->library('upload_imagem');
		$this->load->helper('validacao_helper');

		$id = $this->input->post('id');

		$status = $this->input->post('status');

		if ($status !== null && $id) {
			$retorno = $this->Funcionarios_model->editaFuncionario($id, ['status' => $status]);
			$response = $retorno
				? [
					'success' => true,
					'title' => "Sucesso!",
					'message' => "Status do funcionário atualizado com sucesso!",
					'type' => "success"
				]
				: [
					'success' => false,
					'title' => "Erro!",
					'message' => "Erro ao atualizar o status do funcionário.",
					'type' => "error"
				];

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}


		$nome = $this->input->post('nome');
		$dados['nome'] = mb_convert_case($nome, MB_CASE_TITLE, 'UTF-8');
		$dados['data_cnh'] = $this->input->post('data_cnh');
		$dados['data_aso'] = $this->input->post('data_aso');
		$dados['telefone'] = $this->input->post('telefone');
		$dados['cpf'] = $this->input->post('cpf');
		$dados['id_cargo'] = $this->input->post('id_cargo');
		$dados['data_nascimento'] = $this->input->post('data_nascimento');
		$dados['residencia'] = $this->input->post('residencia');
		$dados['salario_base'] = $this->input->post('salario_base');
		$dados['conta_bancaria'] = $this->input->post('conta_bancaria');

		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$cpfFuncionario = $this->Funcionarios_model->verificaCpfFuncionario($dados['cpf'], $id); // verifica se ja existe o cpf no banco

		if ($cpfFuncionario) {

			$response = array(
				'title' => "Algo deu errado!",
				'type' => "error",
				'success' => false,
				'message' => "Já existe um funcionário com este CPF!"
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		// Validar o CPF usando a função do helper
		if (!validarCpf($dados['cpf'])) {
			$response = array(
				'success' => false,
				'message' => 'CPF inválido. Por favor, insira um CPF válido.'
			);
			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$imagemAntiga = $this->Funcionarios_model->recebeFuncionario($id);

		$arrayUpload = [
			'foto_cnh'          => ['funcionarios/cnh', $imagemAntiga['foto_cnh'] ?? null],
			'foto_perfil'       => ['funcionarios/perfil', $imagemAntiga['foto_perfil'] ?? null],
			'foto_cpf'          => ['funcionarios/cpf', $imagemAntiga['foto_cpf'] ?? null],
			'foto_aso'          => ['funcionarios/aso', $imagemAntiga['foto_aso'] ?? null],
			'foto_epi'          => ['funcionarios/epi', $imagemAntiga['foto_epi'] ?? null],
			'foto_registro'     => ['funcionarios/registro', $imagemAntiga['foto_registro'] ?? null],
			'foto_carteira'     => ['funcionarios/carteira', $imagemAntiga['foto_carteira'] ?? null],
			'foto_vacinacao'    => ['funcionarios/vacinacao', $imagemAntiga['foto_vacinacao'] ?? null],
			'foto_certificados' => ['funcionarios/certificados', $imagemAntiga['foto_certificados'] ?? null],
			'foto_ordem'        => ['funcionarios/ordem', $imagemAntiga['foto_ordem'] ?? null]
		];

		$retornoDados = $this->upload_imagem->uploadImagem($arrayUpload);
		$dados = array_merge($dados, $retornoDados);

		$retorno = $id ? $this->Funcionarios_model->editaFuncionario($id, $dados) : $this->Funcionarios_model->insereFuncionario($dados); // se tiver ID edita, se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Funcionario editado com sucesso!' : 'Funcionario cadastrado com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar o Funcionario!" : "Erro ao cadastrar o Funcionario!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaFuncionario()
	{
		$id = $this->input->post('id');

		$retorno = $this->Funcionarios_model->deletaFuncionario($id);

		if ($retorno) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Funcionário inativado com sucesso!",
				'type' => "success"
			);
		} else {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possivel inativar o funcionário!",
				'type' => "error"
			);
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletaDocumentoFuncionario()
	{
		$id = $this->input->post('id');
		$coluna = $this->input->post('coluna');
		$coluna_array = json_decode($coluna, true);

		$funcionario = $this->Funcionarios_model->recebeFuncionario($id);
		$deletou = false;

		foreach ($coluna_array as $coluna) {

			$dados[$coluna] = null;
			$retorno = $this->Funcionarios_model->deletaDocumentoFuncionario($id, $dados);
			$pasta = explode('_', $coluna);

			if ($retorno) {
				$caminho = './uploads/' . $this->session->userdata('id_empresa') . '/' . 'funcionarios/' . $pasta[1] . '/' . $funcionario[$coluna];
				unlink($caminho);
				$deletou = true;
			}
		}

		if ($deletou) { // deletou

			$response = array(
				'success' => true,
				'message' => $coluna != 'foto_perfil' ? 'Documento(s) deletado com sucesso!' : 'Foto de perfil deletada com sucesso!',
				'caminho' => $coluna != 'foto_perfil' ? 'detalhes' : 'formulario',
				'documento' => $coluna,
				'type' => "success",
				'title' => "Sucesso!"
			);
		} else { // erro ao deletar

			$response = array(
				'success' => false,
				'message' => $coluna != 'foto_perfil' ? 'Erro ao deletar Documento(s)' : 'Erro ao deletar foto de perfil!',
				'documento' => $coluna,
				'type' => "error",
				'title' => "Algo deu errado!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	public function recebeTodosFuncionarios()
	{
		$this->load->model('Funcionarios_model');
		$funcionarios = $this->Funcionarios_model->recebeResponsavelAgendamento();

		if ($funcionarios) {

			$response = array(
				'funcionarios' => $funcionarios,
				'success' => true
			);
		} else {
			$response = array(
				'success' => false
			);
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

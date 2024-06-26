<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinDadosFinanceiros extends CI_Controller
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
		$this->load->model('FinDadosFinanceiros_model');
		$this->load->model('FinGrupos_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para Dados Financeiros
		$scriptsFinDadosFinanceirosFooter = scriptsFinDadosFinanceirosFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinDadosFinanceirosFooter));

		$data['dadosFinanceiros'] = $this->FinDadosFinanceiros_model->recebeDadosFinanceiros();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/dados-financeiros/dados-financeiros');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para Dados Financeiros
		$scriptsFinDadosFinanceirosFooter = scriptsFinDadosFinanceirosFooter();
		$scriptsFinDadosFinanceirosHead = scriptsFinDadosFinanceirosHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsFinDadosFinanceirosHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFinDadosFinanceirosFooter));

		$id = $this->uri->segment(3);

		$data['dadoFinanceiro'] = $this->FinDadosFinanceiros_model->recebeDadoFinanceiro($id);
		$data['grupos'] = $this->FinGrupos_model->recebeGrupos();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/dados-financeiros/cadastra-dados-financeiros');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraDadosFinanceiros()
	{
		$id = $this->input->post('id');

		$dados['nome'] = $this->input->post('nome');
		$dados['id_grupo'] = $this->input->post('idGrupo');
		$dados['cnpj'] = $this->input->post('cnpj');
		$dados['razao_social'] = $this->input->post('razaoSocial');
		$dados['telefone'] = $this->input->post('telefone');
		$dados['tipo_cadastro'] = $this->input->post('tipoCadastro');
		$dados['conta_bancaria'] = $this->input->post('contaBancaria');
		$dados['email'] = $this->input->post('email');

		$dados['cep'] = $this->input->post('cep');
		$dados['rua'] = $this->input->post('rua');
		$dados['numero'] = $this->input->post('numero');
		$dados['bairro'] = $this->input->post('bairro');
		$dados['cidade'] = $this->input->post('cidade');
		$dados['estado'] = $this->input->post('estado');
		$dados['complemento'] = $this->input->post('complemento');

		$dados['nome_intermedio'] = $this->input->post('nomeIntermedio');
		$dados['cpf_intermedio'] = $this->input->post('cpfIntermedio');
		$dados['email_intermedio'] = $this->input->post('emailIntermedio');
		$dados['telefone_intermedio'] = $this->input->post('telefoneIntermedio');

		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$nomeDadosFinanceiros = $this->FinDadosFinanceiros_model->recebeNomeDadosFinanceiros($dados['nome'], $dados['cnpj'], $id); // verifica se já existem os Dados Financeiros 

		// Verifica se os Dados Financeiros já existem e se não são os Dados Financeiros que estão sendo editados
		if ($nomeDadosFinanceiros) {

			$response = array(
				'success' => false,
				'message' => "Estes Dados Financeiros já existem! Tente cadastrar um diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->FinDadosFinanceiros_model->editaDadosFinanceiros($id, $dados) : $this->FinDadosFinanceiros_model->insereDadosFinanceiros($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Dados Financeiros editados com sucesso!' : 'Dados Financeiros cadastrados com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar os Dados Financeiros!" : "Erro ao cadastrar os Dados Financeiros!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}


	public function deletaDadosFinanceiros()
	{

		$id = $this->input->post('id');

		$retorno = $this->FinDadosFinanceiros_model->deletaDadosFinanceiros($id);

		if ($retorno) {

			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Dados Financeiros deletados com sucesso!",
				'type' => "success"
			);
		} else {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possivel deletar os Dados Financeiros!",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function recebeDadosFinanceiros()
	{
		$this->load->model('FinDadosFinanceiros_model');

		$dadosFinanceiro = $this->FinDadosFinanceiros_model->recebeDadosFinanceiros();


		if ($dadosFinanceiro) {

			$response = array(
				'dadosFinanceiro' => $dadosFinanceiro,
				'success' => true
			);
		} else {
			$response = array(
				'success' => false
			);
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function visualizarDadosFinanceiros()
	{
		$idDadoFinanceiro = $this->input->post('idDadoFinanceiro');

		$dadosFinanceiros = $this->FinDadosFinanceiros_model->recebeDadoFinanceiro($idDadoFinanceiro);

		if ($dadosFinanceiros) {
			// Aplicar ucwords() para formatar as chaves do array
			$dadosFormatados = array();
			foreach ($dadosFinanceiros as $key => $value) {
				$valorFormatado = ucwords(mb_strtolower($value));
				$dadosFormatados[$key] = $valorFormatado;
			}

			$response = array(
				'success' => true,
				'dadoFinanceiro' => $dadosFormatados
			);
		} else {
			$response = array(
				'success' => false,
				'message' => 'Nenhum dado financeiro encontrado.'
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}


<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Veiculos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// INICIO controle sessão
		$this->load->library('Controle_sessao');
		$res = $this->controle_sessao->controle();
		if ($res == 'erro') {
			redirect('login/erro', 'refresh');
		}
		// FIM controle sessão

		$this->load->model('Veiculos_model');
	}
	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para cadastro de veículos
		$scriptsVeiculosFooter = scriptsVeiculosFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsVeiculosFooter));

		$data['veiculos'] = $this->Veiculos_model->recebeVeiculos();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/veiculos/veiculos');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para cadastro de veículos
		$scriptsVeiculosFooter = scriptsVeiculosFooter();
		$scriptsVeiculosHead = scriptsVeiculosHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsVeiculosHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsVeiculosFooter));

		$id = $this->uri->segment(3);

		$data['veiculo'] = $this->Veiculos_model->recebeVeiculo($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/veiculos/cadastra-veiculo');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function detalhes()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para cadastro de veículos
		$scriptsVeiculosFooter = scriptsVeiculosFooter();
		$scriptsVeiculosHead = scriptsVeiculosHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsVeiculosHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsVeiculosFooter));

		$id = $this->uri->segment(3);

		$data['veiculo'] = $this->Veiculos_model->recebeVeiculo($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/veiculos/detalhes-veiculo');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraVeiculo()
	{
		$this->load->library('upload_imagem');

		$id = $this->input->post('id');
		$modelo = $this->input->post('modelo');

		$dados['modelo'] = mb_convert_case($modelo, MB_CASE_TITLE, 'UTF-8');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');
		$dados['placa'] = $this->input->post('placa');

		$placa = $this->Veiculos_model->recebePlacaVeiculo($dados['placa']); // verifica se já existe a placa

		// Verifica se a placa já existe e se não é a placa que está sendo editada
		if ($placa && $placa['id'] != $id) {
			$response = array(
				'success' => false,
				'message' => "Esta placa já existe! Tente cadastrar uma diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$imagemAntiga = $this->Veiculos_model->recebeVeiculo($id);

		$arrayUpload = [
			'documento'       => ['veiculos/documento', $imagemAntiga['documento'] ?? null],
			'fotoCarro'       => ['veiculos/fotocarro', $imagemAntiga['fotocarro'] ?? null]
		];

		$retornoDados = $this->upload_imagem->uploadImagem($arrayUpload);
		$dados = array_merge($dados, $retornoDados);

		$retorno = $id ? $this->Veiculos_model->editaVeiculo($id, $dados) : $this->Veiculos_model->insereVeiculo($dados); // se tiver ID edita se não INSERE

		if ($retorno) { // inseriu ou editou

			$response = array(
				'success' => true,
				'message' => $id ? 'Veículo editado com sucesso!' : 'Veículo cadastrado com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'success' => false,
				'message' => $id ? "Erro ao editar veículo!" : "Erro ao cadastrar veículo!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function  deletaDocumentos()
	{
		$id = $this->uri->segment(3);
		$nome_arquivo = urldecode($this->uri->segment(4));
		$coluna = $this->uri->segment(5);

		$dados[$coluna] = null;
		$retorno = $this->Veiculos_model->editaVeiculo($id, $dados);

		if ($retorno) {
			$caminho = './uploads/' . $this->session->userdata('id_empresa') . '/' . 'veiculos/' . $coluna . '/' . $nome_arquivo;
			unlink($caminho);
			$this->session->set_flashdata('tipo_retorno_funcao', 'success');
			$this->session->set_flashdata('redirect_retorno_funcao', '#');
			$this->session->set_flashdata('texto_retorno_funcao', 'Arquivo deletado com sucesso!');
			$this->session->set_flashdata('titulo_retorno_funcao', 'Sucesso!');
		} else {
			$this->session->set_flashdata('tipo_retorno_funcao', 'error');
			$this->session->set_flashdata('redirect_retorno_funcao', '#');
			$this->session->set_flashdata('texto_retorno_funcao', 'Não foi possivel deletar o arquivo!');
			$this->session->set_flashdata('titulo_retorno_funcao', 'Algo deu errado!');
		}

		redirect('veiculos/detalhes/' . $id);
	}

	public function deletaVeiculo()
	{
		$id = $this->input->post('id');

		$veiculo = $this->Veiculos_model->recebeVeiculo($id);

		$retorno = $this->Veiculos_model->deletaVeiculo($id);


		if ($retorno) { // deletou

			if ($veiculo['fotocarro']) {
				$link_fotocarro = './uploads/' . $this->session->userdata('id_empresa') . '/veiculos/fotocarro/' . $veiculo['fotocarro'];
				unlink($link_fotocarro);
			}

			if ($veiculo['documento']) {
				$link_documento = './uploads/' . $this->session->userdata('id_empresa') . '/veiculos/documento/' . $veiculo['documento'];
				unlink($link_documento);
			}

			$response = array(
				'success' => true,
				'message' => 'Veículo deletado com sucesso!'
			);
		} else { // erro ao deletar

			$response = array(
				'success' => false,
				'message' => "Erro ao deletar veículo!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

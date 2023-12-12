
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CadastroVeiculos extends CI_Controller
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

		$this->load->model('CadastroVeiculos_model');
	}
	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para cadastro de veículos
		$scriptsCadastroVeiculosFooter = scriptsCadastroVeiculosFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsCadastroVeiculosFooter));

		$data['veiculos'] = $this->CadastroVeiculos_model->recebeVeiculos();

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
		$scriptsCadastroVeiculosFooter = scriptsCadastroVeiculosFooter();
		$scriptsCadastroVeiculosHead = scriptsCadastroVeiculosHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsCadastroVeiculosHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsCadastroVeiculosFooter));

		$id = $this->uri->segment(3);

		$data['veiculo'] = $this->CadastroVeiculos_model->recebeVeiculo($id);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/veiculos/cadastra-veiculo');
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

		$placa = $this->CadastroVeiculos_model->recebePlacaVeiculo($dados['placa']); // verifica se já existe a placa

		// Verifica se a placa já existe e se não é a placa que está sendo editada
		if ($placa && $placa['id'] != $id) {
			$response = array(
				'success' => false,
				'message' => "Esta placa já existe! Tente cadastrar uma diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		if (!empty($_FILES['documento']['name'])) {
			$dados['documento'] =  $this->upload_imagem->uploadImagem('documento', './uploads/veiculos/documento');
		}

		if (!empty($_FILES['fotoCarro']['name'])) {
			$dados['fotocarro'] =  $this->upload_imagem->uploadImagem('fotoCarro', './uploads/veiculos/fotocarro');
		}

		$retorno = $id ? $this->CadastroVeiculos_model->editaVeiculo($id, $dados) : $this->CadastroVeiculos_model->insereNovoVeiculo($dados); // se tiver ID edita se não INSERE

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

	public function deletaVeiculo()
	{
		$id = $this->input->post('id');

		$this->load->model('CadastroVeiculos_model');

		$this->CadastroVeiculos_model->deletaVeiculo($id);
	}
}

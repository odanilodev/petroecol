<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ConversaoUnidadeMedida extends CI_Controller
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

		$this->load->model('ConversaoUnidadeMedida_model');
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para conversaoUnidadeMedida
		$scriptsConversaoUnidadeMedidaFooter = scriptsConversaoUnidadeMedidaFooter();
		$scriptsConversaoUnidadeMedidaHead = scriptsConversaoUnidadeMedidaHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsConversaoUnidadeMedidaHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsConversaoUnidadeMedidaFooter));

		$data['conversoesUnidadesMedidas'] = $this->ConversaoUnidadeMedida_model->recebeConversoes();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/conversaoUnidadeMedida/conversaoUnidadeMedida');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function formulario()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para conversaoUnidadeMedida
		$scriptsConversaoUnidadeMedidaFooter = scriptsConversaoUnidadeMedidaFooter();
		$scriptsConversaoUnidadeMedidaHead = scriptsConversaoUnidadeMedidaHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsConversaoUnidadeMedidaHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsConversaoUnidadeMedidaFooter));

		$id = $this->uri->segment(3);

		$data['conversaoUnidadeMedida'] = $this->ConversaoUnidadeMedida_model->recebeConversaoUnidadeMedida($id);

		// Setores Empresa 
		$this->load->model('SetoresEmpresa_model');
		$data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

		// Resíduos
		$this->load->model('Residuos_model');
		$data['residuos'] = $this->Residuos_model->recebeResiduos();

		// Unidades de Medidas
		$this->load->model('UnidadesMedidas_model');
		$data['unidadesMedidas'] = $this->UnidadesMedidas_model->recebeUnidadesMedidas();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/conversaoUnidadeMedida/cadastra-conversao-unidade-medida');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function cadastraConversao()
	{
		$id = $this->input->post('id');

		$dados['id_residuo'] = $this->input->post('residuo');
		$dados['id_medida_origem'] = $this->input->post('medida_inicial');
		$dados['id_medida_destino'] = $this->input->post('medida_final');
		$dados['tipo_operacao'] = $this->input->post('operador');
		$dados['simbolo_operacao'] = $this->input->post('simbolo');
		$dados['valor'] = str_replace(',', '.', $this->input->post('valor'));

		$dados['id_empresa'] = $this->session->userdata('id_empresa');

		$residuo = $this->ConversaoUnidadeMedida_model->recebeConversaoResiduo($dados['id_residuo'], $id); // verifica se já existe a conversao

		if ($residuo) {

			$response = array(
				'title' => "Algo deu errado!",
				'type' => "error",
				'success' => false,
				'message' => "A conversão para este residuo já existe! Tente cadastrar uma diferente."
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $id ? $this->ConversaoUnidadeMedida_model->editaConversao($id, $dados) : $this->ConversaoUnidadeMedida_model->insereConversao($dados);

		if ($retorno) { // inseriu ou editou

			$response = array(
				'title' => 'Sucesso!',
				'type' => 'success',
				'success' => true,
				'message' => $id ? 'Conversão editada com sucesso!' : 'Conversão cadastrada com sucesso!'
			);
		} else { // erro ao inserir ou editar

			$response = array(
				'title' => "Algo deu errado!",
				'type' => "error",
				'success' => false,
				'message' => "Errao ao " . $id ? 'editar' : 'cadastrar' . " a conversão. Tente novamente!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function exemploConversaoMedidas()
	{

		$valor = $this->input->post('valor');
		$residuo = $this->input->post('residuo');
		$quantidade = $this->input->post('quantidade');
		$tipo_operacao = $this->input->post('tipoOperacao');

		$medidaOrigem = $this->input->post('medidaOrigem');
		$medidaDestino = $this->input->post('medidaDestino');

		$this->load->helper('converter_unidade_medida_residuo');
		$resultado = calcularUnidadeMedidaResiduo($valor, $tipo_operacao, $quantidade);

		echo "$quantidade $medidaOrigem de $residuo equivalem a " . $resultado . " $medidaDestino de $residuo";
	}

	public function deletarConversao()
	{
		$id = $this->input->post('idConversao');

		$retorno = $this->ConversaoUnidadeMedida_model->deletaConversao($id);

		if ($retorno) {

			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Conversão deletada com sucesso!",
				'type' => "success"
			);
		} else {
			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possível deletar a conversão!",
				'type' => "error"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

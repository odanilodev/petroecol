<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendas extends CI_Controller
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

		$this->load->model('Vendas_model');
	}

	public function residuos($page = 1)
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// scripts para vendas
		$scriptsVendasFooter = scriptsVendasFooter();
		$scriptsVendasHead = scriptsVendasHead();

		add_scripts('header', array_merge($scriptsPadraoHead, $scriptsVendasHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsVendasFooter));

		// >>>> PAGINAÇÃO <<<<<
		$limit = 12; // Número de recipientes por página
		$this->load->library('pagination');
		$config['base_url'] = base_url('recipientes/index');
		$config['total_rows'] = $this->Vendas_model->recebeVendasResiduos($limit, $page, true); // true para contar
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = TRUE; // Usar números de página em vez de offset
		$this->pagination->initialize($config);
		// >>>> FIM PAGINAÇÃO <<<<<

		// Setores Empresa 
		$this->load->model('SetoresEmpresa_model');
		$data['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();

		$data['vendasResiduos'] = $this->Vendas_model->recebeVendasResiduos($limit, $page);

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/vendas/vendas-residuos');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function novaVendaResiduo()
	{
		$this->load->model('EstoqueResiduos_model');
		$this->load->model('Residuos_model');

		// Dados para tabela de vendas
		$dados['id_cliente'] = $this->input->post('cliente');
		$dados['id_residuo'] = $this->input->post('residuo');
		$dados['quantidade'] = $this->input->post('quantidade');
		$dados['id_unidade_medida'] = $this->input->post('unidadeMedida');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');
		$dados['valor_total'] = $this->input->post('valorTotal');
		$dados['data_venda'] = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('dataDestinacao'))));

		$unidadeMedidaPadraoResiduo = $this->Residuos_model->recebeResiduo($dados['id_residuo'])['id_unidade_medida'];

		// faz a conversão de quantidade caso o a unidade de medida seja diferente da padrão do resíduo
		if ($unidadeMedidaPadraoResiduo != $dados['id_unidade_medida']) {

			$this->load->model('ConversaoUnidadeMedida_model');
			$this->load->helper('converter_unidade_medida_residuo');

			$dadosConversaoResiduo = $this->ConversaoUnidadeMedida_model->recebeConversaoPorResiduo($dados['id_residuo'], $dados['id_unidade_medida']);

			$quantidadeResiduo = calcularUnidadeMedidaResiduo($dadosConversaoResiduo['valor'], $dadosConversaoResiduo['tipo_operacao'], $dados['quantidade']); // quantidade convertida
		}

		$quantidadeTotalResiduo = $this->EstoqueResiduos_model->recebeTotalAtualEstoqueResiduo($dados['id_residuo']);

		if ($quantidadeTotalResiduo['total_estoque_residuo'] < $quantidadeResiduo) {
			$response = array(
				'success' => false,
				'type' => 'error',
				'title' => 'Algo deu errado!',
				'message' => 'Não há essa quantidade de resíduo no estoque!'
			);

			return $this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		$retorno = $this->Vendas_model->insereNovaVendaResiduo($dados);

		// dados para tabela de estoque
		$dadosResiduosEstoque['id_residuo'] = $dados['id_residuo'];
		$dadosResiduosEstoque['quantidade'] = number_format($quantidadeResiduo, 3, '.', '');;
		$dadosResiduosEstoque['id_unidade_medida'] = $unidadeMedidaPadraoResiduo;
		$dadosResiduosEstoque['tipo_movimentacao'] = 0; // saída
		$dadosResiduosEstoque['id_empresa'] = $dados['id_empresa'];

		// soma o total do residuo de acordo com o ultimo total gravado
		$dadosResiduosEstoque['total_estoque_residuo'] = $quantidadeTotalResiduo['total_estoque_residuo'] - $dadosResiduosEstoque['quantidade'];
		$dadosResiduosEstoque['total_estoque_residuo'] = number_format($dadosResiduosEstoque['total_estoque_residuo'], 3, '.', '');
		$this->EstoqueResiduos_model->insereEstoqueResiduos($dadosResiduosEstoque);


		if ($retorno) {

			$response = array(
				'success' => true,
				'type' => 'success',
				'title' => 'Sucesso!',
				'message' => 'Venda realizada com sucesso!'
			);
		} else {

			$response = array(
				'success' => false,
				'type' => 'error',
				'title' => 'Algo deu errado!',
				'message' => "Erro ao realizar a venda!"
			);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deletaVendaResiduo()
	{
		$idVenda = $this->input->post('idVenda');


		$retorno = $this->Vendas_model->deletaVendaResiduo($idVenda);

		if ($retorno) {
			$response = array(
				'success' => true,
				'title' => "Sucesso!",
				'message' => "Venda deletada com sucesso!",
				'type' => "success"
			);
		} else {

			$response = array(
				'success' => false,
				'title' => "Algo deu errado!",
				'message' => "Não foi possivel deletar a venda!",
				'type' => "error"
			);
		}


		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

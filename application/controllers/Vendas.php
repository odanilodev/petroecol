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

	public function novaVendaResiduo()
	{
		$this->load->model('EstoqueResiduos_model');

		// Dados para tabela de vendas
		$dados['id_cliente'] = $this->input->post('cliente');
		$dados['id_residuo'] = $this->input->post('residuo');
		$dados['id_unidade_medida'] = $this->input->post('unidadeMedida');
		$dados['quantidade'] = $this->input->post('quantidade');
		$dados['id_empresa'] = $this->session->userdata('id_empresa');
		$dados['valor_medida'] = $this->input->post('valorUnidadeMedida');
		$dados['valor_total'] = $this->input->post('valorTotal');
		$dados['data_venda'] = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('dataDestinacao'))));

		// dados para tabela de estoque
		$dadosResiduosEstoque['id_residuo'] = $dados['id_residuo'];
		$dadosResiduosEstoque['quantidade'] = $dados['quantidade'];
		$dadosResiduosEstoque['id_unidade_medida'] = $dados['id_unidade_medida'];
		$dadosResiduosEstoque['tipo_movimentacao'] = 0; // saída
		$dadosResiduosEstoque['id_empresa'] = $dados['id_empresa'];

		$this->EstoqueResiduos_model->insereEstoqueResiduos($dadosResiduosEstoque); 

		$retorno = $this->Vendas_model->insereNovaVendaResiduo($dados);
		
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
}

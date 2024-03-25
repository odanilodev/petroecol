<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinContasPagar extends CI_Controller
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
	}

	public function index()
	{
		// scripts padrão
		$scriptsPadraoHead = scriptsPadraoHead();
		$scriptsPadraoFooter = scriptsPadraoFooter();

		// Scripts para contas a pagar
		$scriptsContasPagarFooter = scriptsFinContasPagarFooter();

		add_scripts('header', array_merge($scriptsPadraoHead));
		add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsContasPagarFooter));

		$this->load->model('FinFormaTransacao_model');
		$this->load->model('FinContaBancaria_model');
		$this->load->model('FinContasPagar_model');

		$data['formasTransacao'] = $this->FinFormaTransacao_model->recebeFormasTransacao();
		$data['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();
		$data['contasPagar'] = $this->FinContasPagar_model->recebeContasPagar();

		$this->load->view('admin/includes/painel/cabecalho', $data);
		$this->load->view('admin/paginas/financeiro/contas-pagar');
		$this->load->view('admin/includes/painel/rodape');
	}

	public function realizarPagamento () 
	{
		$contasBancarias = $this->input->post('contasBancarias');
		$formasPagamento = $this->input->post('formasPagamento');
		$valores = $this->input->post('valores');
		$obs = $this->input->post('obs');
		$idConta = $this->input->post('idConta');

		// echo "obs: $obs";
		// echo "id da conta: $idConta";

		// echo "<pre>"; print_r($contasBancarias);
		// echo "<pre>"; print_r($formasPagamento);
		// echo "<pre>"; print_r($valores);

		// retorno conta paga (adapta no seu back ai)
		$response = array(
			'success' => true,
			'message' => "Pagamento realizado com sucesso!",
			'idConta' => $idConta,
			'type' => "success"
			
		);

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

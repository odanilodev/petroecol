<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class FinFluxoCaixa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //INICIO controle sessão
        $this->load->library('Controle_sessao');
        $this->load->model('FinFluxo_model');
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

        // Scripts para Fluxo
        $scriptsFluxoFooter = scriptsFinFluxoFooter();

        add_scripts('header', array_merge($scriptsPadraoHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFluxoFooter));

        $this->load->view('admin/includes/painel/cabecalho');
        $this->load->view('admin/paginas/financeiro/fluxo-caixa.php');
        $this->load->view('admin/includes/painel/rodape');
    }

    public function insereMovimentacaoFluxo()
    {
        $scriptsFluxoFooter = scriptsFinFluxoFooter();

        $dados['id_empresa'] = $this->session->userdata('id_empresa');
        $dados['id_conta_bancaria'] = $this->input->post('id_conta_bancaria');
        $dados['id_vinculo_conta'] = $this->input->post('id_vinculo_conta');
        $dados['id_tarifa_bancaria'] = $this->input->post('id_tarifa_bancaria');
        $dados['id_forma_transacao'] = $this->input->post('id_forma_transacao');
        $dados['valor'] = $this->input->post('valor');
        $dados['movimentacao_tabela'] = $this->input->post('movimentacao_tabela');
        $dados['id_dado_financeiro'] = $this->input->post('id_dado_financeiro');
        $dados['observacao'] = $this->input->post('observacao');

        $retorno = $this->FinFluxo_model->insereFluxo($dados);

        print_r($retorno);
        exit;

        if ($retorno) {

            $response = array(
                'success' => true,
                'message' => 'Movimentação registrada!'
            );

        } else {

            $response = array(
                'success' => false,
                'message' => "Erro ao registrar movimentação"
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));

    }

}

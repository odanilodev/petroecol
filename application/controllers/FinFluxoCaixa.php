<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

    public function index($page = 1)
    {
        // scripts padrão
        $scriptsPadraoHead = scriptsPadraoHead();
        $scriptsPadraoFooter = scriptsPadraoFooter();

        // Scripts para Fluxo
        $scriptsFluxoHead = scriptsFinFluxoHead();
        $scriptsFluxoFooter = scriptsFinFluxoFooter();

        add_scripts('header', array_merge($scriptsPadraoHead, $scriptsFluxoHead));
        add_scripts('footer', array_merge($scriptsPadraoFooter, $scriptsFluxoFooter));

        // Define as datas padrão caso não sejam recebidas via POST
        $dataInicio = new DateTime();
        $dataInicio->modify('-30 days');
        $dataInicioFormatada = $dataInicio->format('Y-m-d');

        $dataFim = new DateTime();
        $dataFimFormatada = $dataFim->format('Y-m-d');

        $this->load->library('finDadosFinanceiros');

        $this->load->model('FinGrupos_model');
        $this->load->model('FinFormaTransacao_model');
        $this->load->model('FinContaBancaria_model');
        $this->load->model('FinMacro_model');

        $dados['macros'] = $this->FinMacro_model->recebeMacros();

        $dados['grupos'] = $this->FinGrupos_model->recebeGrupos();

        $dados['formasTransacao'] = $this->FinFormaTransacao_model->recebeFormasTransacao();
        $dados['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();


        $dados['saldoTotal'] = $this->findadosfinanceiros->somaSaldosBancarios();

        // Verifica se as datas foram recebidas via POST
        if ($this->input->post('data_inicio') && $this->input->post('data_fim')) {
            $dataInicioFormatada = $this->input->post('data_inicio');
            $dataFimFormatada = $this->input->post('data_fim');

            // Converte as datas para o formato americano (Y-m-d)
            $dataInicioFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataInicioFormatada)));
            $dataFimFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataFimFormatada)));
        }

        //Soma as movimentacoes da tabela fluxo.
        $dados['totalSaida'] = $this->findadosfinanceiros->totalFluxoFinanceiro('valor', 0, $dataInicioFormatada, $dataFimFormatada);
        $dados['totalEntrada'] = $this->findadosfinanceiros->totalFluxoFinanceiro('valor', 1, $dataInicioFormatada, $dataFimFormatada);

        $dados['balancoFinanceiro'] = $dados['totalEntrada']['valor'] - $dados['totalSaida']['valor'];

        $dados['dataInicio'] = $this->input->post('data_inicio');
        $dados['dataFim'] = $this->input->post('data_fim');

        // Verifica se o tipo de movimentação foi recebido via POST
        $tipoMovimentacao = $this->input->post('movimentacao');

        // Se não houver nenhum valor recebido via POST, define 'ambas' como valor padrão
        if ($tipoMovimentacao === null || $tipoMovimentacao === '') {
            $tipoMovimentacao = 'ambas';
        }

        $dados['tipoMovimentacao'] = $tipoMovimentacao;

        // >>>> PAGINAÇÃO <<<<<
        $limit = 12; // Número de registros por página
        $this->load->library('pagination');
        $config['base_url'] = base_url('finFluxoCaixa/index');
        $config['total_rows'] = $this->FinFluxo_model->recebeFluxoData($dataInicioFormatada, $dataFimFormatada, $tipoMovimentacao, 0, 0, true); // Conta o total de registros
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        // >>>> FIM PAGINAÇÃO <<<<<

        $dados['movimentacoes'] = $this->FinFluxo_model->recebeFluxoData($dataInicioFormatada, $dataFimFormatada, $tipoMovimentacao, $limit, $page);
        $this->load->view('admin/includes/painel/cabecalho', $dados);
        $this->load->view('admin/paginas/financeiro/fluxo-caixa');
        $this->load->view('admin/includes/painel/rodape');
    }


    public function insereMovimentacaoFluxo()
    {
        $this->load->model('FinSaldoBancario_model');

        $dados['id_empresa'] = $this->session->userdata('id_empresa');
        $dados['id_conta_bancaria'] = $this->input->post('id_conta_bancaria');
        $dados['id_vinculo_conta'] = $this->input->post('id_vinculo_conta');
        $dados['id_tarifa_bancaria'] = $this->input->post('id_tarifa_bancaria');
        $dados['id_forma_transacao'] = $this->input->post('id_forma_transacao');
        $dados['valor'] = $this->input->post('valor');
        $dados['movimentacao_tabela'] = $this->input->post('movimentacao_tabela');
        $dados['id_dado_financeiro'] = $this->input->post('id_dado_financeiro');
        $dados['id_micro'] = $this->input->post('micros');
        $dados['id_macro'] = $this->input->post('macros');
        $data_movimentacao = $this->input->post('data_movimentacao');


        $dados['data_movimentacao'] = date('Y-m-d', strtotime(str_replace('/', '-', $data_movimentacao)));

        $dados['observacao'] = $this->input->post('observacao');

        if (!$dados['id_vinculo_conta']) {

            $saldoAtual = $this->FinSaldoBancario_model->recebeSaldoBancario($dados['id_conta_bancaria']);

            $valorMovimentacaoFormatado = str_replace(['.', ','], ['', '.'], $dados['valor']); //Muda para o tipo float

            if ($dados['movimentacao_tabela']) {
                $novoSaldo = $saldoAtual['saldo'] + $valorMovimentacaoFormatado;
            } else {
                $novoSaldo = $saldoAtual['saldo'] - $valorMovimentacaoFormatado;
            }

        }

        $retornoConta = $this->FinSaldoBancario_model->atualizaSaldoBancario($dados['id_conta_bancaria'], $novoSaldo);

        $retorno = $this->FinFluxo_model->insereFluxo($dados);

        $response = array(
            'success' => $retornoConta ? true : false,
            'message' => $retornoConta ? 'Saldo alterado com sucesso.' : 'Erro ao alterar o saldo.',
            'title' => $retornoConta ? 'Sucesso!' : 'Algo deu errado!',
            'type' => $retornoConta ? 'success' : 'error'
        );

        $response = array(
            'success' => $retorno ? true : false,
            'message' => $retorno ? 'Movimentação registrada com sucesso.' : 'Erro ao registrar movimentação.',
            'title' => $retornoConta ? 'Sucesso!' : 'Algo deu errado!',
            'type' => $retorno ? 'success' : 'error'
        );

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));

    }

    public function recebeMovimentoFluxo()
    {
        $id = $this->input->post('idFluxo');

        $dadosFluxo = $this->FinFluxo_model->recebeMovimentoFluxo($id);

        if ($dadosFluxo) {
            $response = array(
                'success' => true,
                'dadosFluxo' => $dadosFluxo,
                'type' => 'success'
            );
        } else {
            $response = array(
                'success' => false,
                'type' => 'error'
            );
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

}

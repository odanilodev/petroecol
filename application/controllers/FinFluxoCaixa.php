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

    public function index()
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
        $this->load->model('SetoresEmpresa_model');

        $dados['macros'] = $this->FinMacro_model->recebeMacros();

        $dados['grupos'] = $this->FinGrupos_model->recebeGrupos();

        $dados['formasTransacao'] = $this->FinFormaTransacao_model->recebeFormasTransacao();
        $dados['contasBancarias'] = $this->FinContaBancaria_model->recebeContasBancarias();
        $dados['setoresEmpresa'] = $this->SetoresEmpresa_model->recebeSetoresEmpresa();


        $dados['saldoTotal'] = $this->findadosfinanceiros->somaSaldosBancarios();

        // Verifica se as datas foram recebidas via POST
        if ($this->input->post('data_inicio') && $this->input->post('data_fim')) {
            $dataInicioFormatada = $this->input->post('data_inicio');
            $dataFimFormatada = $this->input->post('data_fim');

            // Converte as datas para o formato americano (Y-m-d)
            $dataInicioFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataInicioFormatada)));
            $dataFimFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataFimFormatada)));
        }

        $dados['dataInicio'] = $this->input->post('data_inicio');
        $dados['dataFim'] = $this->input->post('data_fim');
        $idSetor = $this->input->post('setor-empresa');

        if ($idSetor === null || $idSetor === '') {
            $idSetor = "todos";
        }

        //Soma as movimentacoes da tabela fluxo.
        $dados['totalSaida'] = $this->findadosfinanceiros->totalFluxoFinanceiro('valor', 0, $dataInicioFormatada, $dataFimFormatada, $idSetor);
        $dados['totalEntrada'] = $this->findadosfinanceiros->totalFluxoFinanceiro('valor', 1, $dataInicioFormatada, $dataFimFormatada, $idSetor);

        $dados['balancoFinanceiro'] = $dados['totalEntrada']['valor'] - $dados['totalSaida']['valor'];

        // Verifica se o tipo de movimentação foi recebido via POST
        $tipoMovimentacao = $this->input->post('movimentacao');

        // Se não houver nenhum valor recebido via POST, define 'ambas' como valor padrão
        if ($tipoMovimentacao === null || $tipoMovimentacao === '') {
            $tipoMovimentacao = 'ambas';
        }

        $dados['tipoMovimentacao'] = $tipoMovimentacao;
        $dados['idSetor'] = $idSetor;

        $dados['movimentacoes'] = $this->FinFluxo_model->recebeFluxoData($dataInicioFormatada, $dataFimFormatada, $tipoMovimentacao, $idSetor);

        $this->load->view('admin/includes/painel/cabecalho', $dados);
        $this->load->view('admin/paginas/financeiro/fluxo-caixa');
        $this->load->view('admin/includes/painel/rodape');
    }


    public function insereMovimentacaoFluxo()
    {
        $this->load->model('FinSaldoBancario_model');

        $dados['id_empresa'] = $this->session->userdata('id_empresa');
        $dados['id_conta_bancaria'] = $this->input->post('id_conta_bancaria');
        $dados['id_setor_empresa'] = $this->input->post('id_setor_empresa');
        $dados['id_vinculo_conta'] = $this->input->post('id_vinculo_conta');
        $dados['id_tarifa_bancaria'] = $this->input->post('id_tarifa_bancaria');
        $dados['id_forma_transacao'] = $this->input->post('id_forma_transacao');
        $dados['valor'] = str_replace(['.', ','], ['', '.'], $this->input->post('valor'));
        $dados['movimentacao_tabela'] = $this->input->post('movimentacao_tabela');
        $dados['id_micro'] = $this->input->post('micros');
        $dados['id_macro'] = $this->input->post('macros');
        $data_movimentacao = $this->input->post('data_movimentacao');
        $grupoRecebido = $this->input->post('grupo_recebido');

        $dados['id_cliente'] = null;
        $dados['id_funcionario'] = null;
        $dados['id_dado_financeiro'] = null;

        if ($grupoRecebido == 'clientes') {
            $dados['id_cliente'] = $this->input->post('id_dado_financeiro');
        } else if ($grupoRecebido == 'funcionarios') {
            $dados['id_funcionario'] = $this->input->post('id_dado_financeiro');
        } else {
            $dados['id_dado_financeiro'] = $this->input->post('id_dado_financeiro');
        }

        $dados['data_movimentacao'] = date('Y-m-d', strtotime(str_replace('/', '-', $data_movimentacao)));

        $dados['observacao'] = $this->input->post('observacao');

        if (!$dados['id_vinculo_conta']) {

            $saldoAtual = $this->FinSaldoBancario_model->recebeSaldoBancario($dados['id_conta_bancaria']);

            $valorMovimentacaoFormatado = $dados['valor']; //Muda para o tipo float

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

    public function insereMovimentacaoRomaneioFluxo()
    {
        $this->load->model('FinSaldoBancario_model');

        $idResponsavel = $this->input->post('responsavel');
        $idEmpresa = $this->input->post('setorEmpresa');
        $codigoRomaneio = $this->input->post('codRomaneio');
        $dataRomaneio = $this->input->post('dataRomaneio');

        if ($dataRomaneio > date('Y-m-d')) {
            $dataFluxo = date('Y-m-d');
        } else {
            $dataFluxo = $dataRomaneio;
        }

        $this->load->model('Funcionarios_model');

        $dadosFluxo = $this->input->post('dadosFluxo');

        $dados['id_empresa'] = $this->session->userdata('id_empresa');

        if (!empty($dadosFluxo['valor'][0])) {

            for ($i = 0; $i < count($dadosFluxo['id_micro']); $i++) {

                $dados['id_conta_bancaria'] = $dadosFluxo['conta-bancaria'][$i];

                $dados['id_forma_transacao'] = $dadosFluxo['forma-pagamento'][$i];
                $dados['valor'] = str_replace(['.', ','], ['', '.'], $dadosFluxo['valor'][$i]);
                $dados['movimentacao_tabela'] = 0; // sempre saída

                $dados['id_micro'] = $dadosFluxo['id_micro'][$i];
                $dados['id_macro'] = $dadosFluxo['id_macro'][$i];
                $dados['data_movimentacao'] = $dataFluxo;
                $dados['id_funcionario'] = $idResponsavel;
                $dados['id_setor_empresa'] = $idEmpresa;
                $dados['observacao'] = "Romaneio: $codigoRomaneio";

                $this->FinFluxo_model->insereFluxo($dados); // insere a movimentação no fluxo


                // atualiza as contas bancarias
                $saldoAtualContaBancaria = $this->FinSaldoBancario_model->recebeSaldoBancario($dadosFluxo['conta-bancaria'][$i]);
                $novoSaldoContaBancaria = $saldoAtualContaBancaria['saldo'] - $dados['valor'];
                $this->FinSaldoBancario_model->atualizaSaldoBancario($dadosFluxo['conta-bancaria'][$i], $novoSaldoContaBancaria);

                // atualiza o saldo do responsavel
                $saldoAtualFuncionario = $this->Funcionarios_model->recebeSaldoFuncionario($idResponsavel);
                $novoSaldoFuncionario = $saldoAtualFuncionario['saldo'] + $dados['valor'];
                $this->Funcionarios_model->atualizaSaldoFuncionario($idResponsavel, $novoSaldoFuncionario);
            }
        }

        return true;
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

    public function deletaFluxo()
    {
        $this->load->model('FinContaBancaria_model');

        $id = $this->input->post('idFluxo');
        $valor = $this->input->post('valor');
        $idContaBancaria = $this->input->post('idContaBancaria');
        $tipoMovimentacao = $this->input->post('tipoMovimentacao');

        $saldoContaBancaria = $this->FinContaBancaria_model->recebeSaldoBancario($idContaBancaria);

        if ($tipoMovimentacao) {
            $dadosSaldo['saldo'] = $saldoContaBancaria['saldo'] - $valor;
        } else {
            $dadosSaldo['saldo'] = $saldoContaBancaria['saldo'] + $valor;
        }

        if ($this->input->post('extornarValores') == true) {

            $this->FinContaBancaria_model->editaSaldoBancaria($saldoContaBancaria['id'], $dadosSaldo);
        }


        $retorno = $this->FinFluxo_model->deletaMovimentoFluxo($id); // deleta o fluxo

        if ($retorno) {
            $response = array(
                'success' => true,
                'title' => "Sucesso!",
                'message' => "Movimentação deletada com sucesso!",
                'type' => "success"
            );
        } else {
            // Se houve um problema em uma das operações
            $response = array(
                'success' => false,
                'title' => "Algo deu errado!",
                'message' => "Não foi possível deletar a movimentação.",
                'type' => "error"
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function geraExcelFluxo()
    {
        // Recebe as datas e filtros via POST
        $dataInicio = $this->input->post('data_inicio');
        $dataFim = $this->input->post('data_fim');
        $tipoMovimentacao = $this->input->post('movimentacao');
        $idSetor = $this->input->post('setor-empresa');


        // Define valores padrão caso os filtros não sejam fornecidos
        $tipoMovimentacao = $tipoMovimentacao ? $tipoMovimentacao : 'ambas';
        $idSetorEmpresa = $idSetor ? $idSetor : 'todos';

        // Formata as datas para o formato Y-m-d
        $dataInicioFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataInicio)));
        $dataFimFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $dataFim)));

        // Carrega o modelo e obtém os dados filtrados
        $this->load->model('FinFluxo_model');
        $movimentacoes = $this->FinFluxo_model->recebeFluxoData($dataInicioFormatada, $dataFimFormatada, $tipoMovimentacao, $idSetorEmpresa);

        // Cria o conteúdo do Excel usando XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x="urn:schemas-microsoft-com:office:excel">';
        $xml .= '<Worksheet ss:Name="FluxoCaixa">';
        $xml .= '<Table>';

        // Cabeçalhos das colunas
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">Data</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Valor</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Recebido Por</Data></Cell>';  // Nova coluna
        $xml .= '<Cell><Data ss:Type="String">Forma Transação</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Tipo</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Setor</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Micro</Data></Cell>';

        $xml .= '</Row>';

        // Preenche os dados no Excel
        foreach ($movimentacoes as $movimentacao) {
            if (is_array($movimentacao)) {
                $recebidoPor = '';

                // Define quem recebeu a movimentação
                if (!empty($movimentacao['nome_dado_financeiro'])) {
                    $recebidoPor = ucfirst($movimentacao['nome_dado_financeiro']);
                } else if (!empty($movimentacao['FUNCIONARIO'])) {
                    $recebidoPor = ucfirst($movimentacao['FUNCIONARIO']);
                } else {
                    $recebidoPor = ucfirst($movimentacao['CLIENTE']);
                }

                $xml .= '<Row>';
                $xml .= '<Cell><Data ss:Type="String">' . (isset($movimentacao['data_movimentacao']) ? date('d/m/Y', strtotime($movimentacao['data_movimentacao'])) : 'N/A') . '</Data></Cell>';
                $xml .= '<Cell><Data ss:Type="String">' . ($movimentacao['valor'] ?? 'N/A') . '</Data></Cell>';
                $xml .= '<Cell><Data ss:Type="String">' . $recebidoPor . '</Data></Cell>';  // Adiciona o valor da variável 'Recebido Por'
                $xml .= '<Cell><Data ss:Type="String">' . ($movimentacao['nome_forma_transacao'] ?? 'N/A') . '</Data></Cell>';
                $xml .= '<Cell><Data ss:Type="String">' . ($movimentacao['movimentacao_tabela'] == 1 ? "Entrada" : "Saída") . '</Data></Cell>';
                $xml .= '<Cell><Data ss:Type="String">' . ($movimentacao['NOME_SETOR'] ?? 'N/A') . '</Data></Cell>';
                $xml .= '<Cell><Data ss:Type="String">' . ($movimentacao['NOME_MICRO'] ?? 'N/A') . '</Data></Cell>';

                $xml .= '</Row>';
            }
        }

        // Fecha a tabela e a planilha
        $xml .= '</Table>';
        $xml .= '</Worksheet>';
        $xml .= '</Workbook>';

        // Define o nome do arquivo
        $fileName = 'FluxoCaixa_' . date('Ymd') . '.xls';

        // Define os cabeçalhos para o download do arquivo
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Limpa o buffer de saída para evitar corrupção do arquivo
        ob_end_clean();

        // Imprime o conteúdo XML gerado
        echo $xml;
        exit;
    }
}

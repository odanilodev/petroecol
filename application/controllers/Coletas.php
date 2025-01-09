<?php

use PhpParser\Node\Stmt\Break_;

defined('BASEPATH') or exit('No direct script access allowed');

class Coletas extends CI_Controller
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
        $this->load->model('Coletas_model');
        $this->load->model('FinContaBancaria_model');
        $this->load->model('FinSaldoBancario_model');
        $this->load->model('FinFluxo_model');
        $this->load->model('FinMicro_model');
        $this->load->helper('verificar_array_vazio');
    }

    public function cadastraColeta()
    {
        $this->load->library('agendarFrequencia');
        $this->load->model('Romaneios_model');
        $this->load->model('Agendamentos_model');
        $this->load->model('Funcionarios_model');

        $coletaManual = $this->input->post('coletaManual'); // true quando insere coleta pela página de cliente

        $payload = $this->input->post('clientes');

        $codRomaneio = $this->input->post('codRomaneio');
        $idResponsavel = $this->input->post('idResponsavel');
        $idSetorEmpresa = $this->input->post('idSetorEmpresa'); // Recebe o id do setor responsavel pelo agendamento
        $dataRomaneio = $this->input->post('dataRomaneio');
        $valorTotal = $this->input->post('valorTotal');

        if ($valorTotal) {
            $saldoAtual = $this->Funcionarios_model->recebeSaldoFuncionario($idResponsavel);

            $novoSaldo = $saldoAtual['saldo'] - $valorTotal;

            $this->Funcionarios_model->atualizaSaldoFuncionario($idResponsavel, $novoSaldo);
        }

        $verificaAgendamentosFuturos = $this->input->post('verificaAgendamentosFuturos');

        $idColeta = $this->input->post('idColeta');

        // remove a observacao da proxima coleta caso a data do romaneio seja maior que a data que foi adicionada a observacao
        $obsColetaCliente['observacao_coleta'] = "";
        $obsColetaCliente['data_observacao_coleta'] = "";
        $obsColetaCliente['codigo_romaneio_obs_coletado'] = $codRomaneio;
        $todosIdsClientes = $this->input->post('todosIdsClientes');

        if ($todosIdsClientes) {

            foreach($todosIdsClientes as $idCliente) {
                $dataObservacaoColeta = $this->Clientes_model->recebeDataObservacaoColetaCliente($idCliente);
                if ($dataObservacaoColeta > $dataRomaneio) {
                    $this->Clientes_model->editaCliente($idCliente, $obsColetaCliente);
                }
            }
        }

        if ($payload) {
            foreach ($payload as $cliente):

                if (isset($cliente['qtdColetado'])) {


                    $residuos['quantidade'] = $cliente['qtdColetado'];
                    $residuos['ids'] = $cliente['residuos'];
                    $residuos['valores'] = $cliente['valoresResiduos'] ?? 0;
                }

                // calcula o saldo das contas bancarias que saiu dinheiro
                if (!empty($cliente['dadosBancarios'])) {

                    $this->calcularNovoSaldoContasBancarias($cliente['dadosBancarios']);
                }

                // calcula o valor dos residuos e insere no contas a pagar as contas a prazo
                $this->salvarValorResiduosContasPagar($idSetorEmpresa, $residuos ?? null, $cliente['idCliente'], $cliente['tipoPagamento'] ?? null, $cliente['dadosBancarios'] ?? null, $codRomaneio, $dataRomaneio);


                $proximosAgendamentos[] = $verificaAgendamentosFuturos ? $this->Agendamentos_model->recebeProximosAgendamentosCliente($cliente['idCliente'], $dataRomaneio) : "";

                $dados = array(
                    'id_cliente' => $cliente['idCliente'],
                    'id_responsavel' => $idResponsavel,
                    'residuos_coletados' => json_encode($cliente['residuos'] ?? ""),
                    'forma_pagamento' => json_encode($cliente['pagamento'] ?? ""),
                    'quantidade_coletada' => json_encode($cliente['qtdColetado'] ?? ""),
                    'valor_pago' => json_encode($cliente['valor'] ?? ""),
                    'data_coleta' => $dataRomaneio,
                    'id_setor_empresa' => $idSetorEmpresa,
                    'id_empresa' => $this->session->userdata('id_empresa'),
                );

                if (isset($cliente['idSetorEmpresa'])) {
                    $dados['id_setor_empresa'] = $cliente['idSetorEmpresa'];
                }

                if (isset($codRomaneio)) {
                    $dados['cod_romaneio'] = $codRomaneio;
                }

                if (isset($cliente['coletado'])) {
                    $dados['coletado'] = $cliente['coletado'];
                }

                if (isset($cliente['obs'])) {
                    $dados['observacao'] = $cliente['obs'];
                }

                $inseriuColeta = !$idColeta ? $this->Coletas_model->insereColeta($dados) : $this->Coletas_model->editaColeta($idColeta, $dados);

                if ($inseriuColeta && $cliente['coletado'] && !$coletaManual) {
                    $valor['status'] = 1;
                    $this->Agendamentos_model->editaAgendamentoData($cliente['idCliente'], $dataRomaneio, $valor, $idSetorEmpresa);
                }

                if (!$coletaManual) {
                    !$idColeta ? $this->agendarfrequencia->cadastraAgendamentoFrequencia($cliente['idCliente'], $dataRomaneio, $idSetorEmpresa) : "";
                }

            endforeach;

            function verificaAgendamentosFuturos($agendamentos)
            {
                foreach ($agendamentos as $agendamento) {
                    if (!empty($agendamento)) {
                        return true;
                    }
                }
                return false;
            }

            if (verificaAgendamentosFuturos($proximosAgendamentos)) {

                $response = array(
                    'success' => true,
                    'agendamentos' => $proximosAgendamentos,
                    'proximosAgendamentos' => true
                );

                return $this->output->set_content_type('application/json')->set_output(json_encode($response));
            } else {
                $response = array(
                    'success' => true,
                    'message' => $idColeta ? 'Coleta editada com Sucesso!' : 'Coleta(s) cadastrada(s) com sucesso!',
                    'proximosAgendamentos' => false

                );
            }

            $data['status'] = 1;
            $this->Romaneios_model->editaRomaneioCodigo($codRomaneio, $data);
        } else {

            $response = array(
                'success' => false,
                'proximosAgendamentos' => false,
                'message' => 'Erro ao cadastrar a coleta.'
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    function salvarValorResiduosContasPagar($idSetorEmpresa, $dadosResiduos, $idCliente, $tipoPagamento, $dadosContasBancarias, $codRomaneio, $dataRomaneio)
    {
        $microPadraoRomaneio = $this->FinMicro_model->recebePadraoMicro('romaneios');

        if (verificaArrayVazio($dadosContasBancarias)) {

            for ($f = 0; $f < count($dadosContasBancarias['valor'][0]); $f++) {

                if ($dadosContasBancarias['valor'][0][$f]) {
                    // dados para o fluxo
                    $dadosFluxo['valor'] = $dadosContasBancarias['valor'][0][$f];
                    $dadosFluxo['id_conta_bancaria'] = $dadosContasBancarias['idContaBancaria'][0][$f];
                    $dadosFluxo['id_forma_transacao'] = $dadosContasBancarias['formaPagamentoContaBancaria'][0][$f];
                    $dadosFluxo['id_cliente'] = $idCliente;
                    $dadosFluxo['id_micro'] = $microPadraoRomaneio['id']; // idMicro padrão para concluir romaneio
                    $dadosFluxo['id_macro'] = $microPadraoRomaneio['id_macro']; // idMacro padrão para concluir romaneio
                    $dadosFluxo['observacao'] = 'Romaneio: ' . $codRomaneio;
                    $dadosFluxo['movimentacao_tabela'] = 0;
                    $dadosFluxo['id_empresa'] = $this->session->userdata('id_empresa');
                    $dadosFluxo['data_movimentacao'] = $dataRomaneio;
                    $dadosFluxo['id_setor_empresa'] = $idSetorEmpresa;

                    $this->FinFluxo_model->insereFluxo($dadosFluxo);
                }
            }
        }

        if ($tipoPagamento) {

            $dataAtual = new DateTime();
            $dataAtual->modify('+30 days');
            $diaPagamentoProximoMes = $dataAtual->format('d');

            for ($c = 0; $c < count($tipoPagamento); $c++) {

                $microPadraoRomaneio = $this->FinMicro_model->recebePadraoMicro('romaneios');

                // verifica se o tipo de pagamento é a prazo
                if ($tipoPagamento[$c] == 1) {

                    $this->load->model('FinContasPagar_model');
                    $this->load->model('ResiduoCliente_model');
                    $this->load->model('FinMicro_model');


                    $valorTotal = 0;
                    for ($i = 0; $i < count($dadosResiduos['ids']); $i++) {

                        $idResiduo = $dadosResiduos['ids'][$i];
                        $quantidadeResiduo = $dadosResiduos['quantidade'][$i];

                        $residuos = $this->ResiduoCliente_model->recebeValorResiduoCliente($idResiduo, $idCliente);


                        $diaPagamento = $residuos['dia_pagamento'] ?? $diaPagamentoProximoMes;


                        $valoresPago = $quantidadeResiduo * $dadosResiduos['valores'][$i];

                        // Adiciona o valor ao total
                        $valorTotal += $valoresPago;
                    }

                    $mesAtual = date('m');
                    $anoAtual = date('Y');
                    $dataAtual = date('Y-m-d');

                    if ($diaPagamento) {
                        $diaPagamento = $diaPagamento;
                    } else {
                        $diaPagamento = $diaPagamentoProximoMes;
                    }

                    $dataVencimento = $anoAtual . '-' . $mesAtual . '-' . $diaPagamento;

                    $dataVencimentoObj = new DateTime($dataVencimento);

                    $dataVencimentoObj->modify('+1 month');



                    $contasPagar['valor'] = $valorTotal;
                    $contasPagar['id_cliente'] = $idCliente;
                    $contasPagar['data_vencimento'] = $dataVencimentoObj->format('Y-m-d');
                    $contasPagar['id_micro'] = $microPadraoRomaneio['id'];
                    $contasPagar['id_macro'] = $microPadraoRomaneio['id_macro'];
                    $contasPagar['observacao'] = 'Romaneio: ' . $codRomaneio;
                    $contasPagar['status'] = 0;
                    $contasPagar['id_empresa'] = $this->session->userdata('id_empresa');
                    $contasPagar['id_setor_empresa'] = $idSetorEmpresa;

                    if ($contasPagar['valor']) {

                        $this->FinContasPagar_model->insereConta($contasPagar);
                    }
                }
            }
        }
    }

    function calcularNovoSaldoContasBancarias($dadosContasBancarias)
    {

        $dadosBancarios = "";
        if (verificaArrayVazio($dadosContasBancarias)) {
            $dadosBancarios = $dadosContasBancarias;
        }

        if ($dadosBancarios) {
            for ($i = 0; $i < count($dadosBancarios['idContaBancaria'][0]); $i++) {

                $idContaBancaria = $dadosBancarios['idContaBancaria'][0][$i];

                $valorGasto = $dadosBancarios['valor'][0][$i];

                $contaBancaria = $this->FinContaBancaria_model->recebeContaBancaria($idContaBancaria);

                $novoSaldo = $contaBancaria['saldo'] - $valorGasto;

                $this->FinSaldoBancario_model->atualizaSaldoBancario($idContaBancaria, $novoSaldo);
            }
        }
    }

    public function cancelaProximosAgendamentosCliente()
    {
        $this->load->model('Agendamentos_model');
        $this->load->library('agendarFrequencia');
        $this->load->model('Romaneios_model');


        $proximosAgendamentos = $this->input->post('agendamentosFuturos');

        $dataRomaneio = $this->input->post('dataRomaneio');

        $codRomaneio = $this->input->post('codRomaneio');

        foreach ($proximosAgendamentos as $proximoAgendamento) {

            $dataAgendamento = $proximoAgendamento['data_agendamento'];
            $idCliente = $proximoAgendamento['id_cliente'];
            $idSetorEmpresa = $proximoAgendamento['id_setor_empresa'];

            $this->Agendamentos_model->cancelaProximosAgendamentosCliente($dataAgendamento, $idCliente);
            $this->agendarfrequencia->cadastraAgendamentoFrequencia($idCliente, $dataRomaneio, $idSetorEmpresa);

            if ($codRomaneio) {

                $data['status'] = 1;
                $this->Romaneios_model->editaRomaneioCodigo($codRomaneio, $data);
            }
        }
    }

    public function certificadoColeta()
    {
        $this->load->library('GerarCertificadoColeta');
        $this->load->model('Certificados_coleta_model');

        $idColeta = $this->input->post('coleta') ?? $this->uri->segment(3);
        $idModelo = $this->input->post('modelo') ?? $this->uri->segment(4);
        $numero_mtr = $this->input->post('numero_mtr') ?? $this->uri->segment(6);


        $enviarEmail = $this->input->post('envia-certificado') ?? null; //Recebe o valor `email` para definir que é um envio de certificado, caso contrario somente gerar.
        $idCliente = $this->input->post('cliente') ?? null;
        $emailsCliente = $this->input->post('emails') ?? null;

        //Armazena os dados para registrar no banco o historico de certificados gerado
        $dados['id_coleta'] = $idColeta;
        $dados['id_modelo'] = $idModelo;
        $dados['numero_mtr'] = $numero_mtr;

        $codigoCertificado = $this->Certificados_coleta_model->insereCertificado($dados);


        // retorna erro caso não tenha email
        if (!$emailsCliente && $enviarEmail) {
            $this->session->set_flashdata('titulo_retorno_funcao', 'Algo deu errado!');
            $this->session->set_flashdata('tipo_retorno_funcao', 'error');
            $this->session->set_flashdata('redirect_retorno_funcao', '#');
            $this->session->set_flashdata('texto_retorno_funcao', 'Selecione algum email para enviar o certificado');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $modeloCertificado = $this->Certificados_model->recebeCertificadoId($idModelo);

        if ($modeloCertificado['personalizado']) {

            switch ($idModelo) {
                case '2':
                    $this->gerarcertificadocoleta->gerarPdfPadrao($idColeta, $idModelo, $enviarEmail, $numero_mtr, $codigoCertificado); // alterar a função para cada cliente personalizado
                    break;
                case '1':
                    $this->gerarcertificadocoleta->gerarPdfPadrao($idColeta, $idModelo, $enviarEmail, $numero_mtr, $codigoCertificado); // alterar a função para cada cliente personalizado
                    break;
                default:

                    // scripts padrão
                    $scriptsPadraoHead = scriptsPadraoHead();
                    $scriptsPadraoFooter = scriptsPadraoFooter();

                    add_scripts('header', $scriptsPadraoHead);
                    add_scripts('footer', $scriptsPadraoFooter);

                    $data['titulo'] = "Certificado não encontrado!";
                    $data['descricao'] = "Não foi possível localizar um certificado de coleta para este cliente!";

                    $this->load->view('admin/erros/erro-pdf', $data);
            }
        } else {

            $result = $this->gerarcertificadocoleta->gerarPdfPadrao($idColeta, $idModelo, $idCliente, $emailsCliente, $enviarEmail, $numero_mtr, $codigoCertificado);

            if ($result && $enviarEmail) {
                $this->session->set_flashdata('titulo_retorno_funcao', 'Sucesso!');
                $this->session->set_flashdata('tipo_retorno_funcao', 'success');
                $this->session->set_flashdata('redirect_retorno_funcao', '#');
                $this->session->set_flashdata('texto_retorno_funcao', 'Certificado enviado com sucesso!');
                redirect($_SERVER['HTTP_REFERER']);
            } else if (!$result && $enviarEmail) {
                $this->session->set_flashdata('titulo_retorno_funcao', 'Algo deu errado!');
                $this->session->set_flashdata('tipo_retorno_funcao', 'error');
                $this->session->set_flashdata('redirect_retorno_funcao', '#');
                $this->session->set_flashdata('texto_retorno_funcao', 'Falha ao enviar o certificado!');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function clienteColetas()
    {
        $id_cliente = $this->input->post('idCliente');
        $data_inicio = $this->input->post('dataInicio');
        $data_fim = $this->input->post('dataFim');
        $residuo = $this->input->post('residuo');

        $coletas = $this->Coletas_model->recebeIdColetasClientes($id_cliente, $data_inicio, $data_fim, $residuo);

        $response = array(
            'success' => false
        );

        if ($coletas) {

            $coletasId = "";

            foreach ($coletas as $col) {
                $coletasId .= $col['id'] . "-";
            }

            $response = array(
                'success' => true,
                'coletasId' => substr($coletasId, 0, -1),
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function detalhesHistoricoColeta()
    {
        $idColeta = $this->input->post('idColeta');
        $this->load->library('detalhesColeta');
        $this->load->library('formasPagamentoChaveId');
        $this->load->library('residuoChaveId');

        $historicoColeta = $this->detalhescoleta->detalheColeta($idColeta);

        if ($historicoColeta) {
            $dataColeta = date('d/m/Y', strtotime($historicoColeta['coleta']['data_coleta']));

            $response = array(
                'success' => true,
                'coleta' => $historicoColeta['coleta'],
                'dataColeta' => $dataColeta,
                'formasPagamento' => $this->formaspagamentochaveid->formaPagamentoArrayChaveId() ?? null,
                'formasTransacao' => $this->formaspagamentochaveid->formaTransacaoArrayChaveId() ?? null,
                'residuosColetados' => $this->residuochaveid->residuoArrayChaveId() ?? null
            );
        } else {

            $response = array(
                'success' => false
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function recebeColeta()
    {
        $idColeta = $this->input->post('idColeta');
        $this->load->library('detalhesColeta');
        $this->load->library('formasPagamentoChaveId');
        $this->load->library('residuoChaveId');

        // Todas as formas de pagamento disponíveis
        $todasFormasPagamento = $this->formaspagamentochaveid->formaPagamentoArray() ?? null;

        // detalhes da coleta
        $historicoColeta = $this->detalhescoleta->detalheColeta($idColeta);

        // nome de todos residuos
        $todosResiduos = $this->residuochaveid->residuoArrayNomes() ?? null;

        $responsavelColeta = json_decode($historicoColeta['coleta']['id_responsavel']);
        $residuosColetados = json_decode($historicoColeta['coleta']['residuos_coletados']);
        $quantidadeColetada = json_decode($historicoColeta['coleta']['quantidade_coletada']);
        $valoresPagos = json_decode($historicoColeta['coleta']['valor_pago']);
        $formasPagamento = json_decode($historicoColeta['coleta']['forma_pagamento']); // formas de pagamento realizada

        $todosSelects = '';

        // adiciona os labels
        $todosSelects .= '  
            <div class="row">
                <div class="col-md-5 col-12">
                    <label class="text-body-highlight fw-bold mb-2">Resíduos</label>
                </div>
                <div class="col-md-5 col-12">
                    <label class="text-body-highlight fw-bold mb-2">Quantidade Coletada</label>
                </div>
            </div>
        ';

        // Loop para cada resíduo coletado
        foreach ($residuosColetados as $index => $residuoColetado) {
            // Inicia a div de cada linha
            $selectRow = '<div class="row div-residuos-editar">';

            // cria o select para o resíduo
            $selectResiduo = '
            <div class="col-md-5 col-12 mb-4">
                <select class="form-select select2 select-residuo input-obrigatorio-coleta"> 
                    <option value="" selected disabled>Selecione</option>';

            foreach ($todosResiduos as $key => $residuo) {
                $selected = ($key == $residuoColetado) ? 'selected' : '';
                $selectResiduo .= '<option value="' . $key . '" ' . $selected . '>' . $residuo . '</option>';
            }

            // fecha o select do resíduo
            $selectResiduo .= '</select>
            <div class="d-none aviso-obrigatorio">Preencha este campo.</div>
            </div>';

            // cria o input para a quantidade coletada
            $inputQuantidade = '
            <div class="col-md-5 col-12 mb-4">
                <input type="text" class="form-control input-residuo input-obrigatorio-coleta" name="quantidade_coletada[]" value="' . $quantidadeColetada[$index] . '">
                <div class="d-none aviso-obrigatorio">Preencha este campo.</div>
            </div>';

            if ($index === 0) {
                $btnDuplicaResiduos = '
                <div class="col-md-2 mb-2 mb-4 row">
                    <button class="btn btn-phoenix-success duplicar-residuo-editar w-25">+</button>
                </div>';
            } else {
                $btnDuplicaResiduos = '
                <div class="col-md-2 mb-2 mb-4 row">
                   <button class="btn btn-phoenix-danger remover-residuo w-25">-</button>
                </div>';
            }

            // adiciona o select e o input à linha
            $selectRow .= $selectResiduo . $inputQuantidade . $btnDuplicaResiduos;

            // fecha a linha e adiciona ao todosSelects
            $selectRow .= '</div>';
            $todosSelects .= $selectRow;
        }

        $todosSelects .= '<div class="residuos-duplicados-editar"></div>';

        // Adiciona o label para as formas de pagamento
        $todosSelects .= '<hr><div class="row"><div class="col-md-5 col-12"><label class="text-body-highlight fw-bold mb-2">Formas de Pagamento</label></div><div class="col-md-5 col-12"><label class="text-body-highlight fw-bold mb-2">Valor Pago</label></div> </div>';

        // Loop para cada forma de pagamento realizada
        if (empty($formasPagamento)) {

            // Se não houver formas de pagamento, adiciona uma linha com o campo de seleção vazio
            $selectRow = '<div class="row div-pagamento-editar">';
            $selectFormaPagamento = '
                <div class="col-md-5 col-12 mb-4 div-pagamento">
                    <select class="form-select select2 select-pagamento">
                        <option value="" selected disabled>Selecione</option>';

            foreach ($todasFormasPagamento as $key => $formaPagamento) {
                $selectFormaPagamento .= '<option value="' . $key . '" data-id-tipo-pagamento="' . $formaPagamento['tipo_pagamento'] . '">' . $formaPagamento['forma_pagamento'] . '</option>';
            }

            $selectFormaPagamento .= '</select>
                <div class="d-none aviso-obrigatorio">Preencha este campo.</div>
                </div>';

            // Cria o input para o valor correspondente à forma de pagamento
            $inputValorPagamento = '
                <div class="col-md-5 col-12 mb-4 ">
                    <input type="text" class="input-pagamento form-control mascara-dinheiro" name="valor_0" value="" placeholder="Digite valor pago">
                    <div class="d-none aviso-obrigatorio">Preencha este campo.</div>
                </div>';

            // Adiciona o select e o input à linha
            $btnDuplicaPagamento = '
            <div class="col-md-2 mb-2 mb-4 row">
                <button class="btn btn-phoenix-success duplicar-pagamento-editar w-25">+</button>
            </div>';
        

            // adiciona o select e o input à linha
            $selectRow .= $selectFormaPagamento . $inputValorPagamento . $btnDuplicaPagamento;
            // Fecha a linha e adiciona ao todosSelects
            $selectRow .= '<div class="pagamentos-duplicados-editar"></div></div>';

            $todosSelects .= $selectRow;
        } else {
            // Se houver formas de pagamento, segue com o loop normalmente
            $count = 0;
            foreach ($formasPagamento as $key => $forma) {
                // Inicia a div de cada linha
                $selectRow = '<div class="row div-pagamento-editar">';

                // Cria o select para a forma de pagamento
                $selectFormaPagamento = '
                    <div class="col-md-5 col-12 mb-4 div-pagamento">
                        <select class="form-select select2 select-pagamento input-obrigatorio-coleta">
                            <option value="" selected disabled>Selecione</option>';

                // Loop para cada forma de pagamento disponível
                foreach ($todasFormasPagamento as $key => $formaPagamento) {
                    $selected = ($key == $forma) ? 'selected' : ''; // Verifica se a forma de pagamento está no array de formasPagamento
                    $selectFormaPagamento .= '<option value="' . $key . '" ' . $selected . ' data-id-tipo-pagamento="' . $formaPagamento['tipo_pagamento'] . '">' . $formaPagamento['forma_pagamento'] . '</option>';
                }

                // Fecha o select da forma de pagamento
                $selectFormaPagamento .= '</select>
                    <div class="d-none aviso-obrigatorio">Preencha este campo.</div>
                    </div>';

                // Cria o input para o valor correspondente à forma de pagamento
                $inputValorPagamento = '
                    <div class="col-md-5 col-12 mb-4 div-pagamento">
                        <input type="' . ($formaPagamento['tipo_pagamento'] == "Moeda Financeira" ? "text" : "number") . '" class="form-control mascara-dinheiro input-pagamento input-obrigatorio-coleta" name="valor_' . $forma . '" value="' . $valoresPagos[$count] . '">
                        <div class="d-none aviso-obrigatorio">Preencha este campo.</div>
                    </div>';

                // Adiciona o select e o input à linha
                if ($count === 0) {
                    $btnDuplicaPagamento = '
                    <div class="col-md-2 mb-2 mb-4 row">
                        <button class="btn btn-phoenix-success duplicar-pagamento-editar w-25">+</button>
                    </div>';
                } else {
                    $btnDuplicaPagamento = '
                    <div class="col-md-2 mb-2 mb-4 row">
                       <button class="btn btn-phoenix-danger remover-pagamento w-25">-</button>
                    </div>';
                }
    
                // adiciona o select e o input à linha
                $selectRow .= $selectFormaPagamento . $inputValorPagamento . $btnDuplicaPagamento;
                // Fecha a linha e adiciona ao todosSelects
                $selectRow .= '</div>';

                $todosSelects .= $selectRow;
                
                $count++;
            }

            $todosSelects .= '<div class="pagamentos-duplicados-editar"></div>';

        }

        if ($historicoColeta) {
            $dataColeta = date('d/m/Y', strtotime($historicoColeta['coleta']['data_coleta']));

            $response = array(
                'success' => true,
                'coleta' => $historicoColeta['coleta'],
                'dataColeta' => $dataColeta,
                'responsavel' => $responsavelColeta,
                'formasPagamento' => $todasFormasPagamento,
                'residuosColetados' => $todosSelects ?? null
            );
        } else {
            $response = array(
                'success' => false
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function deletaColeta()
    {
        $id = $this->input->post('idColeta');

        $retorno = $this->Coletas_model->deletaColeta($id);

        if ($retorno) { // alterou status

            $response = array(
                'success' => true,
                'title' => "Sucesso!",
                'message' => 'Coleta deletada com sucesso!',
                'type' => "success"
            );
        } else { // erro ao deletar

            $response = array(
                'success' => false,
                'title' => "Algo deu errado!",
                'message' => 'Não foi possível deletar a coleta.',
                'type' => "error"
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}

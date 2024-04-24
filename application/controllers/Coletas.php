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
    }

    public function cadastraColeta()
    {
        $this->load->library('agendarFrequencia');
        $this->load->model('Romaneios_model');
        $this->load->model('Agendamentos_model');

        $payload = $this->input->post('clientes');
        $codRomaneio = $this->input->post('codRomaneio');
        $idResponsavel = $this->input->post('idResponsavel');
        $idSetorEmpresa = $this->input->post('idSetorEmpresa'); // Recebe o id do setor responsavel pelo agendamento
        $dataRomaneio = $this->input->post('dataRomaneio');

        $idColeta = $this->input->post('idColeta');

        if ($payload) {
            foreach ($payload as $cliente) :
                $dados = array(
                    'id_cliente' => $cliente['idCliente'],
                    'id_responsavel' => $idResponsavel,
                    'residuos_coletados' => json_encode($cliente['residuos'] ?? ""),
                    'forma_pagamento' => json_encode($cliente['pagamento'] ?? ""),
                    'quantidade_coletada' => json_encode($cliente['qtdColetado'] ?? ""),
                    'valor_pago' => json_encode($cliente['valor'] ?? ""),
                    'data_coleta' => $dataRomaneio,
                    'id_empresa' => $this->session->userdata('id_empresa'),
                );

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

                if ($inseriuColeta && $cliente['coletado']) {
                    $valor['status'] = 1;
                    $this->Agendamentos_model->editaAgendamentoData($cliente['idCliente'], $dataRomaneio, $valor, $idSetorEmpresa);
                }


                !$idColeta ? $this->agendarfrequencia->cadastraAgendamentoFrequencia($cliente['idCliente'], $dataRomaneio, $idSetorEmpresa) : "";

            endforeach;

            $data['status'] = 1;
            $this->Romaneios_model->editaRomaneioCodigo($codRomaneio, $data);

            $response = array(
                'success' => true,
                'message' => $idColeta ? 'Coleta editada com Sucesso!' : 'Coleta(s) cadastrada(s) com sucesso!'
            );
        } else {

            $response = array(
                'success' => false,
                'message' => 'Erro ao cadastrar a coleta.'
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function certificadoColeta()
    {
        $this->load->library('GerarCertificadoColeta');

        $idColeta = $this->uri->segment(3) ?? null;
        $idModelo = $this->uri->segment(4) ?? null;

        $modeloCertificado =  $this->Certificados_model->recebeCertificadoId($idModelo);

        if ($modeloCertificado['personalizado']) {

            switch ($idModelo) {
                case '2':
                    $this->gerarcertificadocoleta->gerarPdfPadrao($idColeta, $idModelo); // alterar a função para cada cliente personalizado
                    break;
                case '1':
                    $this->gerarcertificadocoleta->gerarPdfPadrao($idColeta, $idModelo); // alterar a função para cada cliente personalizado
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

            $this->gerarcertificadocoleta->gerarPdfPadrao($idColeta, $idModelo);
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
                $coletasId .=  $col['id'] . "-";
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

        $historicoColeta = $this->detalhescoleta->detalheColeta($idColeta);

        $todosResiduos = $this->residuochaveid->residuoArrayNomes() ?? null;

        $responsavelColeta = json_decode($historicoColeta['coleta']['id_responsavel']);
        $residuosColetados = json_decode($historicoColeta['coleta']['residuos_coletados']);
        $quantidadeColetada = json_decode($historicoColeta['coleta']['quantidade_coletada']);
        $valoresPagos = json_decode($historicoColeta['coleta']['valor_pago']);
        // Todas as formas de pagamento disponíveis
        $todasFormasPagamento = $this->formaspagamentochaveid->formaPagamentoArray() ?? null;

        // echo "<pre>"; print_r($todasFormasPagamento); exit;

        // Formas de pagamento realizadas
        $formasPagamento = json_decode($historicoColeta['coleta']['forma_pagamento']);

        // Inicializa a variável para armazenar todos os selects e inputs
        $todosSelects = '';

        // Adiciona o label para os resíduos
        $todosSelects .= '<div class="row"><div class="col-6"><label class="text-body-highlight fw-bold mb-2">Resíduos</label></div><div class="col-6"><label class="text-body-highlight fw-bold mb-2">Quantidade Coletada</label></div> </div>';

        // Loop para cada resíduo coletado
        foreach ($residuosColetados as $index => $residuoColetado) {
            // Inicia a div de cada linha
            $selectRow = '<div class="row">';

            // Cria o select para o resíduo
            $selectResiduo = '
            <div class="col-6 mb-4">
                <select class="form-select select2 select-residuo"> 
                    <option value="" selected disabled>Selecione</option>';

            foreach ($todosResiduos as $key => $residuo) {
                $selected = ($key == $residuoColetado) ? 'selected' : '';
                $selectResiduo .= '<option value="' . $key . '" ' . $selected . '>' . $residuo . '</option>';
            }

            // Fecha o select do resíduo
            $selectResiduo .= '</select>
            </div>';

            // Cria o input para a quantidade coletada
            $inputQuantidade = '
            <div class="col-6 mb-4">
                <input type="text" class="form-control input-quantidade" name="quantidade_coletada[]" value="' . $quantidadeColetada[$index] . '">
            </div>';

            // Adiciona o select e o input à linha
            $selectRow .= $selectResiduo . $inputQuantidade;

            // Fecha a linha e adiciona ao todosSelects
            $selectRow .= '</div>';
            $todosSelects .= $selectRow;
        }

        // Adiciona o label para as formas de pagamento
        $todosSelects .= '<hr><div class="row"><div class="col-6"><label class="text-body-highlight fw-bold mb-2">Formas de Pagamento</label></div><div class="col-6"><label class="text-body-highlight fw-bold mb-2">Valor Pago</label></div> </div>';

        // Loop para cada forma de pagamento realizada

        if (empty($formasPagamento)) {
            // Se não houver formas de pagamento, adiciona uma linha com o campo de seleção vazio
            $selectRow = '<div class="row">';
            $selectFormaPagamento = '
                <div class="col-6 mb-4">
                    <select class="form-select select2">
                        <option value="" selected disabled>Selecione</option>';
            foreach ($todasFormasPagamento as $key => $formaPagamento) {
                $selectFormaPagamento .= '<option value="' . $key . '" data-id-tipo-pagamento="' . $formaPagamento['tipo_pagamento'] . '">' . $formaPagamento['forma_pagamento'] . '</option>';
            }
            $selectFormaPagamento .= '</select>
                </div>';
            // Cria o input para o valor correspondente à forma de pagamento
            $inputValorPagamento = '
                <div class="col-6 mb-4">
                    <input type="text" class="form-control mascara-dinheiro" name="valor_0" value="">
                </div>';

            // Adiciona o select e o input à linha
            $selectRow .= $selectFormaPagamento . $inputValorPagamento;
            // Fecha a linha e adiciona ao todosSelects
            $selectRow .= '</div>';
            $todosSelects .= $selectRow;
        } else {
            // Se houver formas de pagamento, segue com o loop normalmente
            $count = 0;
            foreach ($formasPagamento as $key => $forma) {
                // Inicia a div de cada linha
                $selectRow = '<div class="row">';
                // Cria o select para a forma de pagamento
                $selectFormaPagamento = '
                    <div class="col-6 mb-4 div-pagamento">
                        <select class="form-select select2 select-pagamento">
                            <option value="" selected disabled>Selecione</option>';
                // Loop para cada forma de pagamento disponível
                foreach ($todasFormasPagamento as $key => $formaPagamento) {
                    $selected = ($key == $forma) ? 'selected' : ''; // Verifica se a forma de pagamento está no array de formasPagamento
                    $selectFormaPagamento .= '<option value="' . $key . '" ' . $selected . ' data-id-tipo-pagamento="' . $formaPagamento['tipo_pagamento'] . '">' . $formaPagamento['forma_pagamento'] . '</option>';
                }
                // Fecha o select da forma de pagamento
                $selectFormaPagamento .= '</select>
                    </div>';
                // Cria o input para o valor correspondente à forma de pagamento
                $inputValorPagamento = '
                    <div class="col-6 mb-4 div-pagamento">
                        <input type="' . ($formaPagamento['tipo_pagamento'] == "Moeda Financeira" ? "text" : "number") . '" class="form-control mascara-dinheiro input-pagamento" name="valor_' . $forma . '" value="' . $valoresPagos[$count] . '">
                    </div>';
                // Adiciona o select e o input à linha
                $selectRow .= $selectFormaPagamento . $inputValorPagamento;
                // Fecha a linha e adiciona ao todosSelects
                $selectRow .= '</div>';
                $todosSelects .= $selectRow;
                $count++;
            }
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
}

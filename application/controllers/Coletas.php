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
        $dataRomaneio = $this->input->post('dataRomaneio');

        if ($payload) {
            foreach ($payload as $cliente) :
                $dados = array(
                    'id_cliente' => $cliente['idCliente'],
                    'id_responsavel' => $idResponsavel,
                    'residuos_coletados' => json_encode($cliente['residuos']),
                    'forma_pagamento' => json_encode($cliente['pagamento']),
                    'quantidade_coletada' => json_encode($cliente['qtdColetado']),
                    'valor_pago' => json_encode($cliente['valor']),
                    'observacao' => $cliente['obs'],
                    'coletado' => $cliente['coletado'],
                    'data_coleta' => $dataRomaneio,
                    'cod_romaneio' => $codRomaneio,
                    'id_empresa' => $this->session->userdata('id_empresa'),
                );

                $inseriuColeta = $this->Coletas_model->insereColeta($dados);

                if ($inseriuColeta && $cliente['coletado']) {
                    $valor['status'] = 1;
                    $this->Agendamentos_model->editaAgendamentoData($cliente['idCliente'], $dataRomaneio, $valor);
                }

                $this->agendarfrequencia->cadastraAgendamentoFrequencia($cliente['idCliente'], $dataRomaneio);

            endforeach;

            $data['status'] = 1;
            $this->Romaneios_model->editaRomaneioCodigo($codRomaneio, $data);

            $response = array(
                'success' => true,
                'message' => 'Coleta(s) cadastrada(s) com sucesso.'
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

    public function detalhesHistoricoColeta()
    {
        $idColeta = $this->input->post('idColeta');
        $this->load->library('detalhesColeta');

        $historicoColeta = $this->detalhescoleta->detalheColeta($idColeta);

        if ($historicoColeta) {
            $dataColeta = date('d/m/Y', strtotime($historicoColeta['coleta']['data_coleta']));

            $response = array(
                'success' => true,
                'coleta' => $historicoColeta['coleta'],
                'dataColeta' => $dataColeta,
                'formasPagamento' => $historicoColeta['formasPagamento'] ?? null,
                'residuosColetados' => $historicoColeta['residuos'] ?? null
            );
        } else {

            $response = array(
                'success' => false
            );
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}

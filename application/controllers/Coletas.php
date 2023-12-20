<?php
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
        $this->load->library('agendarfrequencia'); // Use o nome minúsculo, pois CodeIgniter faz a instância ser case-insensitive
        $this->load->model('Romaneios_model');
        $this->load->model('Agendamentos_model');
    
        $payload = $this->input->post('clientes');
        $codRomaneio = $this->input->post('codRomaneio');
        $idResponsavel = $this->input->post('idResponsavel');
        $romaneio = $this->Romaneios_model->recebeRomaneioCod($codRomaneio);
    
        $periodo = 'Tarde';
    
        foreach ($payload as $cliente) {
            $dados = array(
                'id_cliente' => $cliente['idCliente'],
                'id_responsavel' => $idResponsavel,
                'residuos_coletados' => json_encode($cliente['residuos']),
                'forma_pagamento' => json_encode($cliente['pagamento']),
                'quantidade_coletada' => json_encode($cliente['qtdColetado']),
                'valor_pago' => json_encode($cliente['valor']),
                'observacao' => $cliente['obs'],
                'coletado' => $cliente['coletado'],
                'data_coleta' => $romaneio['data_romaneio'],
                'cod_romaneio' => $codRomaneio,
                'id_empresa' => $this->session->userdata('id_empresa'),
            );
    
            $this->agendarfrequencia->cadastraAgendamentoFrequencia($cliente['idCliente'], $romaneio['data_romaneio'], null, $periodo, $cliente['coletado']);

            if($cliente['coletado'] == 1){
                $this->Agendamentos_model->editaAgendamentoData($cliente['idCliente'], $romaneio['data_romaneio'], $cliente['coletado']);
            }

            $retorno = $this->Coletas_model->insereColeta($dados);
    
            $data['status'] = 1;
    
            $this->Romaneios_model->editaRomaneioCodigo($codRomaneio, $data);
    
            if (!$retorno) {
                $response = array(
                    'success' => false,
                    'message' => 'Erro ao cadastrar a coleta.'
                );
            }
        }
    
        if (empty($response)) {
            $response = array(
                'success' => true,
                'message' => 'Coleta(s) cadastrada(s) com sucesso.'
            );
        }
    
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    
}

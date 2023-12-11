<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coletas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // INICIO controle sessão
        //$this->load->library('Controle_sessao');
        //$res = $this->controle_sessao->controle();
        //if ($res == 'erro') {
          //  redirect('login/erro', 'refresh');
        //}
        // FIM controle sessão
        $this->load->model('Coletas_model');
        
    }

    public function cadastraColeta()
    {
        $payload = $this->input->post('clientes');
        $codRomaneio = $this->input->post('codRomaneio');
        $idMotorista = $this->input->post('idMotorista');
    
        $response = array(); 
    
        foreach ($payload as $cliente) {
            $dados = array(
                'id_cliente' => $cliente['idCliente'],
                'id_motorista' => $idMotorista,
                'residuos_coletados' => json_encode($cliente['residuos']),
                'forma_pagamento' => $cliente['pagamento'],
                'quantidade_coletada' => json_encode($cliente['qtdColetado']),
                'valor_pago' => $cliente['valorPago'],
                'observacao' => $cliente['obs'],
                'coletado' => $cliente['coletado'],
                'data_coleta' => date('Y-m-d H:i:s'), 
                'cod_romaneio' => $codRomaneio, 
            );
    
            $retorno = $this->Coletas_model->insereColeta($dados);
    
            if (!$retorno) {
                $response[] = array(
                    'success' => false,
                    'message' => 'Erro ao cadastrar a coleta.'
                );
            }
        }
    
        if (empty($response)) {
            $response[] = array(
                'success' => true,
                'message' => 'Coleta(s) cadastrada(s) com sucesso.'
            );
        }
    
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    
    

}
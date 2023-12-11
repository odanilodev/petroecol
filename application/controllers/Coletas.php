<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coletas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // INICIO controle sessão
        $this->load->library('Controle_sessao');
        $res = $this->controle_sessao->controle();
        if ($res == 'erro') {
            redirect('login/erro', 'refresh');
        }
        // FIM controle sessão
        $this->load->model('Coletas_model');
        
    }


    public function cadastraColeta()
    {
        $clientes = $this->input->post('clientes'); // Recebe a lista de clientes
    
        $response = array();
    
        foreach ($clientes as $cliente) {
            $dados['id_cliente'] = $cliente['id_cliente'];
            $dados['residuos_coletados'] = $cliente['residuos_coletados'];
            $dados['forma_pagamento'] = $cliente['forma_pagamento'];
            $dados['quantidade_coletada'] = $cliente['quantidade_coletada'];
            $dados['valor_pago'] = $cliente['valor_pago'];
            $dados['observacao'] = $cliente['observacao'];
            $dados['data_coleta'] = $cliente['data_coleta'];
            $dados['coletado'] = $cliente['coletado'];

            $retorno = $this->Coletas_model->insereColeta($dados);
    
            if ($retorno) {
                $response[] = array(
                    'success' => true,
                    'message' => 'Coleta cadastrada com sucesso.'
                );
            } else {
                $response[] = array(
                    'success' => false,
                    'message' => 'Erro ao cadastrar a coleta.'
                );
            }
        }


    
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    

}
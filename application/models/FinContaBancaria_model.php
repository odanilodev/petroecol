<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinContaBancaria_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeContasBancarias()
    {
        $this->db->order_by('apelido', 'DESC');
        $this->db->join('fin_saldo_bancario SB', 'SB.id_conta_bancaria = CB.id', 'left');
        $this->db->where('CB.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('status', 1);
        $query = $this->db->get('fin_contas_bancarias CB');

        return $query->result_array();
    }

    public function recebeContaBancaria($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_contas_bancarias');

        return $query->row_array();
    }

    public function recebeApelidoContaBancaria($apelido, $id)
    {
        $this->db->where('apelido', $apelido);
        $this->db->where('id <>', $id);
        $this->db->where('status', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_contas_bancarias');

        return $query->row_array();
    }

    public function insereContaBancaria($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('fin_contas_bancarias', $dados);

        // Obtém o ID criado pela inserção
        $inserted_id = $this->db->insert_id();

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($inserted_id);
        }

        // Retorna um array contendo o ID criado e um indicador de sucesso da operação
        return array(
            'success' => $this->db->affected_rows() > 0,
            'inserted_id' => $inserted_id
        );
    }

    public function editaContaBancaria($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('fin_contas_bancarias', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaContaBancaria($id)
    {
        $this->db->trans_start(); // Inicia uma transação
    
        // Define o status da conta bancária como 0
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->set('status', 0);
        $this->db->update('fin_contas_bancarias');
    
        // Exclui o saldo correspondente na tabela fin_saldo_bancario
        $this->db->set('status', 0);
        $this->db->update('fin_saldo_bancario');
    
        // Verifica se a operação foi bem sucedida e insere um log
        if ($this->db->affected_rows() > 0) {
            $this->Log_model->insereLog($id);
        }
    
        $this->db->trans_complete(); // Completa a transação
    
        // Retorna true se a operação foi bem sucedida
        return $this->db->trans_status();
    }

    public function verificaContaBancariaFluxo($id)
    {
        $this->db->where('id_conta_bancaria', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->get('fin_fluxo');

        return $this->db->affected_rows() > 0;
    }

}

<?php
defined('BASEPATH') or exit('No direct script access allowed');


class FinContasRecorrentes_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeContasRecorrentes()
    {
        $this->db->select('CR.*, CR.id as ID_CONTA, DF.nome as RECEBIDO, M.nome as MICRO, ci_clientes.nome as CLIENTE, SE.nome as SETOR');
        $this->db->from('fin_contas_pagar_recorrentes CR');
        $this->db->join('fin_dados_financeiros DF', 'CR.id_dado_financeiro = DF.id', 'LEFT');
        $this->db->join('fin_micros M', 'CR.id_micro = M.id', 'LEFT');
        $this->db->join('ci_setores_empresa SE', 'CR.id_setor_empresa = SE.id', 'LEFT');

        $this->db->join('ci_clientes', 'CR.id_cliente = ci_clientes.id', 'left'); // recebido/pago (cliente)

        $this->db->where('CR.id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeContaRecorrentes($id)
    {
        $this->db->select('CR.*, DF.nome as RECEBIDO, DF.id as ID_RECEBIDO, M.id as ID_MICRO, M.id_macro, DF.id_grupo as GRUPO_CREDOR, ci_clientes.nome as CLIENTE, ci_clientes.id as ID_CLIENTE');
        $this->db->from('fin_contas_pagar_recorrentes CR');
        $this->db->join('fin_dados_financeiros DF', 'CR.id_dado_financeiro = DF.id', 'LEFT');
        $this->db->join('fin_micros M', 'CR.id_micro = M.id', 'LEFT');

        $this->db->join('ci_clientes', 'CR.id_cliente = ci_clientes.id', 'left'); // recebido/pago (cliente)

        $this->db->where('CR.id', $id);
        $this->db->where('CR.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->row_array();
    }

    public function insereConta($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('fin_contas_pagar_recorrentes', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaConta($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('fin_contas_pagar_recorrentes', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaConta($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('fin_contas_pagar_recorrentes');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeVariasContasRecorrentes($ids)
    {
        $this->db->select('CR.*, DF.nome as RECEBIDO, DF.id as ID_RECEBIDO, M.id as ID_MICRO, M.id_macro, DF.id_grupo as GRUPO_CREDOR, ci_clientes.nome as CLIENTE, SE.nome as SETOR');
        $this->db->from('fin_contas_pagar_recorrentes CR');
        $this->db->join('fin_dados_financeiros DF', 'CR.id_dado_financeiro = DF.id', 'LEFT');
        $this->db->join('fin_micros M', 'CR.id_micro = M.id', 'LEFT');
        $this->db->join('ci_setores_empresa SE', 'CR.id_setor_empresa = SE.id', 'LEFT');

        $this->db->join('ci_clientes', 'CR.id_cliente = ci_clientes.id', 'left'); // recebido/pago (cliente)

        $this->db->where_in('CR.id', $ids);
        $this->db->where('CR.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }

}
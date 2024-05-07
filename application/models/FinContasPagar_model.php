<?php
defined('BASEPATH') or exit('No direct script access allowed');


class FinContasPagar_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeContasPagar($dataInicio, $dataFim, $status)
    {
        $this->db->select('CP.*, DF.nome as RECEBIDO');
        $this->db->from('fin_contas_pagar CP');
        $this->db->join('fin_dados_financeiros DF', 'CP.id_dado_financeiro = DF.id', 'LEFT');
        $this->db->where('CP.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('CP.data_vencimento <=', $dataFim);
        $this->db->where('CP.data_vencimento >=', $dataInicio);

        // Verifica se o tipo de movimentação não é 'ambas', para adicionar uma restrição
        if ($status !== 'ambas') {
            $this->db->where('CP.status', $status);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeContaPagar($id)
    {
        $this->db->select('CP.*, DF.nome as RECEBIDO, DF.id_grupo as GRUPO_CREDOR');
        $this->db->from('fin_contas_pagar CP');
        $this->db->join('fin_dados_financeiros DF', 'CP.id_dado_financeiro = DF.id', 'LEFT');
        $this->db->where('CP.id', $id);
        $this->db->where('CP.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->row_array();
    }

    public function insereConta($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('fin_contas_pagar', $dados);

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
        $this->db->update('fin_contas_pagar', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaConta($id)
    {
        $this->db->where('id', $id);
        $this->db->where('status', 0);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('fin_contas_pagar');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

}
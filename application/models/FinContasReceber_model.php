<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinContasReceber_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeContasReceber()
    {
        $this->db->select('CR.*, DF.nome as RECEBIDO');
        $this->db->from('fin_contas_receber CR');
        $this->db->join('fin_dados_financeiros DF', 'CR.id_dado_financeiro = DF.id', 'left');
        $this->db->where('CR.id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();
        return $query->result_array();
    }

    public function insereContasReceber($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('fin_contas_receber', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

}

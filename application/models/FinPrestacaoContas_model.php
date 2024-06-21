<?php
defined('BASEPATH') or exit('No direct script access allowed');


class FinPrestacaoContas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebePrestacaoContas()
    {
        $this->db->select('PC.*, F.id as ID_FUNCIONARIO, F.nome as FUNCIONARIO, F.saldo as SALDO_FUNCIONARIO');
        $this->db->from('fin_prestacao_contas PC');
        $this->db->join('ci_funcionarios F', 'PC.id_funcionario = F.id', 'LEFT');
        $this->db->where('PC.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function inserePrestacaoContas($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        
        $this->db->insert('fin_prestacao_contas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

}

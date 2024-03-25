<?php
defined('BASEPATH') or exit('No direct script access allowed');


class FinContasPagar_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeContasPagar()
    {
        $this->db->select('CP.*, DF.nome as RECEBIDO');
        $this->db->from('fin_contas_pagar CP');
        $this->db->join('fin_dados_financeiros DF', 'CP.id_dado_financeiro = DF.id', 'LEFT');
        $this->db->where('CP.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }
}
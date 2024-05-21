<?php
defined('BASEPATH') or exit('No direct sCPipt access allowed');

class FinDre_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }
 
    public function recebeDre($dataInicio, $dataFim)
    {
        $this->db->select('MAX(F.id) as ID_DRE, MAX(F.id_macro) as ID_MACRO, M.nome as MACRO, SUM(F.valor) as total_pago');
        $this->db->from('fin_fluxo F');
        $this->db->join('fin_macros M', 'F.id_macro = M.id', 'left');
        $this->db->join('fin_micros MC', 'F.id_micro = MC.id', 'left');
        $this->db->where('F.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('F.movimentacao_tabela', 0);
        $this->db->group_by('M.nome');
        $this->db->order_by('MACRO', 'ASC');
        
        $this->db->where('F.data_movimentacao <=', $dataFim);
        $this->db->where('F.data_movimentacao >=', $dataInicio);

        $query = $this->db->get();
        return $query->result_array();

    }

    public function visualizarMicrosDre($idMacro)
    {
        $this->db->select('MC.nome, M.nome as MACRO');
        $this->db->from('fin_fluxo F');
        $this->db->join('fin_macros M', 'F.id_macro = M.id', 'left');
        $this->db->join('fin_micros MC', 'F.id_micro = MC.id', 'left');
        $this->db->where('F.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('F.id_macro', $idMacro);
        $this->db->group_by('MC.nome');
        $query = $this->db->get();
        return $query->result_array();

    }

  
}

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
        $this->db->select('M.nome as MACRO, SUM(CP.valor_pago) as total_pago');
        $this->db->from('fin_contas_pagar CP');
        $this->db->join('fin_macros M', 'CP.id_macro = M.id', 'left');
        $this->db->join('fin_fluxo F', 'CP.id = F.id_vinculo_conta', 'left');
        $this->db->where('CP.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->group_by('M.nome');
        $this->db->order_by('MACRO', 'ASC');
        
        $this->db->where('F.data_movimentacao <=', $dataFim);
        $this->db->where('F.data_movimentacao >=', $dataInicio);

        $query = $this->db->get();
        return $query->result_array();

    }

  
}

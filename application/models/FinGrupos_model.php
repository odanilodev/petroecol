<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinGrupos_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeGrupos()
    {
        $this->db->order_by('nome', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_grupos');
    
        return $query->result_array();
    }

}

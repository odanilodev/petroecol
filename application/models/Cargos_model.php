<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cargos_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeCargos()
    {
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_cargos');

        return $query->result_array();

    }

}
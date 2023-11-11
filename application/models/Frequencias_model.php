<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Frequencias_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeFrequenciasColeta()
    {
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_frequencia_coleta');
        return $query->result_array();
    }

}

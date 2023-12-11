<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Permissao_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeClientesPermissao($componente)
    {
        $this->db->where('componente', $componente);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_permissao');
        return $query->row_array();
    }
}

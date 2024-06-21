<?php
defined('BASEPATH') or exit('No direct script access allowed');


class FinTiposCustos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeTiposCustos()
    {
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_tipos_custos');

        return $query->result_array();
    }

}

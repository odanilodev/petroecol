<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinBancosFinanceiros_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeBancosFinanceiros()
    {
        $query = $this->db->get('fin_bancos_financeiros');

        return $query->result_array();
    }

}

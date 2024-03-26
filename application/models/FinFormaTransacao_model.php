<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinFormaTransacao_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeFormasTransacao()
    {
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_forma_transacao');

        return $query->result_array();
    }

}
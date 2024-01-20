<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TokenZap_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeTokenZap($tipo, $zap)
    {
        $this->db->where('tipo', $tipo);
        $this->db->where('status', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_tokens_zap');

        $this->Log_model->insereLog($zap);

        return $query->row_array();
    }
}

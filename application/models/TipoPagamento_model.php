<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TipoPagamento_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeTiposPagamentos()
    {
        $this->db->order_by('nome', 'DESC');
        $query = $this->db->get('ci_tipo_pagamento');

        return $query->result_array();
    }
}

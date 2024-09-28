<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UnidadesMedidas_model extends CI_Model
{
    public function recebeUnidadesMedidas()
    {
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_unidades_medidas');

        return $query->result_array();
    }
}

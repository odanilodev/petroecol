<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GruposEmailCliente_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeGruposEmail()
    {
        $this->db->order_by('grupo', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_grupos_emails');

        return $query->result_array();
    }

    public function recebeGrupoEmail($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_grupos');

        return $query->row_array();
    }


}

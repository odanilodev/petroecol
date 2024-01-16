<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ComodatoCliente_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeComodatosCliente($id)
    {
        $this->db->where('id_cliente', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_comodato_cliente');

        return $query->result_array();
    }

    public function recebeComodato($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_comodato_cliente');

        return $query->row_array();
    }

    public function insereComodato($dados)
    {
        $this->db->insert('ci_comodato_cliente', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaComodato($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_comodato_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

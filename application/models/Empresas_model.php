<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Empresas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeEmpresas()
    {
        $this->db->order_by('nome', 'DESC');
        $query = $this->db->get('ci_empresas');
        return $query->result_array();
    }

    public function recebeEmpresa($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('ci_empresas');
        return $query->row_array();
    }

    public function insereEmpresa($dados)
    {
        $this->db->insert('ci_empresas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaEmpresa($id, $dados)
    {
        $this->db->where('id', $id);
        $this->db->update('ci_empresas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaEmpresa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ci_empresas');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}
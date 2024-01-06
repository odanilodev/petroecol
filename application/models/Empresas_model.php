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
        $this->db->where('status', 1);
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

    public function recebeDadosMaster($dados)
    {   
        $this->db->select($dados);
        $this->db->where('id', 1);
        $query = $this->db->get('ci_empresas');

        return $query->row()->$dados;
    }

    public function insereEmpresa($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_empresas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaEmpresa($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->update('ci_empresas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaEmpresa($id)
    {
        $dados['status'] = 3;
        $this->db->where('id', $id);
        $this->db->update('ci_empresas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

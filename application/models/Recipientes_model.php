<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recipientes_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeRecipientes()
    {
        $this->db->order_by('nome_recipiente', 'DESC');
        $query = $this->db->get('ci_recipientes');
        return $query->result_array();
    }

    public function recebeRecipiente($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('ci_recipientes');
        return $query->row_array();
    }

    public function recebeRecipienteNome($nome)
    {
        $this->db->where('nome_recipiente', $nome);
        $query = $this->db->get('ci_recipientes');

        return $query->row_array();
    }

    public function insereRecipiente($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_recipientes', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaRecipiente($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->update('ci_recipientes', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaRecipiente($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_recipientes');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

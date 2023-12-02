<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recipientes_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeRecipientes($limit, $page, $count = null)
    {
        if ($count) {
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

            $query = $this->db->get('ci_recipientes');
            return $query->num_rows();
        }

        $offset = ($page - 1) * $limit;
        $this->db->order_by('nome_recipiente', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->limit($limit, $offset);
        $query = $this->db->get('ci_recipientes');
        return $query->result_array();
    }

    public function recebeRecipiente($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_recipientes');
        return $query->row_array();
    }

    public function recebeRecipienteNome($nome, $volume, $unidade_peso)
    {
        $this->db->where('nome_recipiente', $nome);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('volume_suportado', $volume);
        $this->db->where('unidade_peso', $unidade_peso);
        $query = $this->db->get('ci_recipientes');

        return $query->row_array();
    }

    public function recebeTodosRecipientes()
    {
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_recipientes');

        return $query->result_array();
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

    public function verificaRecipienteCliente($id)
    {
        $this->db->where('id_recipiente', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->get('ci_recipiente_cliente');

        return $this->db->affected_rows() > 0;
    }
}
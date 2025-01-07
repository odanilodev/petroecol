<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trajetos_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeTrajetos($cookie_filtro_clientes, $limit, $page, $count = null)
    {
        $filtro = json_decode($cookie_filtro_clientes, true);

        $this->db->order_by('nome', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        if ($filtro['nome'] ?? false) {
            $nome = $filtro['nome'];
            $this->db->where("LOWER(nome) COLLATE utf8mb4_unicode_ci LIKE LOWER('%$nome%')");
        }

        if (!$count) {
            $offset = ($page - 1) * $limit;
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get('ci_trajetos');

        if ($count) {
            return $query->num_rows();
        }

        return $query->result_array();
    }

    public function recebeTodosTrajetos()
    {
        $this->db->order_by('nome', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_trajetos');
        return $query->result_array();
    }

    public function recebeTrajeto($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_trajetos');

        return $query->row_array();
    }

    public function recebeTrajetoNome($nome, $id)
    {
        $this->db->where('nome', $nome);
        $this->db->where('id <>', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_trajetos');

        return $query->row_array();
    }

    public function insereTrajeto($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_trajetos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaTrajeto($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_trajetos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaTrajeto($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_trajetos');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Clientes_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeClientes($limit, $page, $count = null)
    {
        if ($count) {
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
            $query = $this->db->get('ci_clientes');
            return $query->num_rows();
        }

        $offset = ($page - 1) * $limit;
        $this->db->order_by('nome', 'DESC');
        $this->db->where('status', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->limit($limit, $offset);
        $query = $this->db->get('ci_clientes');

        return $query->result_array();
    }

    public function recebeCliente($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_clientes');

        return $query->row_array();
    }

    public function insereCliente($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_clientes', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaCliente($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_clientes', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaCliente($id)
    {
        $dados['status'] = 3;
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_clientes', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaEtiquetaCliente($id)
    {
        $this->db->where('id_cliente', $id);
        $this->db->delete('ci_etiqueta_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

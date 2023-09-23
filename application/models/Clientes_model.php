<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model {

    public function recebeClientes()
    {
        $this->db->order_by('nome', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
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

    public function exibeClientes()
    {
        $query = $this->db->get('ci_clientes');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        return $query->result_array();
    }

    public function insereCliente($dados)
    {
        $this->db->insert('ci_clientes', $dados);
        return $this->db->affected_rows() > 0;
        
    }

    public function editaCliente($id, $dados)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_clientes', $dados);
        return $this->db->affected_rows() > 0;
    }

    public function deletaCliente($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_clientes');

        return $this->db->affected_rows() > 0;
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RecipienteCliente_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeRecipientesClientes()
    {
        $this->db->select('RC.*, C.*, R.*');
        $this->db->from('ci_recipiente_cliente RC');
        $this->db->join('ci_clientes C', 'RC.id_cliente = C.id', 'inner');
        $this->db->join('ci_recipientes R', 'RC.id_recipiente = R.id', 'inner');
        $this->db->where('RC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeRecipiente($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('ci_recipiente_cliente');
        return $query->row_array();
    }

    public function recebeRecipienteCliente($id)
    {
        $this->db->select('RC.*, C.nome, R.nome_recipiente');
        $this->db->from('ci_recipiente_cliente RC');
        $this->db->join('ci_clientes C', 'RC.id_cliente = C.id', 'inner');
        $this->db->join('ci_recipientes R', 'RC.id_recipiente = R.id', 'inner');
        $this->db->where('RC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('RC.id_cliente', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeIdRecipienteCliente($id, $id_cliente)
    {
        $this->db->select('RC.*, R.nome_recipiente');
        $this->db->from('ci_recipiente_cliente RC');
        $this->db->join('ci_recipientes R', 'RC.id_recipiente = R.id', 'inner');
        $this->db->where('RC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('RC.id_cliente', $id_cliente);
        $this->db->where('RC.id_recipiente', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function insereRecipienteCliente($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_recipiente_cliente', $dados);

        $inseridoId = $this->db->insert_id(); // Pega o ID inserido

        if ($inseridoId) {
            $this->Log_model->insereLog($inseridoId);
        }

        return $inseridoId; // Retorna o ID inserido ou 0 se não foi inserido
    }

    public function deletaRecipienteCliente($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_recipiente_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

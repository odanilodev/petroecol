<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmailCliente_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeEmailClientes()
    {
        $this->db->select('EC.*, C.nome, EC.nome');
        $this->db->from('ci_emails_cliente EC');
        $this->db->join('ci_clientes C', 'EC.id_cliente = C.id', 'inner');
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeEmailCliente($id)
    {
        $this->db->select('EC.*, GE.grupo, GE.id as ID_GRUPO');
        $this->db->from('ci_emails_cliente EC');
        $this->db->join('ci_grupos_emails GE', 'EC.id_grupo = GE.id', 'left');
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where_in('EC.id_cliente', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeNomeEmailCliente($emailCliente, $id_cliente)
    {
        $this->db->select('email');
        $this->db->from('ci_emails_cliente');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('email', $emailCliente);
        $this->db->where('id_cliente', $id_cliente);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function insereEmailCliente($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_emails_cliente', $dados);

        $inseridoId = $this->db->insert_id(); // Pega o ID inserido

        if ($inseridoId) {
            $this->Log_model->insereLog($inseridoId);
        }

        return $inseridoId; // Retorna o ID inserido ou 0 se não foi inserido
    }

    public function deletaEmailCliente($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_emails_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaEmailCliente($id, $idCliente, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->where('id_cliente', $idCliente);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_emails_cliente', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

}

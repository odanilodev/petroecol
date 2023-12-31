<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EtiquetaCliente_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeEtiquetasClientes()
    {
        $this->db->select('EC.*, C.nome, E.nome');
        $this->db->from('ci_etiqueta_cliente EC');
        $this->db->join('ci_clientes C', 'EC.id_cliente = C.id', 'inner');
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id', 'inner');
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('E.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeEtiquetaCliente($id)
    {
        $this->db->select('EC.*, C.nome, E.nome');
        $this->db->from('ci_etiqueta_cliente EC');
        $this->db->join('ci_clientes C', 'EC.id_cliente = C.id', 'inner');
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id', 'inner');
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('E.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('EC.id_cliente', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeIdEtiquetaCliente($id, $id_cliente)
    {
        $this->db->select('EC.*, E.nome');
        $this->db->from('ci_etiqueta_cliente EC');
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id', 'inner');
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('E.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('EC.id_cliente', $id_cliente);
        $this->db->where('EC.id_etiqueta', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function insereEtiquetaCliente($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_etiqueta_cliente', $dados);

        $inseridoId = $this->db->insert_id(); // Pega o ID inserido

        if ($inseridoId) {
            $this->Log_model->insereLog($inseridoId);
        }

        return $inseridoId; // Retorna o ID inserido ou 0 se não foi inserido
    }

    public function deletaEtiquetaCliente($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_etiqueta_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaIdEtiquetaCliente($id)
    {
        $this->db->where('id_etiqueta', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_etiqueta_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

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
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id_etiqueta', 'inner');
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
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id_etiqueta', 'inner');
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('E.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('EC.id', $id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function insereEtiquetaCliente($dados)
    {
        $this->db->insert('ci_etiqueta_cliente', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaEtiquetaCliente($id, $dados)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_etiqueta_cliente', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
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
}

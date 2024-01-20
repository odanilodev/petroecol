<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Etiquetas_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeEtiquetas()
    {
        $this->db->order_by('nome', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_etiquetas');

        return $query->result_array();
    }

    public function recebeEtiqueta($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_etiquetas');

        return $query->row_array();
    }

    public function recebeEtiquetaNome($nome, $id)
    {
        $this->db->where('nome', $nome);
        $this->db->where('id<>', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_etiquetas');

        return $query->row_array();
    }

    public function insereEtiqueta($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_etiquetas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaEtiqueta($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_etiquetas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaEtiqueta($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_etiquetas');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function verificaEtiquetaCliente($id)
    {
        $this->db->where('id_etiqueta', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->get('ci_etiqueta_cliente');

        return $this->db->affected_rows() > 0;
    }
}

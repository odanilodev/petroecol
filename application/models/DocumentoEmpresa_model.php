<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DocumentoEmpresa_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeDocumentosEmpresa()
    {
        $this->db->order_by('nome');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_documento_empresa');

        return $query->result_array();
    }

    public function recebeDocumentoEmpresa($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        
        $query = $this->db->get('ci_documento_empresa');

        return $query->row_array();
    }

    public function recebeDocumentoNome($nome, $id)
    {
        $this->db->where('nome', $nome);
        $this->db->where('id <>', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_documento_empresa');

        return $query->row_array();
    }

    public function insereDocumentoEmpresa($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_documento_empresa', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaDocumentoEmpresa($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_documento_empresa', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaDocumentoEmpresa($ids)
    {
        $this->db->where_in('id', $ids);
        $this->db->where_in('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_documento_empresa');
        
            foreach($ids as $id){
                if ($this->db->affected_rows()) {
                    $this->Log_model->insereLog($id);
            }
        }

        return $this->db->affected_rows() > 0;
    }


    
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setores_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeSetores()
    {
        $this->db->order_by('nome', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_setores');

        return $query->result_array();
    }

    public function recebeSetor($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_setores');

        return $query->row_array();
    }

    public function recebeSetorNome($nome, $id)
    {
        $this->db->where('nome', $nome);
        $this->db->where('id <>', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_setores');

        return $query->row_array();
    }

    public function insereSetor($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_setores', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaSetor($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_setores', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaSetor($ids)
    {
        $this->db->where_in('id', $ids);
        $this->db->where_in('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_setores');

            foreach($ids as $id){
                if ($this->db->affected_rows()) {
                    $this->Log_model->insereLog($id);
            }
        }

        return $this->db->affected_rows() > 0;
    }
}

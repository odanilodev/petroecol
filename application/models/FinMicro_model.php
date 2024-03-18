<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinMicro_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeMicros($id)
    {
        $this->db->order_by('nome', 'ASC');
        $this->db->where('id_macro', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_micros');

        return $query->result_array();
    }

    public function recebeNomeMicro($nome, $id)
    {
        $this->db->where('nome', $nome);
        $this->db->where('id_macro', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_micros');

        return $query->row_array();
    }

    public function insereMicro($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('fin_micros', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }


    public function editaMicro($id_micro, $id_macro, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id_micro);
        $this->db->where('id_macro', $id_macro);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('fin_micros', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog("$id_macro | $id_micro");
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaMicro($id_micros, $id_macro)
    {
        $this->db->where_in('id', $id_micros);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('fin_micros');

        foreach ($id_micros as $id) {
            if ($this->db->affected_rows()) {
                $this->Log_model->insereLog("$id_macro | $id");
            }
        }
        
        return $this->db->affected_rows() > 0;
    }
    public function recebeIdMicro($id_micro)
    {

        $this->db->where('id', $id_micro);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_micros');

        return $query->row_array();
    }
}

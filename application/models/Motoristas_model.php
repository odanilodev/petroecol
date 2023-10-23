<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Motoristas_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeMotoristas()
    {
        $this->db->order_by('nome', 'DESC');
        $this->db->where('status', 1);
        if($this->session->userdata('id_empresa') > 1){
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        }
        
        $query = $this->db->get('ci_motoristas');

        return $query->result_array();
    }

    public function recebeMotorista($id)
    {
        $this->db->where('id', $id);
        if($this->session->userdata('id_empresa') > 1){
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        }

        $query = $this->db->get('ci_motoristas');

        return $query->row_array();
    }

    public function insereMotorista($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_motoristas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaMotorista($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->update('ci_motoristas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLogSenha($id, $dados['id_empresa']);
        }

        return $this->db->affected_rows() > 0;
    }

    public function verificaSenhaAntiga($id, $senhaAntiga)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('senha', $senhaAntiga);
        $query = $this->db->get('ci_usuarios');

        return $query->row_array();
    }

    public function deletaUsuario($id)
    {
        $dados['status'] = 3;
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_usuarios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

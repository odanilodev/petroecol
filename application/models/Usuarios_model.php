<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeUsuarios()
    {
        $this->db->select('ci_usuarios.*, ci_empresas.nome EMPRESA');
        $this->db->from('ci_usuarios');
        $this->db->join('ci_empresas' ,'ci_empresas.id = ci_usuarios.id_empresa', 'INNER');
        $this->db->order_by('ci_usuarios.nome', 'DESC');
        $this->db->where('ci_usuarios.status', 1);
        if($this->session->userdata('id_empresa') > 1){
            $this->db->where('ci_usuarios.id_setor <>', '0' );
            $this->db->where('ci_usuarios.id_empresa', $this->session->userdata('id_empresa'));
        }else{
            $this->db->where('ci_usuarios.id_setor', '0' );
        }
        
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeTodosUsuarios()
    {
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('nome');
        $query = $this->db->get('ci_usuarios');

        return $query->result_array();
    }
    public function recebeUsuario($id)
    {
        $this->db->where('id', $id);
        if($this->session->userdata('id_empresa') > 1){
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        }

        $query = $this->db->get('ci_usuarios');

        return $query->row_array();
    }

    public function recebeUsuarioEmail($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('ci_usuarios');

        return $query->row_array();
    }

    public function insereUsuario($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $dados['permissao'] = "[]";
        $this->db->insert('ci_usuarios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaUsuario($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);

        if($this->session->userdata('id_empresa') > 1){
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        }
        
        $this->db->update('ci_usuarios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function redefinirSenha($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        
        $this->db->update('ci_usuarios', $dados);

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

    public function imagemAntiga($id)
    {
        $this->db->where('id', $id);
        if($this->session->userdata('id_empresa') > 1) {
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        }
        $query = $this->db->get('ci_usuarios');

        return $query->row_array();
    }

    public function deletaUsuario($id)
    {
        $dados['status'] = 3;
        $this->db->where('id', $id);
        
        if($this->session->userdata('id_empresa') > 1){
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        }
        $this->db->update('ci_usuarios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaFotoPerfil($id, $dados)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_usuarios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function verificaSetorUsuario($id)
    {
        $this->db->where('id_setor', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->get('ci_usuarios');

        return $this->db->affected_rows() > 0;
    }
}
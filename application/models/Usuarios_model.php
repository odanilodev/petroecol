<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {
	
	public function recebeUsuarios()
    {
		$this->db->order_by('nome', 'DESC');  
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_usuarios');
			
        return $query->result_array();
    }

    public function recebeUsuario($id) 
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_usuarios');
			
        return $query->row_array();
    }

    public function exibeUsuarios()
    {
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_usuarios');
			
        return $query->result_array();
    }

	public function recebeUsuarioEmail($email)
    {
		
		$this->db->where('email', $email);
        $query = $this->db->get('ci_usuarios');
			
        return $query->row_array();
		
    }

    public function insereUsuario($dados)
    {
        $this->db->insert('ci_usuarios', $dados);
        return $this->db->affected_rows() > 0;
    }

    public function editaUsuario($id, $dados)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_usuarios', $dados);
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
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_usuarios');
			
        return $query->row_array();
    }

    public function deletaUsuario($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_usuarios');

        return $this->db->affected_rows() > 0;
    }
}

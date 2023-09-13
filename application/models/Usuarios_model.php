<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {
	
	public function recebeUsuarios(){
		
		$this->db->order_by('nome', 'DESC');  
        $query = $this->db->get('ci_usuarios');
			
        return $query->result_array();
		
    }

	public function recebeUsuarioEmail($email){
		
		$this->db->where('email', $email);
        $query = $this->db->get('ci_usuarios');
			
        return $query->row_array();
		
    }

    public function insereUsuario($dados)
    {
        $this->db->insert('ci_usuarios', $dados);
    }
}
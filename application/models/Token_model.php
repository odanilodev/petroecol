<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token_model extends CI_Model {
	
	public function recebeTokens(){
		
		$this->db->order_by('data_criacao', 'DESC');  
        $query = $this->db->get('ci_tokens');
			
        return $query->result_array();
		
    }

	public function recebeToken($email){
		
		$this->db->where('email_usuario', $email);
        $query = $this->db->get('ci_tokens');
			
        return $query->row_array();
		
    }

    public function insereToken($data)
    {
        // Insere os dados na tabela 'ci_tokens'
        $this->db->insert('ci_tokens', $data);
        
        // Verifica se a inserção foi bem-sucedida
        return $this->db->affected_rows() > 0;
    }

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token_model extends CI_Model {
	
	public function recebeTokens(){
		
		$this->db->order_by('data_criacao', 'DESC');  
        $query = $this->db->get('ci_tokens');
			
        return $query->result_array();
		
    }

	public function recebeTokenCodigo($codigo)
    {
        $this->db->where('codigo', $codigo);
        $this->db->order_by('id', 'desc'); 
        $this->db->limit(1);
        
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
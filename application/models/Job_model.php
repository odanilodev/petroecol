<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Job_model extends CI_Model {
    
    public function deletaLogs()
    {
        // Calcula a data atual menos 1 ano
        $tempo = date('Y-m-d H:i:s', strtotime('-1 year'));
    
        // Define a condição para deletar registros mais antigos que um ano
        $this->db->where('criado_em <', $tempo);
        $this->db->delete('ci_log');
    
        return $this->db->affected_rows() > 0;
    }
    
}

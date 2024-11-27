<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendas_model extends CI_Model {
    
    public function insereNovaVendaResiduo($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_vendas_residuos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }
    
}

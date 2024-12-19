<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendas_model extends CI_Model {

    public function recebeVendasResiduos($limit, $page, $count = null)
    {
        
        $this->db->select('V.id, V.quantidade, V.data_venda, V.valor_total, C.nome as CLIENTE, R.nome as RESIDUO, U.nome as UNIDADE_MEDIDA');
        $this->db->from('ci_vendas_residuos V');
        $this->db->join('ci_clientes C', 'C.id = V.id_cliente', 'left');
        $this->db->join('ci_residuos R', 'R.id = V.id_residuo', 'left');
        $this->db->join('ci_unidades_medidas U', 'U.id = V.id_unidade_medida', 'left');
        $this->db->where('V.id_empresa', $this->session->userdata('id_empresa'));

        if ($count) {
            $this->db->where('V.id_empresa', $this->session->userdata('id_empresa'));

            $query = $this->db->get();
            return $query->num_rows();
        }

        $offset = ($page - 1) * $limit;

        $this->db->limit($limit, $offset);

        $query = $this->db->get();

        return $query->result_array();
    }
    
    public function insereNovaVendaResiduo($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_vendas_residuos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaVendaResiduo($idVenda)
    {
        $this->db->where('id', $idVenda);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_vendas_residuos');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($idVenda);
        }

        return $this->db->affected_rows() > 0;
    }
    
}

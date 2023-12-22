<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coletas_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function insereColeta($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_coletas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeColetas()
    {
        $this->db->order_by('data_coleta', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get('ci_coletas');

        return $query->result_array();
    }

    public function recebeColeta($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get('ci_coletas');

        return $query->row_array();
    }

    public function recebeColetasCliente($idCliente)
    {
        $this->db->select('ci_coletas.*, ci_coletas.id as ID_COLETA, ci_funcionarios.nome as nome_responsavel');
        $this->db->from('ci_coletas');
        $this->db->join('ci_funcionarios', 'ci_coletas.id_responsavel = ci_funcionarios.id', 'left');
        $this->db->where('ci_coletas.id_cliente', $idCliente);
        $this->db->where('ci_coletas.id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeColetasClienteResiduos($idColeta)
    {
        $this->db->select('C.*, ci_coletas.*, ci_funcionarios.nome as RESPONSAVEL, 
        GROUP_CONCAT(DISTINCT ci_residuos.nome) as RESIDUOS, 
        GROUP_CONCAT(DISTINCT ci_residuos.unidade_medida) as MEDIDA, 
        GROUP_CONCAT(DISTINCT ci_forma_pagamento.forma_pagamento) as PAGAMENTOS');

        $this->db->from('ci_coletas');
        $this->db->join('ci_clientes C', 'ci_coletas.id_cliente = C.id', 'left');

        $this->db->join('ci_residuos', "
        CASE WHEN JSON_SEARCH(ci_coletas.residuos_coletados, 'one', ci_residuos.id) IS NOT NULL 
        THEN ci_residuos.nome 
        ELSE NULL END IS NOT NULL", 'left', FALSE);

        $this->db->join('ci_forma_pagamento', "
        CASE WHEN JSON_SEARCH(ci_coletas.forma_pagamento, 'one', ci_forma_pagamento.id) IS NOT NULL 
        THEN ci_forma_pagamento.forma_pagamento 
        ELSE NULL END IS NOT NULL", 'left', FALSE);

        $this->db->join('ci_funcionarios', 'ci_coletas.id_responsavel = ci_funcionarios.id', 'left');
        $this->db->where('ci_coletas.id', $idColeta);
        $this->db->where('ci_coletas.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->group_by('ci_coletas.id');

        $query = $this->db->get();
        return $query->result_array();
    }
}

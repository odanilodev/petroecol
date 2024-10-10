<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EstoqueResiduos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeEstoqueResiduos($cookie_filtro_estoque_residuos, $limit, $page, $count = null)
    {
        $filtro = json_decode($cookie_filtro_estoque_residuos, true);

        $this->db->select('SUM(ER.quantidade) as quantidade, MAX(ER.id_residuo) as ID_RESIDUO, MAX(R.nome) as RESIDUO, MAX(SE.nome) as SETOR');
        $this->db->from('ci_estoque_residuos ER');

        $this->db->where('ER.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->join('ci_residuos R', 'ER.id_residuo = R.id', 'LEFT');
        $this->db->join('ci_setores_empresa SE', 'R.id_setor_empresa = SE.id', 'LEFT');

        $this->db->where('ER.tipo_movimentacao', 1);
        $this->db->group_by('ER.id_residuo');

        if (!$count) {
            $offset = ($page - 1) * $limit;
            $this->db->limit($limit, $offset);
        }

        if ($filtro['residuos'] ?? false) {
            $this->db->where('R.nome', $filtro['residuos']);
        }

        $query = $this->db->get();

        if ($count) {
            return $query->num_rows();
        }

        return $query->result_array();
    }

    public function recebeMovimentacaoEstoqueResiduo($idResiduo)
    {
        $this->db->select('ER.quantidade, ER.criado_em, ER.tipo_movimentacao, R.nome as RESIDUO');
        $this->db->from('ci_estoque_residuos ER');

        $this->db->where('ER.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->join('ci_residuos R', 'ER.id_residuo = R.id', 'LEFT');

        $this->db->where('ER.id_residuo', $idResiduo);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insereEstoqueResiduos($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_estoque_residuos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

}
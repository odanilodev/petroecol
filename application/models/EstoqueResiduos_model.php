<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EstoqueResiduos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeEstoqueResiduo($idResiduo)
    {
        $this->db->select('ER.total_estoque_residuo as QUANTIDADE');
        $this->db->from('ci_estoque_residuos ER');
        $this->db->where('ER.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('ER.id_residuo', $idResiduo);
        $this->db->order_by('ER.criado_em', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function recebeMovimentacaoEstoqueResiduo($idResiduo)
    {
        $this->db->select('ER.quantidade, ER.criado_em, ER.tipo_movimentacao, ER.origem_movimentacao, R.nome as RESIDUO, U.nome as UNIDADE_MEDIDA');
        $this->db->from('ci_estoque_residuos ER');

        $this->db->where('ER.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->join('ci_residuos R', 'ER.id_residuo = R.id', 'LEFT');
        $this->db->join('ci_unidades_medidas U', 'ER.id_unidade_medida = U.id', 'LEFT');

        $this->db->where('ER.id_residuo', $idResiduo);
        $this->db->order_by('ER.criado_em', 'DESC');

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

    public function recebeTotalAtualEstoqueResiduo($idResiduo)
    {
        $this->db->select('total_estoque_residuo');
        $this->db->from('ci_estoque_residuos');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('id_residuo', $idResiduo);
        $this->db->order_by('criado_em', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        return $query->row_array();
    }

}
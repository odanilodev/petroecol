<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AfericaoTerceiros_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeAfericoesTerceiros($cookie_filtro_clientes, $limit, $page, $count = null)
    {
        $filtro = json_decode($cookie_filtro_clientes, true);
        
        $this->db->select('A.*, F.nome as FORNECEDOR, S.nome as SETOR, R.nome as RESIDUO, R.unidade_medida as UNIDADE_MEDIDA_PADRAO, UMP.nome as UNIDADE_MEDIDA_COLETADA, UMA.nome as UNIDADE_MEDIDA_AFERIDA');
        $this->db->from('ci_afericao_terceiros A');
        $this->db->join('fin_dados_financeiros F', 'A.id_fornecedor = F.id', 'LEFT');
        $this->db->join('ci_setores_empresa S', 'A.id_setor_empresa = S.id', 'LEFT');
        $this->db->join('ci_residuos R', 'A.id_residuo = R.id', 'LEFT');
        $this->db->join('ci_unidades_medidas UMP', 'A.id_unidade_medida_paga = UMP.id', 'LEFT');
        $this->db->join('ci_unidades_medidas UMA', 'A.id_unidade_medida_aferida = UMA.id', 'LEFT');
        $this->db->where('A.id_empresa', $this->session->userdata('id_empresa'));

        if ($filtro['search'] ?? false) {
            $search = $filtro['search'];
            $this->db->where("F.nome LIKE '%$search%'");
        }

        if (!$count) {
            $offset = ($page - 1) * $limit;
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('A.data_afericao', 'DESC');

        $query = $this->db->get();

        if ($count) {
            return $query->num_rows();
        }

        return $query->result_array();
    }
    
    public function insereAfericaoTerceiros($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_afericao_terceiros', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

}

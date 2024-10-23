<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ConversaoUnidadeMedida_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }
    public function recebeConversoes()
    {
        $this->db->select('CM.id, CM.valor, CM.tipo_operacao, CM.simbolo_operacao, UMO.nome AS nome_unidade_origem, UMD.nome AS nome_unidade_destino, R.nome as RESIDUO');
        $this->db->from('ci_conversao_unidade_medida CM');
        $this->db->where('CM.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->join('ci_unidades_medidas UMO', 'CM.id_medida_origem = UMO.id', 'LEFT');
        $this->db->join('ci_unidades_medidas UMD', 'CM.id_medida_destino = UMD.id', 'LEFT');
        $this->db->join('ci_residuos R', 'CM.id_residuo = R.id', 'LEFT');
    
        $query = $this->db->get();
        return $query->result_array();
    }
    

    public function recebeConversaoUnidadeMedida($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_conversao_unidade_medida');

        return $query->row_array();
    }

    public function recebeConversaoResiduo($id_residuo, $id)
    {
        $this->db->where('id_residuo', $id_residuo);
        $this->db->where('id <>', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_conversao_unidade_medida');

        return $query->row_array();
    }

    public function insereConversao($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_conversao_unidade_medida', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaConversao($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_conversao_unidade_medida', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaConversao($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_conversao_unidade_medida');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

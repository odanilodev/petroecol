<?php
defined('BASEPATH') or exit('No direct script access allowed');


class FinPrestacaoContas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebePrestacaoContas()
    {
        $this->db->select('PC.codigo_romaneio, MAX(F.nome) as FUNCIONARIO, SUM(PC.valor) as valor_total');
        $this->db->from('fin_prestacao_contas PC');
        $this->db->join('ci_funcionarios F', 'PC.id_funcionario = F.id', 'LEFT');
        $this->db->where('PC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->group_by('PC.codigo_romaneio');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    

    public function inserePrestacaoContas($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        
        $this->db->insert('fin_prestacao_contas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeCustosPrestacaoContasRomaneio($codRomaneio)
    {
        $this->db->select('TC.nome as CUSTO, PC.valor');
        $this->db->from('fin_prestacao_contas PC');
        $this->db->join('fin_tipos_custos TC', 'PC.id_tipo_custo = TC.id', 'LEFT');
        $this->db->where('PC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('PC.codigo_romaneio', $codRomaneio);
        $query = $this->db->get();
        
        return $query->result_array();
    }

}

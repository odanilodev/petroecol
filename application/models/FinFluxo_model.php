<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class FinFluxo_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeFluxo()
    {
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_fluxo');

        return $query->result_array();
    }

    public function recebeFluxoData($dataInicio, $dataFim)
    {
        $this->db->select('
            fin_fluxo.*,
            fin_contas_bancarias.apelido as apelido_conta_bancaria,
            fin_forma_transacao.nome as nome_forma_transacao,
            fin_dados_financeiros.nome as nome_dado_financeiro
        ');
        $this->db->from('fin_fluxo');
        $this->db->join('fin_contas_bancarias', 'fin_fluxo.id_conta_bancaria = fin_contas_bancarias.id', 'left');
        $this->db->join('fin_forma_transacao', 'fin_fluxo.id_forma_transacao = fin_forma_transacao.id', 'left');
        $this->db->join('fin_dados_financeiros', 'fin_fluxo.id_dado_financeiro = fin_dados_financeiros.id', 'left');
        $this->db->where('fin_fluxo.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('fin_fluxo.data_movimentacao <=', $dataFim);
        $this->db->where('fin_fluxo.data_movimentacao >=', $dataInicio);

        $query = $this->db->get();

        return $query->result_array();
    }


    public function insereFluxo($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('fin_fluxo', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

}

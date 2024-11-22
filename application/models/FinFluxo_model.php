<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

    public function recebeFluxoData($dataInicio, $dataFim, $tipoMovimentacao, $idSetor, $cookie_filtro_fluxo_caixa, $limit, $page, $count = null)
    {
        $filtro = json_decode($cookie_filtro_fluxo_caixa, true);

        $this->db->select('F.*, CB.apelido as apelido_conta_bancaria, FT.nome as nome_forma_transacao, DF.nome as nome_dado_financeiro, C.nome as CLIENTE, M.nome as NOME_MICRO, SE.nome as NOME_SETOR, FNC.nome as NOME_FUNCIONARIO');
        $this->db->from('fin_fluxo F');
        $this->db->join('fin_contas_bancarias CB', 'F.id_conta_bancaria = CB.id', 'left');
        $this->db->join('fin_micros M', 'M.id = F.id_micro', 'left');
        $this->db->join('ci_setores_empresa SE', 'SE.id = F.id_setor_empresa', 'left');
        $this->db->join('fin_forma_transacao FT', 'F.id_forma_transacao = FT.id', 'left');
        $this->db->join('fin_dados_financeiros DF', 'F.id_dado_financeiro = DF.id', 'left');
        $this->db->join('ci_funcionarios FNC', 'F.id_funcionario = FNC.id', 'left');
        $this->db->join('ci_clientes C', 'F.id_cliente = C.id', 'left');

        $this->db->where('F.id_empresa', $this->session->userdata('id_empresa'));

        if ($dataInicio && $dataFim) {
            $this->db->where('F.data_movimentacao <=', $dataFim);
            $this->db->where('F.data_movimentacao >=', $dataInicio);
        }


        if ($tipoMovimentacao !== 'ambas') {
            $this->db->where('F.movimentacao_tabela', $tipoMovimentacao);
        }

        if ($idSetor !== 'todos') {
            $this->db->where('F.id_setor_empresa', $idSetor);
        }


        if ($filtro['search'] ?? false) {
            $search = $filtro['search'];

            // verifica se tem , no texto digitado para buscar valor
            if (preg_match('/[.,]/', $search)) {
                $search = str_replace(['.', ','], ['', '.'], $search);
                $search = (float) $search;
            }

            $this->db->group_start();
            $this->db->where("LOWER(DF.nome) LIKE LOWER('%$search%')");
            $this->db->or_where("LOWER(M.nome) LIKE LOWER('%$search%')");
            $this->db->or_where("LOWER(C.nome) LIKE LOWER('%$search%')");
            $this->db->or_where("LOWER(FNC.nome) LIKE LOWER('%$search%')");
            $this->db->or_where("F.valor LIKE '%$search%'");
            $this->db->or_where("F.observacao LIKE '%$search%'");
            $this->db->group_end();
        }

        if (!$count) {
            $offset = ($page - 1) * $limit;
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('F.data_movimentacao', 'DESC');

        $query = $this->db->get();

        if ($count) {
            return $query->num_rows();
        }

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

    public function recebeMovimentoFluxo($id)
    {
        $this->db->select('DF.nome as RECEBIDO, F.id_conta_bancaria, F.valor, FT.nome as FORMAPAGAMENTO, MA.nome as NOME_MACRO, MI.nome as NOME_MICRO, F.data_movimentacao as DATA_FLUXO, F.observacao as OBSERVACAO_FLUXO, SE.nome as NOME_SETOR, FUNC.nome as NOME_FUNCIONARIO');
        $this->db->from('fin_fluxo F');
        $this->db->join('fin_forma_transacao FT', 'F.id_forma_transacao = FT.id', 'left');
        $this->db->join('ci_setores_empresa SE', 'F.id_setor_empresa = SE.id', 'left');
        $this->db->join('fin_dados_financeiros DF', 'F.id_dado_financeiro = DF.id', 'left');
        $this->db->join('ci_funcionarios FUNC', 'FUNC.id = F.id_funcionario', 'left');
        $this->db->join('fin_macros MA', 'F.id_macro = MA.id', 'left');
        $this->db->join('fin_micros MI', 'F.id_micro = MI.id', 'left');
        $this->db->where('F.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('F.id', $id);

        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletaMovimentoFluxo($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('fin_fluxo');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

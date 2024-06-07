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

    public function recebeFluxoData($dataInicio, $dataFim, $tipoMovimentacao, $limit, $page, $count = null)
    {
        $this->db->select('fin_fluxo.*, fin_contas_bancarias.apelido as apelido_conta_bancaria, fin_forma_transacao.nome as nome_forma_transacao, fin_dados_financeiros.nome as nome_dado_financeiro, ci_funcionarios.nome as FUNCIONARIO, ci_clientes.nome as CLIENTE');
        $this->db->from('fin_fluxo');
        $this->db->join('fin_contas_bancarias', 'fin_fluxo.id_conta_bancaria = fin_contas_bancarias.id', 'left');
        $this->db->join('fin_forma_transacao', 'fin_fluxo.id_forma_transacao = fin_forma_transacao.id', 'left');
        $this->db->join('fin_dados_financeiros', 'fin_fluxo.id_dado_financeiro = fin_dados_financeiros.id', 'left');

        $this->db->join('ci_funcionarios', 'fin_fluxo.id_funcionario = ci_funcionarios.id', 'left'); // recebido/pago (funcionario)

        $this->db->join('ci_clientes', 'fin_fluxo.id_cliente = ci_clientes.id', 'left'); // recebido/pago (cliente)

        $this->db->where('fin_fluxo.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('fin_fluxo.data_movimentacao <=', $dataFim);
        $this->db->where('fin_fluxo.data_movimentacao >=', $dataInicio);

        // Verifica se o tipo de movimentação não é 'ambas', para adicionar uma restrição
        if ($tipoMovimentacao !== 'ambas') {
            $this->db->where('fin_fluxo.movimentacao_tabela', $tipoMovimentacao);
        }

        $this->db->order_by('fin_fluxo.criado_em', 'DESC');

        if ($count) {
            return $this->db->count_all_results();
        }

        // Aplica a paginação
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);

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

    public function recebeMovimentoFluxo($id)
    {
        $this->db->select('DF.nome as RECEBIDO, F.valor, FT.nome as FORMAPAGAMENTO, MA.nome as NOME_MACRO, MI.nome as NOME_MICRO, F.data_movimentacao as DATA_FLUXO, F.observacao as OBSERVACAOFLUXO');
        $this->db->from('fin_fluxo F');
        $this->db->join('fin_forma_transacao FT', 'F.id_forma_transacao = FT.id', 'left');
        $this->db->join('fin_dados_financeiros DF', 'F.id_dado_financeiro = DF.id', 'left');
        $this->db->join('fin_macros MA', 'F.id_macro = MA.id', 'left');
        $this->db->join('fin_micros MI', 'F.id_micro = MI.id', 'left');
        $this->db->where('F.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('F.id', $id);

        $query = $this->db->get();
        return $query->row_array();
    }
}

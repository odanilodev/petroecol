<?php
defined('BASEPATH') or exit('No direct script access allowed');


class FinContasPagar_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeContasPagar($dataInicio, $dataFim, $status, $setor, $cookie_filtro_contas_pagar, $limit, $page, $count = null)
    {

        $filtro = json_decode($cookie_filtro_contas_pagar, true);

        $this->db->select('CP.*, DF.nome as RECEBIDO, SE.nome as SETOR, C.nome as CLIENTE, M.nome as NOME_MICRO');
        $this->db->from('fin_contas_pagar CP');
        $this->db->join('fin_dados_financeiros DF', 'CP.id_dado_financeiro = DF.id', 'LEFT');
        $this->db->join('fin_micros M', 'M.id = CP.id_micro', 'LEFT');
        $this->db->join('ci_setores_empresa SE', 'CP.id_setor_empresa = SE.id', 'LEFT');

        $this->db->join('ci_clientes C', 'CP.id_cliente = C.id', 'left'); // recebido/pago (cliente)

        $this->db->where('CP.id_empresa', $this->session->userdata('id_empresa'));

        if ($dataInicio && $dataFim) {


            $this->db->where('CP.data_vencimento <=', $dataFim);
            $this->db->where('CP.data_vencimento >=', $dataInicio);
        }

        // Verifica se o tipo de movimentação não é 'ambas', para adicionar uma restrição
        if ($status != "" && $status !== 'ambas') {

            $this->db->where('CP.status', $status);
        }

        // Adiciona a cláusula do setor apenas se $setor não for null
        if ($setor !== 'todos' && $setor != '') {

            $this->db->where('CP.id_setor_empresa', $setor);
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
            $this->db->or_where("CP.valor LIKE '%$search%'");
            $this->db->or_where("CP.valor_pago LIKE '%$search%'");
            $this->db->or_where("CP.observacao LIKE '%$search%'");
            $this->db->group_end();
        }

        if (!$count) {
            $offset = ($page - 1) * $limit;
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();

        if ($count) {
            return $query->num_rows();
        }

        return $query->result_array();
    }


    public function recebeContaPagar($id)
    {
        $this->db->select('CP.*, DF.nome as RECEBIDO, DF.id_grupo as GRUPO_CREDOR, SE.nome as SETOR, ci_clientes.nome as CLIENTE, M.nome as MACRO, MICROS.nome as MICRO, F.nome as NOME_FUNCIONARIO');
        $this->db->from('fin_contas_pagar CP');
        $this->db->join('fin_dados_financeiros DF', 'CP.id_dado_financeiro = DF.id', 'LEFT');
        $this->db->join('ci_setores_empresa SE', 'CP.id_setor_empresa = SE.id', 'LEFT');
        $this->db->join('ci_funcionarios F', 'F.id = CP.id_funcionario', 'LEFT');

        $this->db->join('ci_clientes', 'CP.id_cliente = ci_clientes.id', 'left'); // recebido/pago (cliente)

        $this->db->join('fin_macros M', 'CP.id_macro = M.id', 'left');
        $this->db->join('fin_micros MICROS', 'CP.id_micro = MICROS.id', 'left');

        $this->db->where('CP.id', $id);
        $this->db->where('CP.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->row_array();
    }

    public function recebeObsContaPagar($id)
    {
        $this->db->select('observacao');
        $this->db->from('fin_contas_pagar');
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->row_array();
    }

    public function recebeIdMacroContaPagar($id)
    {
        $this->db->select('id_macro');
        $this->db->from('fin_contas_pagar');
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->row_array();
    }

    public function recebeIdMicroContaPagar($id)
    {
        $this->db->select('id_micro');
        $this->db->from('fin_contas_pagar');
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->row_array();
    }


    public function insereConta($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('fin_contas_pagar', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaConta($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('fin_contas_pagar', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaConta($ids)
    {
        $this->db->where_in('id', $ids);
        $this->db->where_in('status', 0);
        $this->db->where_in('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('fin_contas_pagar');

        foreach ($ids as $id) {
            if ($this->db->affected_rows()) {
                $this->Log_model->insereLog($id);
            }

            return $this->db->affected_rows() > 0;
        }
    }

    public function recebeContasPagarExcel($dataInicio, $dataFim, $status, $setor)
    {
        $this->db->select('CP.*, DF.nome as RECEBIDO, SE.nome as SETOR, ci_clientes.nome as CLIENTE, M.nome as NOME_MICRO');
        $this->db->from('fin_contas_pagar CP');
        $this->db->join('fin_dados_financeiros DF', 'CP.id_dado_financeiro = DF.id', 'LEFT');
        $this->db->join('fin_micros M', 'M.id = CP.id_micro', 'LEFT');
        $this->db->join('ci_setores_empresa SE', 'CP.id_setor_empresa = SE.id', 'LEFT');

        $this->db->join('ci_clientes', 'CP.id_cliente = ci_clientes.id', 'left'); // recebido/pago (cliente)

        $this->db->where('CP.id_empresa', $this->session->userdata('id_empresa'));

        if ($dataInicio && $dataFim) {

            $this->db->where('CP.data_vencimento <=', $dataFim);
            $this->db->where('CP.data_vencimento >=', $dataInicio);
        }


        // Verifica se o tipo de movimentação não é 'ambas', para adicionar uma restrição
        if ($status !== 'ambas') {
            $this->db->where('CP.status', $status);
        }

        // Adiciona a cláusula do setor apenas se $setor não for null
        if ($setor !== 'todos') {
            $this->db->where('CP.id_setor_empresa', $setor);
        }

        $query = $this->db->get();

        return $query->result_array();
    }

}

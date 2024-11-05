<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinContasReceber_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeContasReceber($dataInicio, $dataFim, $status, $setor)
    {
        $this->db->select('CR.*, DF.nome as RECEBIDO, SE.nome as SETOR, ci_clientes.nome as CLIENTE, F.nome as NOME_FUNCIONARIO');
        $this->db->from('fin_contas_receber CR');
        $this->db->join('fin_dados_financeiros DF', 'CR.id_dado_financeiro = DF.id', 'left');
        $this->db->join('ci_funcionarios F', 'F.id = CR.id_funcionario', 'left');
        $this->db->join('ci_setores_empresa SE', 'CR.id_setor_empresa = SE.id', 'LEFT');

        $this->db->join('ci_clientes', 'CR.id_cliente = ci_clientes.id', 'left'); // recebido/pago (cliente)

        $this->db->where('CR.id_empresa', $this->session->userdata('id_empresa'));

        if ($dataInicio && $dataFim) {

            $this->db->where('CR.data_vencimento >=', $dataInicio);
            $this->db->where('CR.data_vencimento <=', $dataFim);
        }

        // Verifica se o tipo de movimentação não é 'ambas', para adicionar uma restrição
        if ($status !== 'ambas') {
            $this->db->where('CR.status', $status);
        }

        // Adiciona a cláusula do setor apenas se $setor não for null
        if ($setor !== 'todos') {
            $this->db->where('CR.id_setor_empresa', $setor);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function insereContasReceber($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('fin_contas_receber', $dados);

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
        $this->db->update('fin_contas_receber', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeContaReceber($id)
    {
        $this->db->select('CR.*, DF.nome as RECEBIDO, DF.id_grupo as GRUPO_CREDOR, SE.nome as SETOR, ci_clientes.nome as CLIENTE');
        $this->db->from('fin_contas_receber CR');
        $this->db->join('fin_dados_financeiros DF', 'CR.id_dado_financeiro = DF.id', 'LEFT');
        $this->db->join('ci_setores_empresa SE', 'CR.id_setor_empresa = SE.id', 'LEFT');

        $this->db->join('ci_clientes', 'CR.id_cliente = ci_clientes.id', 'left'); // recebido/pago (cliente)

        $this->db->where('CR.id', $id);
        $this->db->where('CR.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->row_array();
    }

    public function recebeIdMacroContaReceber($id)
    {
        $this->db->select('id_macro');
        $this->db->from('fin_contas_receber');
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->row_array();
    }

    public function recebeIdMicroContaReceber($id)
    {
        $this->db->select('id_micro');
        $this->db->from('fin_contas_receber');
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->row_array();
    }

    public function deletaConta($id)
    {
        $this->db->where('id', $id);
        $this->db->where('status', 0);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('fin_contas_receber');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

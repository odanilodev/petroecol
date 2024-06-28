<?php
defined('BASEPATH') or exit('No direct script access allowed');


class FinDadosFinanceiros_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeDadosFinanceiros()
    {
        $this->db->order_by('nome', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_dados_financeiros');

        return $query->result_array();
    }


    public function recebeDadoFinanceiro($id)
    {
        $this->db->select('DF.*, G.nome AS NOME_GRUPO');
        $this->db->join('fin_grupos G', 'DF.id_grupo = G.id');
        $this->db->where('DF.id', $id);
        $this->db->where('DF.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_dados_financeiros DF');

        return $query->row_array();
    }

    public function recebeNomeDadosFinanceiros($nome, $cnpj, $id)
    {
        $this->db->group_start();
        $this->db->or_where('nome', $nome);
        $this->db->or_where('cnpj', $cnpj);
        $this->db->group_end();
        $this->db->where('id <>', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_dados_financeiros');

        return $query->row_array();
    }

    public function insereDadosFinanceiros($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('fin_dados_financeiros', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaDadosFinanceiros($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('fin_dados_financeiros', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaDadosFinanceiros($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('fin_dados_financeiros');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

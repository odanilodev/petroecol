<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinTiposCustos_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    /**
     * Retorna uma lista de tipos de custos ordenados pelo nome.
     * 
     * @return array
     */
    public function recebeTiposCustos(): array
    {
        $this->db->order_by('nome', 'ASC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_tipos_custos');

        return $query->result_array();
    }

    /**
     * Retorna um tipo de custo específico pelo ID.
     * 
     * @param int $id
     * @return array
     */
    public function recebeTipoCusto(?int $id): array
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_tipos_custos');

        return $query->row_array() ?? [];
    }

    /**
     * Retorna um tipo de custo específico pelo nome, excluindo um ID específico.
     * 
     * @param string $nome
     * @param int $id
     * @return array
     */
    public function recebeTipoCustoNome(string $nome, int $id): array
    {
        $this->db->where('nome', $nome);
        $this->db->where('id <>', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('fin_tipos_custos');
        
        return $query->row_array() ?? [];
    }

    /**
     * Insere um novo tipo de custo e registra o log.
     * 
     * @param array $dados
     * @return bool
     */
    public function insereTipoCusto(array $dados): bool
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('fin_tipos_custos', $dados);

        if ($this->db->affected_rows() > 0) {
            $this->Log_model->insereLog($this->db->insert_id());
            return true;
        }

        return false;
    }

    /**
     * Edita um tipo de custo existente e registra o log.
     * 
     * @param int $id
     * @param array $dados
     * @return bool
     */
    public function editaTipoCusto(int $id, array $dados): bool
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('fin_tipos_custos', $dados);

        if ($this->db->affected_rows() > 0) {
            $this->Log_model->insereLog($id);
            return true;
        }

        return false;
    }

    /**
     * Deleta um tipo de custo e registra o log.
     * 
     * @param int $id
     * @return bool
     */
    public function deletaTipoCusto(int $id): bool
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('fin_tipos_custos');

        if ($this->db->affected_rows() > 0) {
            $this->Log_model->insereLog($id);
            return true;
        }

        return false;
    }
}

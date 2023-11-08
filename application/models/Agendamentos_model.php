<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agendamentos_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeAgendamentos($anoAtual, $mesAtual)
    {
        $this->db->select('data_coleta, COUNT(*) AS total_agendamento');
        $this->db->from('ci_agendamentos');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('YEAR(data_coleta)', $anoAtual);
        $this->db->where('MONTH(data_coleta)', $mesAtual);
        $this->db->group_by('data_coleta');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insereAgendamento($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_agendamentos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function getRecordCount()
    {
        // Substitua 'your_table' pelo nome da tabela do seu banco de dados
        $this->db->from('ci_agendamentos');
        return $this->db->count_all_results();
    }

    public function recebeClientesAgendados($dataColeta) 
    {
        $this->db->select('A.*, C.nome, C.rua, C.numero, C.cidade, C.telefone');
        $this->db->from('ci_agendamentos A');
        $this->db->join('ci_clientes C', 'A.id_cliente = C.id', 'inner');
        $this->db->where('A.data_coleta', $dataColeta);
        $this->db->where('A.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();

    }

    public function cancelaAgendamentoCliente($idAgendamento)
    {
        $this->db->where('id', $idAgendamento);
        $this->db->delete('ci_agendamentos');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($idAgendamento);
        }

        return $this->db->affected_rows() > 0;

    }
}

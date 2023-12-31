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
        $this->db->select('data_coleta, prioridade, status, COUNT(*) AS total_agendamento');
        $this->db->from('ci_agendamentos');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('YEAR(data_coleta)', $anoAtual);
        $this->db->where('MONTH(data_coleta)', $mesAtual);
        $this->db->group_by('data_coleta, prioridade, status');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function recebeAgendamentosCliente($id_cliente, $data_coleta)
    {
        $this->db->select('id, data_coleta, status');
        $this->db->from('ci_agendamentos');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('id_cliente', $id_cliente); // Adiciona a condição para o id_cliente
        $this->db->where('status', 0); // Adiciona a condição para o status igual a 0
        $this->db->where('data_coleta <', $data_coleta);
        $this->db->group_by('id');
        $this->db->group_by('data_coleta');
        $this->db->group_by('status');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function recebeUltimoAgendamentoCliente($id_cliente)
    {
        $this->db->select('periodo_coleta, hora_coleta');
        $this->db->from('ci_agendamentos');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('id_cliente', $id_cliente);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
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

    public function editaStatusAgendamento($id_cliente, $data_coleta, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('id_cliente', $id_cliente); 
        $this->db->where('status', 0);
        $this->db->where('data_coleta <', $data_coleta);
        $this->db->update('ci_agendamentos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id_cliente);
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaAgendamento($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_agendamentos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaAgendamentoData($id_cliente, $data_agendamento, $dados)
    {

        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('data_coleta', $data_agendamento);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $this->db->update('ci_agendamentos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id_cliente); // Corrigi para usar $id_cliente em vez de $id
        }

        return $this->db->affected_rows() > 0;
    }


    public function recebeClientesAgendados($dataColeta, $prioridade)
    {
        $this->db->select('A.*, C.nome, C.rua, C.numero, C.cidade, C.telefone');
        $this->db->from('ci_agendamentos A');
        $this->db->join('ci_clientes C', 'A.id_cliente = C.id', 'inner');
        $this->db->where('A.data_coleta', $dataColeta);
        $this->db->where('A.prioridade', $prioridade);
        $this->db->where('A.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeClienteAgendado($idCLiente, $dataColeta)
    {
        $this->db->where('data_coleta', $dataColeta);
        $this->db->where('id_cliente', $idCLiente);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_agendamentos');

        return $query->row_array();
    }

    public function cancelaAgendamentoCliente($idAgendamento)
    {
        $this->db->where('id', $idAgendamento);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_agendamentos');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($idAgendamento);
        }

        return $this->db->affected_rows() > 0;
    }
}

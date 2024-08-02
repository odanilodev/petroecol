<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Funcionarios_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeFuncionarios()
    {
        $this->db->where('status', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('nome', 'DESC');

        $query = $this->db->get('ci_funcionarios');

        return $query->result_array();
    }
    
    public function recebeFuncionariosSaldos()
    {
        $this->db->where('status', 1);
        $this->db->where('saldo IS NOT NULL');
        $this->db->where('saldo >', 0);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('nome', 'DESC');

        $query = $this->db->get('ci_funcionarios');

        return $query->result_array();
    }

    public function recebeFuncionario($id)
    {
        $this->db->select('F.*, C.nome as funcao_nome');
        $this->db->from('ci_funcionarios F');
        $this->db->join('ci_cargos C', 'C.id = F.id_cargo', 'left');
        $this->db->where('F.id', $id);
        $this->db->where('F.status', 1);
        $this->db->where('F.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->limit(1);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function recebeSaldoFuncionario($id)
    {
        $this->db->select('F.saldo');
        $this->db->from('ci_funcionarios F');
        $this->db->where('F.id', $id);
        $this->db->where('F.status', 1);
        $this->db->where('F.id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();

        return $query->row_array();
    }

    public function atualizaSaldoFuncionario($idResponsavel, $novoSaldoFuncionario)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $dados['saldo'] = $novoSaldoFuncionario;
        $this->db->where('id', $idResponsavel);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_funcionarios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($idResponsavel);
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeResponsavelAgendamento()
    {
        $this->db->select('F.nome, F.id as IDFUNCIONARIO, F.id_cargo, C.responsavel_agendamento, C.nome as CARGO');

        $this->db->from('ci_funcionarios F');

        $this->db->join('ci_cargos C', 'C.id = F.id_cargo', 'left');

        $this->db->where('C.responsavel_agendamento', 1);
        $this->db->where('F.status', 1);
        $this->db->where('F.id_empresa', $this->session->userdata('id_empresa'));

        $this->db->order_by('C.nome', 'DESC');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function insereFuncionario($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_funcionarios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaFuncionario($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_funcionarios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaFuncionario($id)
    {
        $dados['status'] = 3;
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_funcionarios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function verificaCpfFuncionario($cpf, $id)
    {
        $this->db->where('cpf', $cpf);
        $this->db->where('id <>', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_funcionarios');

        return $query->row_array();
    }

    public function deletaDocumentoFuncionario($id, $dados)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_funcionarios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function verificaCargoFuncionario($id)
    {
        $this->db->where('id_cargo', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->get('ci_funcionarios');

        return $this->db->affected_rows() > 0;
    }

    public function recebeSaldoFuncionario($id)
    {
        $this->db->select('F.saldo');
        $this->db->from('ci_funcionarios F');
        $this->db->where('F.id', $id);
        $this->db->where('F.status', 1);
        $this->db->where('F.id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();

        return $query->row_array();
    }

    public function atualizaSaldoFuncionario($idResponsavel, $novoSaldoFuncionario)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $dados['saldo'] = $novoSaldoFuncionario;
        $this->db->where('id', $idResponsavel);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_funcionarios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($idResponsavel);
        }

        return $this->db->affected_rows() > 0;
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ResiduoCliente_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeResiduosClientes()
    {
        $this->db->select('RC.*, R.nome');
        $this->db->from('ci_residuo_cliente RC');
        $this->db->join('ci_clientes C', 'RC.id_cliente = C.id', 'inner');
        $this->db->join('ci_residuos R', 'RC.id_residuo = R.id', 'inner');
        $this->db->where('RC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeResiduosClientesPorIdCliente(array $idClientes)
    {
        $this->db->select('RC.*, R.nome');
        $this->db->from('ci_residuo_cliente RC');
        $this->db->join('ci_residuos R', 'RC.id_residuo = R.id', 'left');
        $this->db->where_in('RC.id_cliente', $idClientes);
        $this->db->where('RC.valor_forma_pagamento <>', '');
        $this->db->where('RC.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeResiduoCliente($id)
    {
        $this->db->select('RC.*, R.nome, FP.forma_pagamento');
        $this->db->from('ci_residuo_cliente RC');
        $this->db->join('ci_forma_pagamento FP', 'RC.id_forma_pagamento = FP.id', 'left');
        $this->db->join('ci_clientes C', 'RC.id_cliente = C.id', 'inner');
        $this->db->join('ci_residuos R', 'RC.id_residuo = R.id', 'inner');
        $this->db->where('RC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where_in('RC.id_cliente', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeIdResiduoCliente($id, $id_cliente)
    {
        $this->db->select('RC.*, R.nome');
        $this->db->from('ci_residuo_cliente RC');
        $this->db->join('ci_residuos R', 'RC.id_residuo = R.id', 'inner');
        $this->db->where('RC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('RC.id_cliente', $id_cliente);
        $this->db->where('RC.id_residuo', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function insereResiduoCliente($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_residuo_cliente', $dados);

        $inseridoId = $this->db->insert_id(); // Pega o ID inserido

        if ($inseridoId) {
            $this->Log_model->insereLog($inseridoId);
        }

        return $inseridoId; // Retorna o ID inserido ou 0 se não foi inserido
    }

    public function deletaResiduoCliente($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_residuo_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaResiduoCliente($id, $idCliente, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id_cliente', $idCliente);
        $this->db->where('id_residuo', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_residuo_cliente', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    // recebe o valor do residuo atrelado ao cliente
    public function recebeValorResiduoCliente($idResiduo, $idCliente)
    {
        $this->db->select('RC.valor_forma_pagamento as valor, SC.dia_pagamento, SC.id_setor_empresa');
        $this->db->from('ci_residuo_cliente RC');
        $this->db->join('ci_setores_empresa_cliente SC', 'RC.id_cliente = SC.id_cliente', 'LEFT');
        $this->db->where('RC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('RC.id_cliente', $idCliente);
        $this->db->where('RC.id_residuo', $idResiduo);
        $query = $this->db->get();

        return $query->row_array();
    }
}

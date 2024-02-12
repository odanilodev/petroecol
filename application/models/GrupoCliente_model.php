<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GrupoCliente_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeGrupoCliente($id)
    {
        $this->db->select('GC.*, G.nome');
        $this->db->from('ci_grupo_cliente GC');
        $this->db->join('ci_clientes C', 'GC.id_cliente = C.id', 'inner');
        $this->db->join('ci_grupos G', 'GC.id_grupo = G.id', 'inner');
        $this->db->where('GC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('GC.id_cliente', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function insereGrupoCliente($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_grupo_cliente', $dados);

        $inseridoId = $this->db->insert_id(); // Pega o ID inserido

        if ($inseridoId) {
            $this->Log_model->insereLog($inseridoId);
        }

        return $inseridoId; // Retorna o ID inserido ou 0 se não foi inserido
    }

    public function deletaGrupoCliente($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_grupo_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeGruposClientes($id_grupo)
    {
        $this->db->where('id_grupo', $id_grupo);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_grupo_cliente');
        return $query->result_array();
    }

    public function recebeIdClientesPorGrupos(array $id_grupo)
    {
        $this->db->where_in('id_grupo', $id_grupo);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_grupo_cliente');
        return $query->result_array();
    }

}

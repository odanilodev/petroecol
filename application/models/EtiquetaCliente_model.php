<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EtiquetaCliente_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeEtiquetasClientes()
    {
        $this->db->select('EC.*, C.nome, E.nome');
        $this->db->from('ci_etiqueta_cliente EC');
        $this->db->join('ci_clientes C', 'EC.id_cliente = C.id', 'inner');
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id', 'inner');
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('E.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeEtiquetaCliente($id)
    {
        $this->db->select('EC.*, C.nome, E.nome');
        $this->db->from('ci_etiqueta_cliente EC');
        $this->db->join('ci_clientes C', 'EC.id_cliente = C.id', 'inner');
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id', 'inner');
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('E.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('EC.id_cliente', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeIdEtiquetaCliente($id, $id_cliente)
    {
        $this->db->select('EC.*, E.nome');
        $this->db->from('ci_etiqueta_cliente EC');
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id', 'inner');
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('E.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('EC.id_cliente', $id_cliente);
        $this->db->where('EC.id_etiqueta', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function insereEtiquetaCliente($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_etiqueta_cliente', $dados);

        $inseridoId = $this->db->insert_id(); // Pega o ID inserido

        if ($inseridoId) {
            $this->Log_model->insereLog($inseridoId);
        }

        return $inseridoId; // Retorna o ID inserido ou 0 se não foi inserido
    }

    public function deletaEtiquetaCliente($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_etiqueta_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaIdEtiquetaCliente($id)
    {
        $this->db->where('id_etiqueta', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_etiqueta_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeClientesEtiqueta($id_etiqueta, $setorEmpresa)
    {
        $this->db->select('EC.id_etiqueta, EC.id_cliente, C.status');
        $this->db->from('ci_etiqueta_cliente EC');
        $this->db->join('ci_clientes C', 'EC.id_cliente = C.id', 'left');
        $this->db->join('ci_setores_empresa_cliente SE', 'C.id = SE.id_cliente', 'left');
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.status', 1);
        $this->db->where('SE.id_setor_empresa', $setorEmpresa);
        $this->db->where('EC.id_etiqueta', $id_etiqueta);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeTodasEtiquetasClientes()
    {
        $this->db->select('EC.id_etiqueta, E.nome');
        $this->db->from('ci_etiqueta_cliente EC');
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id', 'inner');
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('E.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->group_by('EC.id_etiqueta, E.nome');
        $query = $this->db->get();

        return $query->result_array();
    }
    public function verificaEtiquetaCliente($id)
    {
        $this->db->select('EC.id_etiqueta, GROUP_CONCAT(DISTINCT E.nome) as nomes_etiquetas');
        $this->db->from('ci_etiqueta_cliente EC');
        $this->db->where_in('EC.id_etiqueta', $id);
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->join('ci_etiquetas E', 'E.id = EC.id_etiqueta', 'left');
        $this->db->group_by('EC.id_etiqueta');

        $query = $this->db->get();

        $etiquetaVinculada = $query->result_array();

        return $etiquetaVinculada;
    }
}

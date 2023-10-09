<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Clientes_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeClientes($limit, $page, $count = null)
    {
        if ($count) {
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
            $this->db->where('status', 1);

            $query = $this->db->get('ci_clientes');
            return $query->num_rows();
        }

        $offset = ($page - 1) * $limit;
        $this->db->order_by('nome', 'DESC');
        $this->db->where('status', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->limit($limit, $offset);
        $query = $this->db->get('ci_clientes');

        return $query->result_array();
    }

    public function recebeCliente($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_clientes');

        return $query->row_array();
    }

    public function insereCliente($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_clientes', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaCliente($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_clientes', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaCliente($id)
    {
        $dados['status'] = 3;
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_clientes', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaEtiquetaCliente($id)
    {
        $this->db->where('id_cliente', $id);
        $this->db->delete('ci_etiqueta_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function buscarClientes($status = null, $etiquetas = array(), $nome = null, $estado = null, $cidade = null) {
       
        $this->db->select('*');
        $this->db->from('ci_clientes');

        // Aplicar os filtros, se fornecidos
        if ($status !== null) {
            $this->db->where('status', $status);
        }
        
        // Lidar com as etiquetas como um array
        if (!empty($etiquetas)) {
            foreach ($etiquetas as $etiqueta) {
                $this->db->or_like('etiquetas', $etiqueta);
            }
        }

        if ($nome !== null) {
            $this->db->like('nome', $nome);
        }
        if ($estado !== null) {
            $this->db->where('estado', $estado);
        }
        if ($cidade !== null) {
            $this->db->where('cidade', $cidade);
        }

        // Executar a consulta
        $query = $this->db->get();

        // Retornar os resultados como um array
        return $query->result_array();
    }

    public function buscarEstadosClientes() {
        // Selecionar os estados sem repetição da tabela de clientes
        $this->db->distinct();
        $this->db->select('estado');
        $this->db->from('ci_clientes');

        // Executar a consulta
        $query = $this->db->get();

        // Verificar se a consulta retornou resultados
        if ($query->num_rows() > 0) {
            $estados = $query->result_array();
            // Extrair os estados em um array simples
            $estados_simples = array_column($estados, 'estado');
            return $estados_simples;
        } else {
            return array(); // Nenhum estado encontrado
        }
    }

    public function buscarCidadesClientes($estado) {
        // Selecionar as cidades do estado fornecido na tabela de clientes
        $this->db->distinct();
        $this->db->select('cidade');
        $this->db->from('ci_clientes');
        $this->db->where('estado', $estado);

        // Executar a consulta
        $query = $this->db->get();

        // Verificar se a consulta retornou resultados
        if ($query->num_rows() > 0) {
            $cidades = $query->result_array();
            // Extrair as cidades em um array simples
            $cidades_simples = array_column($cidades, 'cidade');
            return $cidades_simples;
        } else {
            return array(); // Nenhuma cidade encontrada para o estado fornecido
        }
    }

    
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Clientes_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
        $this->load->helper('cache_helper');
    }

    public function recebeClientes($cookie_filtro_clientes, $limit, $page, $count = null)
    {
        $filtro = json_decode($cookie_filtro_clientes, true);

        $this->db->select('C.*');
        $this->db->from('ci_clientes C');

        $this->db->join('ci_recipiente_cliente RC', 'RC.id_cliente = C.id', 'left');
        $this->db->join('ci_etiqueta_cliente EC', 'EC.id_cliente = C.id', 'left');
        $this->db->join('ci_residuo_cliente RSC', 'RSC.id_cliente = C.id', 'left');

        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('C.nome', 'ASC');

        if (($filtro['status'] ?? false) && $filtro['status'] != 'all') {
            $this->db->where('C.status', $filtro['status']);
        }

        if (($filtro['cidade'] ?? false) && $filtro['cidade'] != 'all') {
            $this->db->where('C.cidade', $filtro['cidade']);
        }

        if ($filtro['nome'] ?? false) {
            $this->db->like('C.nome', $filtro['nome']);
        }

        if (($filtro['id_recipiente'] ?? false) && $filtro['id_recipiente'] != 'all') {
            $this->db->where('RC.id_recipiente', $filtro['id_recipiente']);
        }

        if (($filtro['id_residuo'] ?? false) && $filtro['id_residuo'] != 'all') {
            $this->db->where('RSC.id_residuo', $filtro['id_residuo']);
        }

        if (($filtro['id_etiqueta'] ?? false) && $filtro['id_etiqueta'] != 'all') {
            $this->db->where('EC.id_etiqueta', $filtro['id_etiqueta']);
        }

        if (!$count) {
            $offset = ($page - 1) * $limit;
            $this->db->limit($limit, $offset);
        }

        $this->db->group_by('C.id');

        $query = $this->db->get();

        if ($count) {
            return $query->num_rows();
        }

        return $query->result_array();
    }

    public function recebeTodosClientes()
    {
        $this->db->order_by('nome', 'DESC');
        $this->db->where('status', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_clientes');
        return $query->result_array();
    }

    public function recebeClientesEtiquetas()
    {
        $this->db->select('C.nome, C.cidade, C.id, E.nome as ETIQUETA');
        $this->db->from('ci_clientes C');
        $this->db->join('ci_etiqueta_cliente EC', 'C.id = EC.id_cliente', 'LEFT');
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id', 'LEFT');
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.status', 1);
        $this->db->order_by('C.nome', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function recebeCidadesCliente()
    {
        $this->db->select('cidade');
        $this->db->where('status', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('cidade');
        $this->db->group_by('cidade');
        $query = $this->db->get('ci_clientes');
        return $query->result_array();
    }

    public function recebeCliente($id)
    {
        $this->db->select('C.*, F.frequencia, CE.cor');
        $this->db->from('ci_clientes C');
        $this->db->join('ci_frequencia_coleta F', 'C.id_frequencia_coleta = F.id', 'left');
        $this->db->join('ci_classificacao_empresa CE', 'C.id_classificacao_empresa = CE.id', 'left');
        $this->db->where('C.id', $id);
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();
    
        return $query->row_array();
    }
    

    public function recebeClienteFrequenciaColeta($id_cliente)
    {
        $this->db->select('F.dia');
        $this->db->from('ci_clientes C');
        $this->db->join('ci_frequencia_coleta F', 'C.id_frequencia_coleta = F.id', 'left');
        $this->db->where('C.id', $id_cliente);
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->row_array();
    }


    //Recebe clientes com varios Ids selecionados
    public function recebeClientesIds($ids, $data_coleta)
    {
        $this->db->select('C.*, F.frequencia, A.prioridade');
        $this->db->from('ci_clientes C');
        $this->db->join('ci_frequencia_coleta F', 'C.id_frequencia_coleta = F.id', 'left');
        $this->db->join('ci_agendamentos A', 'A.id_cliente = C.id', 'left');
        $this->db->order_by('C.cidade');
        $this->db->order_by('C.nome');
        $this->db->where('A.data_coleta', $data_coleta);
        $this->db->where_in('C.id', $ids); // Use where_in para comparar com vários IDs
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array(); // Use result_array() para obter vários resultados
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
            limparCache('clientesinativar');
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
            limparCache('clientesinativar');
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

    public function verificaRecipienteCliente($id)
    {
        $this->db->where('id_cliente', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->get('ci_recipiente_cliente');

        return $this->db->affected_rows() > 0;
    }

    public function recebeClientesRomaneio($idsClientes)
    {
        $this->db->select('C.id, C.nome, C.rua, C.telefone, C.cidade, C.numero, C.bairro');
        $this->db->from('ci_clientes C');
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where_in('C.id', $idsClientes);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeClientesAprovacaoInativacao()
    {
        $this->load->driver('cache', array('adapter' => 'file'));
        $clientesParaInativar = $this->cache->get('clientesinativar/clientes_para_inativar_empresa_' . $this->session->userdata('id_empresa'));

        if ($clientesParaInativar === FALSE) {
            $this->db->select('C.nome, C.id, C.criado_em AS CLIENTE_CRIADO_EM, CI.criado_em AS ULTIMA_COLETA');
            $this->db->from('ci_clientes AS C');
            $this->db->join('(SELECT id_cliente, MAX(criado_em) AS criado_em FROM ci_coletas WHERE coletado = 1 GROUP BY id_cliente) AS CI', 'CI.id_cliente = C.id', 'left');
            $this->db->where('C.STATUS', 1);
            $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
            $this->db->where('((CI.criado_em < DATE_SUB(NOW(), INTERVAL 3 MONTH) AND CI.criado_em IS NOT NULL) OR (CI.criado_em IS NULL AND C.criado_em < DATE_SUB(NOW(), INTERVAL 3 MONTH)))', null, false);
            $this->db->limit(200);

            $query = $this->db->get();
            $clientesParaInativar = $query->result_array();

            if ($clientesParaInativar) {
                $this->cache->save('clientesinativar/clientes_para_inativar_empresa_' . $this->session->userdata('id_empresa'), $clientesParaInativar, 43200); // 12 horas
            }
        }
        return $clientesParaInativar;
    }

    public function verificaFormaPagamentoCliente($id)
    {
        $this->db->where('id_forma_pagamento', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->get('ci_clientes');

        return $this->db->affected_rows() > 0;
    }
}

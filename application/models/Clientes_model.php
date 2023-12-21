<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Clientes_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeClientes($cookie_filtro_clientes, $limit, $page, $count = null)
    {
        $filtro = json_decode($cookie_filtro_clientes, true);

        $this->db->select('C.*');
        $this->db->from('ci_clientes C');
        $this->db->join('ci_recipiente_cliente RC', 'RC.id_cliente = C.id', 'left');
        $this->db->join('ci_recipientes R', 'RC.id_recipiente = R.id', 'left');

        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('C.nome', 'DESC');

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
            $this->db->where('R.id', $filtro['id_recipiente']);
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
        $this->db->select('C.*, F.frequencia');
        $this->db->from('ci_clientes C');
        $this->db->join('ci_frequencia_coleta F', 'C.id_frequencia_coleta = F.id', 'left');
        $this->db->where('C.id', $id);
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->row_array();
    }

    //Recebe clientes com varios Ids selecionados
    public function recebeClientesIds($ids)
    {
        $this->db->select('C.*, F.frequencia');
        $this->db->from('ci_clientes C');
        $this->db->join('ci_frequencia_coleta F', 'C.id_frequencia_coleta = F.id', 'left');
        $this->db->order_by('C.cidade');
        $this->db->order_by('C.nome');
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
        $this->db->select('C.nome, C.id, C.criado_em AS CLIENTE_CRIADO_EM, CI.criado_em AS ULTIMA_COLETA');
        $this->db->from('ci_clientes AS C');
        $this->db->join('(SELECT id_cliente, MAX(criado_em) AS criado_em FROM ci_coletas WHERE coletado = 1 GROUP BY id_cliente) AS CI', 'CI.id_cliente = C.id', 'left');
        $this->db->where('C.STATUS', 1);
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('((CI.criado_em < DATE_SUB(NOW(), INTERVAL 3 MONTH) AND CI.criado_em IS NOT NULL) OR (CI.criado_em IS NULL AND C.criado_em < DATE_SUB(NOW(), INTERVAL 3 MONTH)))', null, false);

        $query = $this->db->get();
        return $query->result_array();
    }
}

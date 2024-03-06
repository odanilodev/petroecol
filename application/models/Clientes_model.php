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
        $this->db->join('ci_grupo_cliente GC', 'GC.id_cliente = C.id', 'left');
        $this->db->join('ci_classificacao_cliente CC', 'C.id_classificacao_cliente = CC.id', 'left');

        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('C.status, C.nome', 'ASC');

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

        if (($filtro['classificacao'] ?? false) && $filtro['classificacao'] != 'all') {
            $this->db->where('CC.id', $filtro['classificacao']);
        }

        if (($filtro['id_grupo'] ?? false) && $filtro['id_grupo'] != 'all') {
            $this->db->where('GC.id_grupo', $filtro['id_grupo']);
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
        $this->db->order_by('nome');
        $this->db->where('status', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_clientes');
        return $query->result_array();
    }

    public function recebeTodosClientesColetados()
    {
        $this->db->select('C.*, ANY_VALUE(C.id)');
        $this->db->from('ci_clientes C');
        $this->db->where('C.status', 1);
        $this->db->join('ci_coletas CO', 'CO.id_cliente = C.id', 'RIGHT');
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->group_by('C.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function recebeClientesEtiquetas()
    {
        $this->db->select('C.nome, C.cidade, C.id as ID_CLIENTE, E.nome as ETIQUETA');
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
        // Seleciona os dados do cliente, incluindo a cor da classificação e a frequência de coleta.
        $this->db->select('C.*, CC.cor, F.frequencia');
        $this->db->from('ci_clientes C');
        // Junta com a tabela de classificação de cliente para obter a cor.
        $this->db->join('ci_classificacao_cliente CC', 'C.id_classificacao_cliente = CC.id', 'left');
        // Junta com a tabela ci_setores_empresa_cliente e depois com ci_frequencia_coleta para obter a frequência.
        $this->db->join('ci_setores_empresa_cliente SEC', 'C.id = SEC.id_cliente', 'left');
        $this->db->join('ci_frequencia_coleta F', 'SEC.id_frequencia_coleta = F.id', 'left');
        $this->db->where('C.id', $id);
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        
        // Executa a consulta e retorna o primeiro resultado.
        $cliente = $this->db->get()->row_array();

        return $cliente;
    }


    //Recebe clientes com varios Ids selecionados
    public function recebeClientesIds($ids, $id_setor_empresa)
    {
        $this->db->select('C.*, SEC.id_setor_empresa, SE.nome as SETOR, FP.forma_pagamento');
        $this->db->from('ci_clientes C');
        $this->db->join('ci_setores_empresa_cliente SEC', 'SEC.id_cliente = C.id', 'left');
        $this->db->join('ci_setores_empresa SE', 'SEC.id_setor_empresa = SE.id', 'left');
        $this->db->join('ci_forma_pagamento FP', 'FP.id = SEC.id_forma_pagamento', 'left');
        $this->db->where_in('C.id', $ids);
        $this->db->where('SEC.id_setor_empresa', $id_setor_empresa);
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->group_by('C.id, SEC.id_setor_empresa, FP.forma_pagamento');
        $this->db->order_by('C.cidade, C.nome');
        
        $query = $this->db->get();
        return $query->result_array();
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
        $this->db->select('C.id');
        $this->db->from('ci_clientes C');
        $this->db->join('ci_setores_empresa_cliente SEC', 'SEC.id_cliente = C.id', 'left');
        $this->db->where('SEC.id_forma_pagamento', $id);
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->get();

        return  $this->db->affected_rows() > 0;

    }

    public function recebeIdsClientes()
    {
        $this->db->select('id');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_clientes');
        return $query->result_array();
    }

}

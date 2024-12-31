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

        if (($filtro['rua'] ?? false) && $filtro['rua'] != 'all') {
            $this->db->like('C.rua', $filtro['rua']);
        }

        if (($filtro['nome'] ?? false)) {
            $nome = str_replace(' ', '', $filtro['nome']);
            $this->db->group_start()
                ->like("LOWER(REPLACE(REPLACE(C.nome, ' ', ''), 'áéíóú', 'aeiou'))", strtolower($nome), 'both')
                ->or_like("LOWER(REPLACE(REPLACE(C.rua, ' ', ''), 'áéíóú', 'aeiou'))", strtolower($nome), 'both')
                ->group_end();
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

    public function recebeNomeClientes()
    {
        $this->db->select('nome, id');
        $this->db->order_by('nome');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('status', 1);
        $query = $this->db->get('ci_clientes');
        return $query->result_array();
    }

    public function recebeTodosClientesColetados()
    {
        $this->db->select('C.*, ANY_VALUE(C.id)');
        $this->db->from('ci_clientes C');
        $this->db->where('C.status', 1);
        $this->db->join('ci_coletas CO', 'CO.id_cliente = C.id', 'RIGHT');
        $this->db->where('CO.status', 1);
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
        $this->db->where('cidade <>', '');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('cidade');
        $this->db->group_by('cidade');
        $query = $this->db->get('ci_clientes');
        return $query->result_array();
    }

    public function recebeRuasCidadeCliente()
    {
        $this->db->select('rua');

        $this->db->where('status', 1);
        $this->db->where("rua NOT IN ('', '-')");
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $this->db->distinct();

        $this->db->order_by('rua', 'ASC');

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
        $this->db->select('C.*, SEC.id_setor_empresa, MAX(SEC.observacao_pagamento) as observacao_pagamento, SE.nome as SETOR, FP.forma_pagamento, MAX(FP.id) as ID_FORMA_PAGAMENTO');
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

        $inserted_id = $this->db->insert_id();

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($inserted_id);
        }

        return $inserted_id ? $inserted_id : false;
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

    public function verificaArrayRecipienteCliente($id)
    {
        $this->db->select('C.nome as NOME_CLIENTE');

        $this->db->from('ci_recipiente_cliente RC');

        $this->db->where('RC.id_cliente', $id);
        $this->db->where('RC.id_empresa', $this->session->userdata('id_empresa'));

        $this->db->join('ci_clientes C', 'C.id = RC.id_cliente');

        $query = $this->db->get();

        return $query->row_array();
    }

    public function recebeClientesAprovacaoInativacao($limitarRegistros)
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

            if ($limitarRegistros) {

                $this->db->limit(200);
            }

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

    public function recebeEmailCliente($idCliente)
    {
        $this->db->select('email');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('id', $idCliente);
        $query = $this->db->get('ci_clientes');
        return $query->row_array();
    }

    public function recebeOrigemCadastroCliente(int $id_cliente): array
    {
        $this->db->select(
            'C.id, C.origem_cadastro, 
            IF(C.origem_cadastro = 1, F.nome, TPC.nome) as NOME_ORIGEM_CADASTRO'
        );
        $this->db->join('ci_tipo_origem_cadastro TPC', 'TPC.id = C.id_origem_cadastro', 'left');
        $this->db->join('ci_funcionarios F', 'F.id = C.id_origem_cadastro', 'left');
        $this->db->where('C.id', $id_cliente);
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get('ci_clientes C');

        return $query->row_array() ?? [];
    }

    public function recebeClientesSemAtividades($cookie_filtro_clientes, $limit, $page, $count = null)
    {
        $this->db->select('C.nome, C.telefone, C.cidade, C.id, C.criado_em AS CLIENTE_CRIADO_EM, CI.criado_em AS ULTIMA_COLETA, SE.nome as SETOR_EMPRESA, SE.id as ID_SETOR_EMPRESA');
        $this->db->from('ci_clientes AS C');
        $this->db->join('(SELECT id_cliente, MAX(criado_em) AS criado_em FROM ci_coletas WHERE coletado = 1 GROUP BY id_cliente) AS CI', 'CI.id_cliente = C.id', 'left');
        $this->db->join('ci_setores_empresa_cliente SEC', 'SEC.id_cliente = C.id', 'left');
        $this->db->join('ci_setores_empresa SE', 'SEC.id_setor_empresa = SE.id', 'left');
        $this->db->where('C.STATUS', 1);
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('((CI.criado_em < DATE_SUB(NOW(), INTERVAL 3 MONTH) AND CI.criado_em IS NOT NULL) OR (CI.criado_em IS NULL AND C.criado_em < DATE_SUB(NOW(), INTERVAL 3 MONTH)))', null, false);

        $filtro = json_decode($cookie_filtro_clientes, true);


        if (($filtro['cidade'] ?? false) && $filtro['cidade'] != 'all') {
            $this->db->where('C.cidade', $filtro['cidade']);
        }

        if (($filtro['setor-empresa'] ?? false) && $filtro['setor-empresa'] != 'all') {
            $this->db->where('SE.id', $filtro['setor-empresa']);
        }

        if ($filtro['nome'] ?? false) {
            $nome = $filtro['nome'];
            $this->db->where("LOWER(C.nome) COLLATE utf8mb4_unicode_ci LIKE LOWER('%$nome%')");
        }

        if (!$count) {
            $offset = ($page - 1) * $limit;
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();

        if ($count) {
            return $query->num_rows();
        }

        return $query->result_array();
    }

    public function recebeCidadesClientesSemAtividades()
    {
        $this->db->select('C.cidade');
        $this->db->from('ci_clientes AS C');
        $this->db->join('(SELECT id_cliente, MAX(criado_em) AS criado_em FROM ci_coletas WHERE coletado = 1 GROUP BY id_cliente) AS CI', 'CI.id_cliente = C.id', 'left');
        $this->db->where('C.STATUS', 1);
        $this->db->where('C.cidade <>', '');
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('((CI.criado_em < DATE_SUB(NOW(), INTERVAL 3 MONTH) AND CI.criado_em IS NOT NULL) OR (CI.criado_em IS NULL AND C.criado_em < DATE_SUB(NOW(), INTERVAL 3 MONTH)))', null, false);
        $this->db->group_by('C.cidade');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function editaVariosClientes($idsClientes, $dados) 
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where_in('id', $idsClientes);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_clientes', $dados);

        return $this->db->affected_rows() > 0;
    }

    public function recebeClientesFinais()
    {
        $this->db->select('C.nome, C.id');
        $this->db->from('ci_clientes AS C');
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('cliente_final', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function recebeDataObservacaoColetaCliente($idCliente)
    {
        $this->db->select('data_observacao_coleta');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('id', $idCliente);
        $query = $this->db->get('ci_clientes');
        return $query->row_array();
    }

}

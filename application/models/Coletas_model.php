<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coletas_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function insereColeta($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_coletas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
            $this->load->helper('cache_helper');
            limparCache('clientesinativar');
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeColetas()
    {
        $this->db->order_by('data_coleta', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get('ci_coletas');

        return $query->result_array();
    }

    public function recebeColeta($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get('ci_coletas');

        return $query->row_array();
    }
    
    public function recebeColetaRomaneio($cod_romaneio)
    {
        $this->db->where('cod_romaneio', $cod_romaneio);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_coletas');
        $coletas = $query->result_array();
    
        // Busca os nomes dos clientes
        $idsClientes = array_column($coletas, 'id_cliente');
        $idsClientes = array_unique($idsClientes);
        $this->db->where_in('id', $idsClientes);
        $clientes = $this->db->get('ci_clientes')->result_array();
        $mapaClientes = [];
        foreach ($clientes as $cliente) {
            $mapaClientes[$cliente['id']] = $cliente['nome'];
        }
    
        // Preparação para conversão de IDs para nomes nos campos específicos
        foreach ($coletas as &$coleta) {
            // Converte id_cliente para o nome do cliente
            $coleta['id_cliente'] = $mapaClientes[$coleta['id_cliente']] ?? 'Cliente Desconhecido';
    
            // Converte JSON para array PHP nos campos necessários
            $coleta['residuos_coletados'] = json_decode($coleta['residuos_coletados'], true) ?? [];
            $coleta['quantidade_coletada'] = json_decode($coleta['quantidade_coletada'], true) ?? [];
            $coleta['forma_pagamento'] = json_decode($coleta['forma_pagamento'], true) ?? [];
            $coleta['valor_pago'] = json_decode($coleta['valor_pago'], true) ?? [];
    
            // Substitui IDs por nomes nos residuos_coletados e forma_pagamento
            foreach ($coleta['residuos_coletados'] as &$idResiduo) {
                // Busca o nome do residuo pelo ID (substitua essa lógica pela busca real no seu banco de dados)
                $idResiduo = $this->buscarNomeResiduoPorId($idResiduo); // Função hipotética
            }
            unset($idResiduo); // Encerra a referência
    
            foreach ($coleta['forma_pagamento'] as &$idFormaPagamento) {
                // Busca o nome da forma de pagamento pelo ID (substitua essa lógica pela busca real no seu banco de dados)
                $idFormaPagamento = $this->buscarNomeFormaPagamentoPorId($idFormaPagamento); // Função hipotética
            }
            unset($idFormaPagamento); // Encerra a referência
        }
        unset($coleta); // Encerra a referência ao último item para evitar efeitos colaterais
    
        return $coletas;
    }
    
    // Exemplo de função para buscar o nome do resíduo por ID
    private function buscarNomeResiduoPorId($idResiduo)
    {
        $this->db->where('id', $idResiduo);
        $resultado = $this->db->get('ci_residuos')->row_array();
        return $resultado ? $resultado['nome'] : 'Resíduo Desconhecido';
    }
    
    // Exemplo de função para buscar o nome da forma de pagamento por ID
    private function buscarNomeFormaPagamentoPorId($idFormaPagamento)
    {
        $this->db->where('id', $idFormaPagamento);
        $resultado = $this->db->get('ci_forma_pagamento')->row_array();
        return $resultado ? $resultado['forma_pagamento'] : 'Forma de Pagamento Desconhecida';
    }
    
    
    
    public function recebeIdColetasClientes($id_cliente, $data_inicio, $data_fim, $residuo = null)
    {
        $this->db->select('id');
        $this->db->from('ci_coletas');
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('data_coleta >=', $data_inicio);
        $this->db->where('data_coleta <=', $data_fim);
        $this->db->where('coletado', 1);

        if ($residuo) {

            $this->db->like('residuos_coletados', '"' . $residuo . '"');
        }

        $this->db->order_by('data_coleta');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeIdColetasClientesAll($id_cliente, $data_inicio, $data_fim)
    {
        $this->db->select('id');
        $this->db->from('ci_coletas');
        $this->db->where_in('id_cliente', $id_cliente);
        $this->db->where('data_coleta >=', $data_inicio);
        $this->db->where('data_coleta <=', $data_fim);
        $this->db->order_by('id_cliente, data_coleta');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();

        // $result_array = [];

        // foreach ($query->result_array() as $row) {
        //     if (!isset($result_array[$row['id_cliente']])) {
        //         $result_array[$row['id_cliente']] = [];
        //     }

        //     $result_array[$row['id_cliente']][] = $row['id'];
        // }

        return $query->result_array();
    }

    public function recebeColetasCliente($idCliente)
    {
        $this->db->select('ci_coletas.*, ci_coletas.id as ID_COLETA, ci_funcionarios.nome as nome_responsavel');
        $this->db->from('ci_coletas');
        $this->db->join('ci_funcionarios', 'ci_coletas.id_responsavel = ci_funcionarios.id', 'left');
        $this->db->where('ci_coletas.id_cliente', $idCliente);
        $this->db->where('ci_coletas.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('data_coleta', 'desc');
        $this->db->group_by('ci_coletas.id');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeColetaCliente($idColeta)
    {

        $this->db->select('CO.*, C.*, FU.nome as nome_responsavel');
        $this->db->from('ci_coletas as CO');
        $this->db->join('ci_clientes C', 'CO.id_cliente = C.id', 'left');
        $this->db->join('ci_funcionarios FU', 'CO.id_responsavel = FU.id', 'left');
        $this->db->where('CO.id', $idColeta);

        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();

        return $query->row_array();
    }
}

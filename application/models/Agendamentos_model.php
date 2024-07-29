<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agendamentos_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    /**
     * Recebe os agendamentos atrasados com base nas datas e setor especificados.
     *
     * @param string $dataInicioFormatada Data de início formatada (YYYY-MM-DD)
     * @param string $dataFimFormatada Data de fim formatada (YYYY-MM-DD)
     * @param string|null $setorEmpresa ID do setor da empresa ou 'todos' para todos os setores
     * @param string|null $cidade ID da cidade do agendamento ou 'todas' para qualquer cidade
     * @param string|null $etiqueta ID da etiqueta do agendamento ou 'todas' para qualquer etiqueta
     * @return array Resultados da consulta como um array associativo
     */
    public function recebeAgendamentosAtrasados(string $dataInicioFormatada, string $dataFimFormatada, ?string $setorEmpresa, ?string $cidade, ?string $etiqueta): array
    {
        $this->db->select('
            MAX(C.cidade) as cidade, 
            MAX(C.telefone) as telefone, 
            MAX(C.nome) as NOME_CLIENTE, 
            MAX(SE.nome) as NOME_SETOR,
            MAX(A.data_coleta) as data_coleta,
            MAX(A.id_setor_empresa) as id_setor_empresa,
            MAX(A.id_cliente) as id_cliente,
            MAX(A.id) as ID_AGENDAMENTO,
            MAX(EC.id_etiqueta) as ID_ETIQUETA,
            MAX(E.nome) as NOME_ETIQUETA
        ');
        $this->db->from('ci_agendamentos A');
        $this->db->join('ci_clientes C', 'A.id_cliente = C.id', 'left');
        $this->db->join('ci_setores_empresa SE', 'A.id_setor_empresa = SE.id', 'left');
        $this->db->join('ci_etiqueta_cliente EC', 'EC.id_cliente = C.id', 'left');
        $this->db->join('ci_etiquetas E', 'E.id = EC.id_etiqueta', 'left');
        $this->db->where('A.data_coleta >=', $dataInicioFormatada);
        $this->db->where('A.data_coleta <=', $dataFimFormatada);
        $this->db->where('A.status', 0);
        $this->db->where('A.id_empresa', $this->session->userdata('id_empresa'));

        // Adiciona a cláusula do setor apenas se $setor não for null
        if ($setorEmpresa !== 'todos' && $setorEmpresa !== null) {
            $this->db->where('A.id_setor_empresa', $setorEmpresa);
        }

        // Adiciona a cláusula de cidade apenas se $cidade não for null
        if ($cidade !== 'todas' && $cidade !== null) {
            $this->db->where('C.cidade', $cidade);
        }

        // Adiciona a cláusula de etiqueta apenas se $etiqueta não for null
        if ($etiqueta !== 'todas' && $etiqueta !== null) {
            $this->db->where('EC.id_etiqueta', $etiqueta);
        }

        $this->db->group_by('A.id_cliente, A.data_coleta');
        $this->db->order_by('A.data_coleta');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function recebeAgendamentos($anoAtual, $mesAtual)
    {
        $this->db->select('data_coleta, prioridade, status, COUNT(*) AS total_agendamento');
        $this->db->from('ci_agendamentos');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('YEAR(data_coleta)', $anoAtual);
        $this->db->where('MONTH(data_coleta)', $mesAtual);
        $this->db->group_by('data_coleta, prioridade, status');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function recebeAgendamentosCliente($id_cliente, $data_coleta)
    {
        $this->db->select('id, data_coleta, status');
        $this->db->from('ci_agendamentos');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('id_cliente', $id_cliente); // Adiciona a condição para o id_cliente
        $this->db->where('status', 0); // Adiciona a condição para o status igual a 0
        $this->db->where('data_coleta <', $data_coleta);
        $this->db->group_by('id');
        $this->db->group_by('data_coleta');
        $this->db->group_by('status');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function recebeUltimoAgendamentoCliente($id_cliente)
    {
        $this->db->select('periodo_coleta, hora_coleta');
        $this->db->from('ci_agendamentos');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('id_cliente', $id_cliente);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function obtemAgendamentosPorDataProxima($id_cliente, $data_proxima)
    {
        $this->db->select('A.id, A.periodo_coleta, Se.nome as SETOR');
        $this->db->from('ci_agendamentos A');
        $this->db->join('ci_setores_empresa SE', 'A.id_setor_empresa = SE.id', 'inner');
        $this->db->where('A.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('A.id_cliente', $id_cliente);
        $this->db->where('A.data_coleta', $data_proxima);

        $query = $this->db->get();
        return $query->result_array();
    }


    public function insereAgendamento($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_agendamentos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaStatusAgendamento($id_cliente, $data_coleta, $dados, $idSetorEmpresa)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('id_setor_empresa', $idSetorEmpresa);
        $this->db->where('status', 0);
        $this->db->where('data_coleta <', $data_coleta);
        $this->db->update('ci_agendamentos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id_cliente);
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaAgendamento($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_agendamentos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaAgendamentoData($id_cliente, $data_agendamento, $dados, $idSetorEmpresa)
    {

        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('data_coleta', $data_agendamento);
        $this->db->where('id_setor_empresa', $idSetorEmpresa);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $this->db->update('ci_agendamentos', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id_cliente); // Corrigi para usar $id_cliente em vez de $id
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaAgendamentosAtrasados($id_cliente, $id_agendamento, $nova_data)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $dados['data_coleta'] = $nova_data;
        $dados['prioridade'] = 0;

        $this->db->where('id', $id_agendamento);

        $this->db->update('ci_agendamentos', $dados);

        if ($this->db->affected_rows() > 0) {
            $this->Log_model->insereLog($id_cliente);
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeClientesAgendados($dataColeta, $prioridade, $status)
    {
        $this->db->select('A.*, C.nome, C.rua, C.numero, C.cidade, C.telefone, SE.nome as SETOR');
        $this->db->from('ci_agendamentos A');
        $this->db->join('ci_clientes C', 'A.id_cliente = C.id', 'inner');
        $this->db->join('ci_setores_empresa SE', 'A.id_setor_empresa = SE.id', 'inner');
        $this->db->where('A.data_coleta', $dataColeta);
        $this->db->where('A.prioridade', $prioridade);
        $this->db->where('A.status', $status);
        $this->db->where('A.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('SE.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeClienteAgendado($idCLiente, $dataColeta, $idSetorEmpresa)
    {
        $this->db->where('data_coleta', $dataColeta);
        $this->db->where('id_cliente', $idCLiente);
        $this->db->where('id_setor_empresa', $idSetorEmpresa);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_agendamentos');

        return $query->row_array();
    }

    public function recebeAgendamentoPrioridade($dataColeta)
    {
        $this->db->select('id_cliente');
        $this->db->from('ci_agendamentos');
        $this->db->where('data_coleta', $dataColeta);
        $this->db->where('prioridade', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function cancelaAgendamentoCliente($idAgendamento)
    {
        $this->db->where('id', $idAgendamento);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_agendamentos');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($idAgendamento);
        }

        return $this->db->affected_rows() > 0;
    }

    public function verificaColetaRealizada($dataColeta)
    {
        $this->db->select('coletado');
        $this->db->where('data_coleta', $dataColeta);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_coletas');

        return $query->result_array();
    }

    public function ultimaColetaCliente($id)
    {
        $this->db->select('data_coleta');
        $this->db->where('id_cliente', $id);
        $this->db->where('status', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('data_coleta', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('ci_agendamentos');

        return $query->row()->data_coleta ?? null;
    }

    public function proximaColetaCliente($id)
    {
        $this->db->select('data_coleta');
        $this->db->where('id_cliente', $id);
        $this->db->where('status', 0);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->order_by('data_coleta', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('ci_agendamentos');

        return $query->row()->data_coleta ?? null;
    }

    public function contaAgendamentoCLiente($id)
    {
        $this->db->where('id_cliente', $id);
        $this->db->where('status', 0);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_agendamentos');

        return $query->num_rows();
    }

    public function contaAgendamentoAtrasadoCLiente($id)
    {
        $this->db->where('id_cliente', $id);
        $this->db->where('status', 0);
        $this->db->where('data_coleta <', date('Y-m-d'));
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_agendamentos');

        return $query->num_rows();
    }

    public function contaAgendamentoFinalizadoCLiente($id)
    {
        $this->db->where('id_cliente', $id);
        $this->db->where('status', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_agendamentos');

        return $query->num_rows();
    }

    public function recebeObservacaoAgendamentoCliente($data_romaneio)
    {
        $this->db->select('observacao, id_cliente');
        $this->db->where_in('data_coleta', $data_romaneio);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_agendamentos');

        return $query->result_array();
    }

    public function recebeProximosAgendamentosCliente($idCliente, $dataColeta, $excluindoCliente = false)
    {
        // Seleção dos campos corrigida com operador ternário
        $this->db->select('C.nome, C.id as ID_CLIENTE, A.data_coleta' . ($excluindoCliente ? ', MAX(A.id_setor_empresa) AS id_setor_empresa' : ', A.id_setor_empresa'));
        $this->db->from('ci_agendamentos A');
        $this->db->join('ci_clientes C', 'A.id_cliente = C.id', 'inner');
        $this->db->where('A.id_cliente', $idCliente);
        $this->db->where('A.data_coleta >=', $dataColeta);

        if (!$excluindoCliente) {
            // Condições adicionais se não estiver excluindo cliente
            $this->db->where('A.status', 0);
            $this->db->where('A.data_coleta <=', date('Y-m-d', strtotime($dataColeta . ' +30 days')));
        } else {
            // Condições se estiver excluindo cliente
            $this->db->where_in('A.status', [2, 0]);
        }

        $this->db->where('A.id_empresa', $this->session->userdata('id_empresa'));
        // Ajuste na cláusula GROUP BY com operador ternário
        $this->db->group_by('C.nome, A.data_coleta' . (!$excluindoCliente ? ', id_setor_empresa' : ''));

        $query = $this->db->get();

        return $query->result_array();
    }

    public function cancelaProximosAgendamentosCliente($dataAgendamento, $idCliente)
    {
        $this->db->where('id_cliente', $idCliente);
        $this->db->where('data_coleta', $dataAgendamento);
        $this->db->where('status', 0);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_agendamentos');

        return $this->db->affected_rows() > 0;
    }

    public function cancelaAgendamentosFuturosCliente($idCliente)
    {
        $this->db->where('id_cliente', $idCliente);
        $this->db->where('status !=', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_agendamentos');

        return $this->db->affected_rows() > 0;
    }
}

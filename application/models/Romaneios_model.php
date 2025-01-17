<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Romaneios_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function insereRomaneio($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_romaneios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaRomaneioCodigo($codigo, $dados)
    {
        $this->db->where('codigo', $codigo);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_romaneios', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($codigo);
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeRomaneioCod($codigo)
    {
        $this->db->select('R.*, F.nome as RESPONSAVEL, V.placa');
        $this->db->from('ci_romaneios R');
        $this->db->join('ci_funcionarios F', 'F.id = R.id_responsavel', 'left');
        $this->db->join('ci_veiculos V', 'V.id = R.id_veiculo', 'left');
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('R.codigo', $codigo);

        $query = $this->db->get();


        return $query->row_array();
    }

    public function recebeRomaneioPorData($dataRomaneio)
    {
        $this->db->select('R.data_romaneio, R.id as ID_ROMANEIO, R.criado_em, R.codigo, R.status, R.prestar_conta, F.nome as RESPONSAVEL, F.id as ID_RESPONSAVEL, F.saldo, R.id_setor_empresa');
        $this->db->from('ci_romaneios R');
        $this->db->join('ci_funcionarios F', 'F.id = R.id_responsavel', 'INNER');
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('R.data_romaneio', $dataRomaneio);
        $this->db->order_by('criado_em', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeUltimosRomaneios($codRomaneio = null)
    {
        $this->db->select('R.data_romaneio, MAX(R.id) as ID_ROMANEIO, MAX(R.criado_em) as criado_em, MAX(F.nome) as RESPONSAVEL, MAX(R.id_setor_empresa) as id_setor_empresa');
        $this->db->from('ci_romaneios R');
        $this->db->join('ci_funcionarios F', 'F.id = R.id_responsavel', 'INNER');
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));

        if ($codRomaneio) {
            $this->db->where('R.codigo', $codRomaneio);
        } else {
            $this->db->where('R.data_romaneio >=', date('Y-m-d', strtotime('-55 days')));
        }

        $this->db->order_by('data_romaneio', 'DESC');
        $this->db->group_by('R.data_romaneio');
        $query = $this->db->get();

        return $query->result_array();
    }


    public function filtrarClientesRomaneio($dados, $setorEmpresa)
    {
        $this->db->select('C.nome AS CLIENTE, C.id AS ID_CLIENTE, C.cidade, ANY_VALUE(A.data_coleta), ANY_VALUE(E.nome) AS ETIQUETA');
        $this->db->from('ci_clientes C');
        $this->db->join('ci_agendamentos A', 'A.id_cliente = C.id', 'left');
        $this->db->join('ci_etiqueta_cliente EC', 'EC.id_cliente = C.id', 'left');
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id', 'left');
        $this->db->join('ci_setores_empresa_cliente SEC', 'C.id = SEC.id_cliente', 'left');

        $this->db->where('SEC.id_setor_empresa', $setorEmpresa);

        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));

        $this->db->where('C.status', 1);


        if ($dados['cidades']) {
            $this->db->where_in('C.cidade', $dados['cidades']);
        }

        if ($dados['data_coleta']) {
            $this->db->where('A.data_coleta', $dados['data_coleta']);
        }

        if ($dados['ids_etiquetas']) {
            $this->db->where_in('EC.id_etiqueta', $dados['ids_etiquetas']);
        }

        $this->db->group_by('C.id, C.cidade, C.nome');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeIdsClientesRomaneios($codRomaneio)
    {
        $this->db->select('R.clientes, R.id');
        $this->db->from('ci_romaneios R');
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('R.codigo', $codRomaneio);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function deletaRomaneio($id)
    {
        $this->db->where('id', $id);
        $this->db->where('status', 0);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_romaneios');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeDatasRomaneiosFuncionario($idFuncionario, $dataRomaneio)
    {
        $this->db->select('R.data_romaneio');
        $this->db->from('ci_romaneios R');
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('R.id_responsavel', $idFuncionario);
        $this->db->where('R.data_romaneio', $dataRomaneio);

        $query = $this->db->get();

        return $query->num_rows() > 0;
    }
}

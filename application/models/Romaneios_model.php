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
        $this->db->where('codigo', $codigo);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get('ci_romaneios');

        return $query->row_array();
    }

    public function recebeUltimosRomaneios()
    {
        $this->db->select('R.*, F.nome as RESPONSAVEL, F.id as ID_RESPONSAVEL');
        $this->db->from('ci_romaneios R');
        $this->db->join('ci_funcionarios F', 'F.id = R.id_responsavel', 'INNER');
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->limit(60);
        $this->db->order_by('R.criado_em', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function filtrarClientesRomaneio($dados)
    {
        $this->db->select('C.nome AS CLIENTE, C.id AS ID_CLIENTE, C.cidade, A.data_coleta, ANY_VALUE(E.nome) AS ETIQUETA');
        $this->db->from('ci_clientes C');
        $this->db->join('ci_agendamentos A', 'A.id_cliente = C.id', 'inner');
        $this->db->join('ci_etiqueta_cliente EC', 'EC.id_cliente = C.id', 'left');
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id', 'left');    
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('A.id_empresa', $this->session->userdata('id_empresa'));

        $this->db->where('A.data_coleta', $dados['data_coleta']);

        if ($dados['cidades']) {
            $this->db->where_in('C.cidade', $dados['cidades']);
        }

        if ($dados['ids_etiquetas']) {
            $this->db->where_in('EC.id_etiqueta', $dados['ids_etiquetas']);
        }

        $this->db->group_by('C.id');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeIdsClientesRomaneios($codRomaneio)
    {
        $this->db->select('R.clientes');
        $this->db->from('ci_romaneios R');
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('R.codigo', $codRomaneio);
        $query = $this->db->get();

        return $query->row_array();
    }

}

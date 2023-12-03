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

    public function recebeRomaneioCod($codigo)
    {
        $this->db->where('codigo', $codigo);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get('ci_romaneios');

        return $query->row_array();
    }

    public function recebeUltimosRomaneios()
    {
        $this->db->select('R.*, M.nome as MOTORISTA');
        $this->db->from('ci_romaneios R');
        $this->db->join('ci_motoristas M', 'M.id = R.id_motorista', 'INNER');
        $this->db->where('R.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->limit(90);
        $this->db->order_by('R.data_romaneio', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }
}

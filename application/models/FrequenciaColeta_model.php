<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FrequenciaColeta_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeFrequenciasColeta()
    {
        $this->db->order_by('frequencia', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_frequencia_coleta');

        return $query->result_array();
    }

    public function recebeFrequenciaColetaNome($frequencia,$dia)
    { 
        $this->db->where('frequencia', $frequencia);
        $this->db->where('dia', $dia);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_frequencia_coleta');

        return $query->row_array();
    }
    public function recebeFrequenciaColeta($id)
    { 
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_frequencia_coleta');

        return $query->row_array();
    }

    public function recebeFrequenciaColetaDia($dia)
    {
        $this->db->where('dia', $dia);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_frequencia_coleta');

        return $query->row_array();
    }

    public function insereFrequenciaColeta($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_frequencia_coleta', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaFrequenciaColeta($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_frequencia_coleta', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaFrequenciaColeta($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_frequencia_coleta');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function verificaFrequenciaColetaCliente($id)
    {
        $this->db->where('id_frequencia_coleta', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->get('ci_clientes');

        return $this->db->affected_rows() > 0;
    }
}

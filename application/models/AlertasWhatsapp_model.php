<?php
defined('BASEPATH') or exit('No direct script access allowed');


class AlertasWhatsapp_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeAlertasWhatsApp($statusAlerta = null)
    {
        $this->db->order_by('titulo', 'DESC');
        if($statusAlerta)
        {
            $this->db->where('status', 1);
        }
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_alertas_whatsapp');

        return $query->result_array();
    }


    public function recebeAlertaWhatsapp($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_alertas_whatsapp');

        return $query->row_array();
    }

    public function recebeAlertaWhatsappTitulo($titulo, $id)
    {
        $this->db->where('titulo', $titulo);
        $this->db->where('id <>', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_alertas_whatsapp');

        return $query->row_array();
    }

    public function insereAlertaWhatsapp($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_alertas_whatsapp', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaAlertaWhatsapp($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_alertas_whatsapp', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaAlertaWhatsapp($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_alertas_whatsapp');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

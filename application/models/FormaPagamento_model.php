<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FormaPagamento_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeFormasPagamento()
    {
        $this->db->select('FP.*, TP.nome AS TIPO_PAGAMENTO');
        $this->db->order_by('forma_pagamento', 'DESC');
        $this->db->join('ci_tipo_pagamento TP', 'TP.id = FP.id_tipo_pagamento', 'left');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_forma_pagamento FP');
    
        return $query->result_array();
    }

    public function recebeFormaPagamento($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_forma_pagamento');

        return $query->row_array();
    }

    public function recebeFormaPagamentoNome($nome, $id)
    {
        $this->db->where('forma_pagamento', $nome);
        $this->db->where('id <>', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get('ci_forma_pagamento');

        return $query->row_array();
    }

    public function recebeTipoFormasPagamentos($ids)
    {
        $result = array();
    
        foreach ($ids as $id) {
            $this->db->select('id_tipo_pagamento');
            $this->db->where('id', $id);
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
            $query = $this->db->get('ci_forma_pagamento');
    
            $row = $query->row_array();
            if (!empty($row)) {
                $result[] = $row['id_tipo_pagamento'];
            }
        }
    
        return $result;
    }
    


    public function insereFormaPagamento($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_forma_pagamento', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaFormaPagamento($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_forma_pagamento', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaFormaPagamento($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_forma_pagamento');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }
}

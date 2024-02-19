<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SetoresEmpresaCliente_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeSetoresEmpresaClientes()
    {
        $this->db->select('SEC.id_setor_empresa, SE.nome');
        $this->db->from('ci_setores_empresa_cliente SEC');
        $this->db->join('ci_clientes C', 'SEC.id_cliente = C.id', 'inner');
        $this->db->join('ci_setores_empresa SE', 'SEC.id_setor_empresa = SE.id', 'inner');
        $this->db->where('SEC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('SE.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->group_by('SEC.id_setor_empresa');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeSetoresEmpresaCliente($id)
    {
        $this->db->select('SEC.*, SE.nome');
        $this->db->from('ci_setores_empresa_cliente SEC');
        $this->db->join('ci_clientes C', 'SEC.id_cliente = C.id', 'inner');
        $this->db->join('ci_setores_empresa SE', 'SEC.id_setor_empresa = SE.id', 'inner');
        $this->db->where('SEC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('SE.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('SEC.id_cliente', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeIdSetorEmpresaCliente($id, $id_cliente)
    {
        $this->db->select('SEC.*, SE.nome');
        $this->db->from('ci_setores_empresa_cliente SEC');
        $this->db->join('ci_setores_emoresa SE', 'SEC.id_setor_empresa = SE.id', 'inner');
        $this->db->where('SEC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('SE.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('SEC.id_cliente', $id_cliente);
        $this->db->where('SEC.id_setor_empresa', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function insereSetorEmpresaCliente($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_setores_empresa_cliente', $dados);

        $inseridoId = $this->db->insert_id(); // Pega o ID inserido

        if ($inseridoId) {
            $this->Log_model->insereLog($inseridoId);
        }

        return $inseridoId; // Retorna o ID inserido ou 0 se não foi inserido
    }

    public function deletaSetorEmpresaCliente($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_setores_empresa_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaIdSetorEmpresaCliente($id)
    {
        $this->db->where('id_setor_empresa', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->delete('ci_setores_empresa_cliente');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeClientesSetoresEmpresa($id_setor_empresa)
    {
        $this->db->select('SEC.id_setor_empresa, C.id as ID_CLIENTE, C.nome AS CLIENTE');
        $this->db->from('ci_setores_empresa_cliente SEC');
        $this->db->join('ci_clientes C', 'SEC.id_cliente = C.id', 'inner');
        $this->db->where('SEC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('SEC.id_setor_empresa', $id_setor_empresa);
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $query = $this->db->get();

        return $query->result_array();
    }

    // busca os clientes por etiqueta de um setor específico
    public function recebeClientesEtiquetaSetoresEmpresa($id_setor_empresa)
    {
        $this->db->select('SEC.id_setor_empresa, EC.id_etiqueta, E.nome');
        $this->db->from('ci_setores_empresa_cliente SEC');
        $this->db->join('ci_etiqueta_cliente EC', 'SEC.id_cliente = EC.id_cliente', 'inner');
        $this->db->join('ci_etiquetas E', 'EC.id_etiqueta = E.id', 'left');
        $this->db->where('SEC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('SEC.id_setor_empresa', $id_setor_empresa);
        $this->db->where('EC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->group_by('SEC.id_setor_empresa, EC.id_etiqueta');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeTodosSetoresEmpresaClientes()
    {
        $this->db->select('SEC.id_setor_empresa, SE.nome');
        $this->db->from('ci_setores_empresa_cliente SEC');
        $this->db->join('ci_setores_empresa SE', 'SEC.id_setor_empresa = SE.id', 'inner');
        $this->db->where('SEC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('SE.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->group_by('SEC.id_setor_empresa, SE.nome');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function verificaSetorEmpresaCliente($id)
    {
        $this->db->select('SEC.id_setor_empresa, GROUP_CONCAT(DISTINCT SE.nome) as nomes_setores');
        $this->db->from('ci_setores_empresa_cliente SEC');
        $this->db->where_in('SEC.id_setor', $id);
        $this->db->where('SEC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->join('ci_setores_empresa SE', 'SE.id = SEC.id_setor_empresa', 'left');
        $this->db->group_by('SEC.id_setor_empresa');

        $query = $this->db->get();

        $setorEmpresaVinculado = $query->result_array();

        return $setorEmpresaVinculado;
    }
    public function editaSetorEmpresaCliente($id, $idCliente, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id_cliente', $idCliente);
        $this->db->where('id_setor_empresa', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_setores_empresa_cliente', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
        }

        return $this->db->affected_rows() > 0;
    }

    // busca os clientes por cidade de um setor específico
    public function recebeCidadesClientesSetoresEmpresa($id_setor_empresa)
    {
        $this->db->select('SEC.id_setor_empresa, C.cidade');
        $this->db->from('ci_setores_empresa_cliente SEC');
        $this->db->join('ci_clientes C', 'SEC.id_cliente = C.id', 'inner');
        $this->db->where('SEC.id_setor_empresa', $id_setor_empresa);
        $this->db->where('SEC.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->group_by('SEC.id_setor_empresa, C.cidade');
        $query = $this->db->get();

        return $query->result_array();
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Dicionario_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
        $this->load->helper('cache_helper');
    }

    public function recebeDicionarioGlobal($cookie_filtro_dicionario, $limit, $page, $count = null)
    {
        $filtro = json_decode($cookie_filtro_dicionario, true);

        //para filtrar de maneira mais abrangente sem precisar ser um valor exato - LOWER para ficar case-insensitive em SQL e strtolower para transformar a pesquisa realizada
        if ($filtro['chave'] ?? false) {
            $this->db->like('LOWER(chave)', strtolower($filtro['chave']), 'none');
        }

        if (!$count) {
            $offset = ($page - 1) * $limit;
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get('ci_dicionario');

        if ($count) {
            return $query->num_rows();
        }

        return $query->result_array();
    }


    public function recebeIdDicionarioGlobal($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('ci_dicionario');

        return $query->row_array();
    }

    public function recebeDicionarioGlobalChave($chave, $id)
    {
        $this->db->where('chave', $chave);
        $this->db->where('id <>',  $id);
        $this->db->get('ci_dicionario');

        return $this->db->affected_rows() > 0;
    }

    public function insereDicionarioGlobal($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_dicionario', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
            limparCache('chaves');
        }

        return $this->db->affected_rows() > 0;
    }

    public function editaDicionarioGlobal($id, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->update('ci_dicionario', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
            limparCache('chaves');
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeDicionario($chave)
    {
        $this->load->driver('cache', array('adapter' => 'file'));

        $dicionario = $this->cache->get('chaves/chave_' . $chave);

        if ($dicionario === FALSE) {
            $this->db->select('valor_ptbr, valor_en');
            $this->db->where('chave', $chave);
            $query = $this->db->get('ci_dicionario');
            $dicionario = $query->row_array();
            if ($dicionario) {
                $this->cache->save('chaves/chave_' . $chave, $dicionario, 864000); // 10 dias
            }
        }

        return $dicionario;
    }


    public function recebeDicionarioEmpresas($chave)
    {
        $this->load->driver('cache', array('adapter' => 'file'));

        $dicionario_empresa = $this->cache->get('chaves/chave_' . $chave . '_empresa_' . $this->session->userdata('id_empresa'));

        if ($dicionario_empresa === FALSE) {
            $this->db->select('valor_ptbr, valor_en');
            $this->db->where('chave', $chave);
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
            $query = $this->db->get('ci_dicionario_empresas');
            $dicionario_empresa = $query->row_array();

            if ($dicionario_empresa) {
                $this->cache->save('chaves/chave_' . $chave . '_empresa_' . $this->session->userdata('id_empresa'), $dicionario_empresa, 864000); // 10 dias
            }
        }

        return $dicionario_empresa;
    }

    public function deletaDicionarioGlobal($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ci_dicionario');

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($id);
            limparCache('chaves');
        }

        return $this->db->affected_rows() > 0;
    }
}

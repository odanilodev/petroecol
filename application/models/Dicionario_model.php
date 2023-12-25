<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Dicionario_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeDicionario($chave)
    {
        $this->load->driver('cache', array('adapter' => 'file'));

        $dicionario = $this->cache->get('chave_' . $chave);

        if ($dicionario === FALSE) {
            $this->db->select('valor_ptbr, valor_en');
            $this->db->where('chave', $chave);
            $query = $this->db->get('ci_dicionario');
            $dicionario = $query->row_array();
            if ($dicionario) {
                $this->cache->save('chave_' . $chave, $dicionario, 864000); // 10 dias
            }
        }

        return $dicionario;
    }


    public function recebeDicionarioEmpresas($chave)
    {
        $this->load->driver('cache', array('adapter' => 'file'));

        $dicionario_empresa = $this->cache->get('chave_' . $chave . '_empresa_' . $this->session->userdata('id_empresa'));

        if ($dicionario_empresa === FALSE) {
            $this->db->select('valor_ptbr, valor_en');
            $this->db->where('chave', $chave);
            $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
            $query = $this->db->get('ci_dicionario_empresas');
            $dicionario_empresa = $query->row_array();

            if ($dicionario_empresa) {
                $this->cache->save('chave_' . $chave . '_empresa_' . $this->session->userdata('id_empresa'), $dicionario_empresa, 864000); // 10 dias
            }
        }

        return $dicionario_empresa;
    }

    private function limparCacheDicionario() {
        $this->load->driver('cache', array('adapter' => 'file'));
        $this->cache->clean();
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Afericao_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function recebeAfericoes($cookie_filtro_clientes, $limit, $page, $count = null)
    {
        $filtro = json_decode($cookie_filtro_clientes, true);

        $this->db->select('C.cod_romaneio, MAX(id_setor_empresa) as id_setor_empresa, MAX(C.id) as ID_COLETA, MAX(C.data_coleta) as data_coleta,  MAX(C.aferido) as aferido, MAX(F.id) as ID_FUNCIONARIO, MAX(F.nome) as nome, MAX(F.saldo) as saldo, MAX(T.nome) as TRAJETO, MAX(T.id) as ID_TRAJETO');
        $this->db->from('ci_coletas C');
        $this->db->join('ci_funcionarios F', ' C.id_responsavel = F.id', 'LEFT');
        $this->db->join('ci_trajetos T', ' C.id_trajeto = T.id', 'LEFT');

        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('C.coletado', 1);
        $this->db->where('C.cod_romaneio <>', '');

        if ($filtro['codigo'] ?? false) {
            $codigo = $filtro['codigo'];
            $this->db->where("cod_romaneio LIKE '%$codigo%'");
        }

        if (!$count) {
            $offset = ($page - 1) * $limit;
            $this->db->limit($limit, $offset);
        }

        $this->db->group_by('C.cod_romaneio');
        
        $this->db->order_by('MAX(C.data_coleta)', 'DESC');

        $query = $this->db->get();

        if ($count) {
            return $query->num_rows();
        }

        return $query->result_array();

    }

    public function recebeAfericao () 
    {

    }

    public function insereAfericao($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert('ci_afericao', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
        }

        return $this->db->affected_rows() > 0;
    }

   
}

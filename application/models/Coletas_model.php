<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coletas_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Log_model');
    }

    public function insereColeta($dados)
    {
        $dados['criado_em'] = date('Y-m-d H:i:s');
        $this->db->insert('ci_coletas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($this->db->insert_id());
            $this->load->helper('cache_helper');
            limparCache('clientesinativar');
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeColetas()
    {
        $this->db->order_by('data_coleta', 'DESC');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get('ci_coletas');

        return $query->result_array();
    }

    public function recebeColeta($id)
    {
        $this->db->where('id', $id);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get('ci_coletas');

        return $query->row_array();
    }

    public function recebeColetaRomaneio($codRomaneio)
    {
        $this->db->select('ci_coletas.*, ci_funcionarios.nome as nome_responsavel, ci_clientes.nome as nome_cliente');
        $this->db->from('ci_coletas');
        $this->db->join('ci_funcionarios', 'ci_coletas.id_responsavel = ci_funcionarios.id', 'left');
        $this->db->join('ci_clientes', 'ci_coletas.id_cliente = ci_clientes.id', 'left');
        $this->db->where('ci_coletas.cod_romaneio', $codRomaneio);
        $this->db->where('ci_coletas.id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();

        return $query->result_array();
    }


    public function recebeIdColetasClientes($id_cliente, $data_inicio, $data_fim, $residuo = null)
    {
        $this->db->select('id');
        $this->db->from('ci_coletas');
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('data_coleta >=', $data_inicio);
        $this->db->where('data_coleta <=', $data_fim);
        $this->db->where('coletado', 1);
        $this->db->where('status', 1);


        if ($residuo) {

            $this->db->like('residuos_coletados', '"' . $residuo . '"');
        }

        $this->db->order_by('data_coleta');
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeIdColetasClientesAll($id_cliente, $data_inicio, $data_fim)
    {
        $this->db->select('id');
        $this->db->from('ci_coletas');
        $this->db->where_in('id_cliente', $id_cliente);
        $this->db->where('data_coleta >=', $data_inicio);
        $this->db->where('data_coleta <=', $data_fim);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('coletado', 1);
        $this->db->where('status', 1);
        $this->db->order_by('id_cliente, data_coleta');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeColetasCliente($idCliente)
    {
        $this->db->select('SE.nome AS SETOR_COLETA, CO.*, CO.id AS ID_COLETA, F.nome AS nome_responsavel, SE2.nome AS SETOR_NOVA_COLETA');
        $this->db->from('ci_coletas CO');
        $this->db->join('ci_funcionarios F', 'CO.id_responsavel = F.id', 'left');
        $this->db->join('ci_romaneios R', 'CO.cod_romaneio = R.codigo', 'left');
        $this->db->join('ci_setores_empresa SE', 'R.id_setor_empresa = SE.id', 'left');
        $this->db->join('ci_setores_empresa SE2', 'CO.id_setor_empresa = SE2.id', 'left');
        $this->db->where('CO.id_cliente', $idCliente);
        $this->db->where('CO.id_empresa', $this->session->userdata('id_empresa'));
        $this->db->where('CO.status', 1);
        $this->db->order_by('CO.data_coleta', 'desc');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function recebeColetaCliente($idColeta)
    {

        $this->db->select('CO.*, CO.observacao as OBSERVACAO_COLETA, C.*, FU.nome as nome_responsavel');
        $this->db->from('ci_coletas as CO');
        $this->db->join('ci_clientes C', 'CO.id_cliente = C.id', 'left');
        $this->db->join('ci_funcionarios FU', 'CO.id_responsavel = FU.id', 'left');
        $this->db->where('CO.id', $idColeta);

        $this->db->where('C.id_empresa', $this->session->userdata('id_empresa'));

        $query = $this->db->get();

        return $query->row_array();
    }

    public function editaColeta($idColeta, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('id', $idColeta);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_coletas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($idColeta);
        }

        return $this->db->affected_rows() > 0;
    }

    public function deletaColeta($idColeta)
    {
        $dados['status'] = 0;
        $this->db->where('id', $idColeta);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_coletas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($idColeta);
        }

        return $this->db->affected_rows() > 0;
    }

    public function recebeUltimaColetaSetor($idCliente, $codRomaneio)
    {
        $this->db->select('CO.data_coleta, SE.nome');
        $this->db->where('id_cliente', $idCliente);
        $this->db->where('cod_romaneio', $codRomaneio);
        $this->db->join('ci_romaneios R', 'R.codigo = CO.cod_romaneio');
        $this->db->join('ci_setores_empresa SE', 'SE.id = R.id_setor_empresa');

        $query = $this->db->get();
        
        return $query->result_array();
    }
    public function ultimaColetaCliente($idsClientes)
    {
        // busca as ultimas datas de cada cliente
        $this->db->select('id_cliente, MAX(data_coleta) as data_coleta');
        $this->db->where_in('id_cliente', $idsClientes);
        $this->db->where('coletado', 1);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->group_by('id_cliente');
        $ultimasDatas = $this->db->get_compiled_select('ci_coletas');
        
        // Pega as ultimas datas busca para ver de qual cliente é
        $this->db->select('C.data_coleta, C.id_cliente');
        $this->db->from("($ultimasDatas) as UD");
        $this->db->join('ci_coletas as C', 'C.id_cliente = UD.id_cliente AND C.data_coleta = UD.data_coleta', 'inner');
        $query = $this->db->get();
        
        $result = $query->result_array();
    
        // deixa o id do cliente como chave do array para usar no PDF
        $ultimaColetaCLiente = [];
        foreach ($result as $row) {
            $ultimaColetaCLiente[$row['id_cliente']] = $row;
        }
    
        return $ultimaColetaCLiente;
    }

    public function editaColetaAfericao($codRomaneio, $dados)
    {
        $dados['editado_em'] = date('Y-m-d H:i:s');
        $this->db->where('cod_romaneio', $codRomaneio);
        $this->db->where('id_empresa', $this->session->userdata('id_empresa'));
        $this->db->update('ci_coletas', $dados);

        if ($this->db->affected_rows()) {
            $this->Log_model->insereLog($codRomaneio);
        }

        return $this->db->affected_rows() > 0;
    }
    
}

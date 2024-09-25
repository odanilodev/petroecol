<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job extends CI_Controller
{
    public function deletaLog()
    {
        $this->load->model('Job_model');
        $response = $this->Job_model->deletaLogs();
        return $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function bkpBanco()
    {
        if (($_POST['key'] ?? null) == '89994f8a019265e9ce2975e02a3fffc6') {
            $this->load->database();
            ini_set('memory_limit', '-1');
            $this->load->dbutil();
            $this->load->helper('file');

            $tables = $this->db->list_tables();

            // Tabelas específicas a serem removidas do backup
            $tables_to_exclude = array('ci_log');

            // Remover as tabelas específicas da lista
            $tables = array_diff($tables, $tables_to_exclude);

            $prefs = array(
                'tables' => $tables,
                'format' => 'zip',
                'filename' => 'backup_petroecol.sql',
                'add_drop' => TRUE,
                'add_insert' => TRUE,
                'newline' => "\n"
            );

            $backup = $this->dbutil->backup($prefs, 'default');

            $data = date('Y-m-d');
            $diretorio = FCPATH . 'uploads/dump/backup_semana_' . date('w', strtotime($data)) . '_petroecol.zip';

            write_file($diretorio, $backup);
        }
    }


    public function insereSetorOleoClientes()
    {

        $this->load->model('Clientes_model');
        $this->load->model('SetoresEmpresaCliente_model');

        $clientes = $this->Clientes_model->recebeIdsClientes();

        $dados['id_empresa'] = $this->session->userdata('id_empresa');

        foreach ($clientes as $cliente) {

            $dados['id_cliente'] = $cliente['id'];

            $dados['transacao_coleta'] = '0';
            $dados['id_setor_empresa'] = '3';
            $dados['id_frequencia_coleta'] = '25';
            $dados['dia_pagamento'] = '10';
            $dados['id_forma_pagamento'] = '1';

            $this->SetoresEmpresaCliente_model->insereSetorEmpresaCliente($dados);


        }

    }

}

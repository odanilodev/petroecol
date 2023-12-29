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

            $prefs = array(
                'tables'      => $tables,
                'format'      => 'zip',
                'filename'    => 'backup_petroecol.sql',
                'add_drop'    => TRUE,
                'add_insert'  => TRUE,
                'newline'     => "\n"
            );

            $backup = $this->dbutil->backup($prefs, 'default');

            $data = date('Y-m-d');
            $diretorio = FCPATH . 'uploads/dump/backup_semana_' . date('w', strtotime($data)) . '_petroecol.zip';

            write_file($diretorio, $backup);
        }
    }
}

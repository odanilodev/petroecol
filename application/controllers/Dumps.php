<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dumps extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}

	public function bd_petroecol()
	{
		$this->load->database();
		ini_set('memory_limit', '-1');
		$this->load->dbutil();
		$this->load->helper('file');

		// Obter a lista de todas as tabelas no banco de dados
		$tables = $this->db->list_tables();

		// Tabelas específicas a serem removidas do backup
		$tables_to_exclude = array('ci_log');

		// Remover as tabelas específicas da lista
		$tables = array_diff($tables, $tables_to_exclude);

		$prefs = array(
			'tables' => $tables,
			'format' => 'zip',
			'filename' => 'backup_petroecol.sql',
			'add_insert' => TRUE,
			'newline' => "\n"
		);

		$backup = $this->dbutil->backup($prefs, 'default');

		$data = date('Y-m-d');

		$diretorio = FCPATH . 'uploads/dump/backup_semana_' . date('w', strtotime($data)) . '_petroecol.zip';

		// Salve o backup em um arquivo
		write_file($diretorio, $backup);

		// Ou envie o backup como download para o usuário
		//  $this->load->helper('download');
		//  force_download('backup_petroecol_d.zip', $backup);
	}
}

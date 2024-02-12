<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DetalhesColeta
{
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('Coletas_model');
	}

	public function detalheColeta(int $idColeta):array
	{
		$historicoColeta = $this->CI->Coletas_model->recebeColetaCliente($idColeta);

		if ($historicoColeta) {
			$array['coleta'] = $historicoColeta;
			return $array;
		}
	}
}

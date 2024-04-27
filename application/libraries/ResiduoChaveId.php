<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ResiduoChaveId
{
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('Residuos_model');
	}

	public function residuoArrayChaveId(): array
	{
		$residuos = $this->CI->Residuos_model->recebeTodosResiduos();

		$residuosArray = [];

		if ($residuos) {
			foreach ($residuos as $v) {
				$residuosArray[$v['id']] = $v['unidade_medida'] . ' de ' . $v['nome'];
			}
		}

		return $residuosArray;
	}

	public function residuoArrayNomes(): array
	{
		$residuos = $this->CI->Residuos_model->recebeTodosResiduos();


		$residuosArray = [];

		if ($residuos) {
			foreach ($residuos as $v) {
				$residuosArray[$v['id']] = $v['nome'];
			}
		}

		return $residuosArray;
	}
}

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

		// Ordena o array pela string completa dos valores
		asort($residuosArray);

		return $residuosArray;
	}

	public function residuoArrayChaveIdUnidadeMedida(): array
	{
		$residuos = $this->CI->Residuos_model->recebeTodosResiduos();

		$residuosArray = [];

		if ($residuos) {
			foreach ($residuos as $v) {
				$residuosArray[$v['id']] = [
					'unidade_medida' => $v['unidade_medida'],
					'nome' => $v['nome']
				];
			}
		}

		// Ordena o array pela string completa dos valores
		uasort($residuosArray, function ($a, $b) {
			return strcmp($a['unidade_medida'] . ' de ' . $a['nome'], $b['unidade_medida'] . ' de ' . $b['nome']);
		});

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

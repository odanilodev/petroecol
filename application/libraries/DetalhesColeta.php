<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DetalhesColeta
{
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('Coletas_model');
		$this->CI->load->model('FormaPagamento_model');
		$this->CI->load->model('Residuos_model');
	}

	public function detalheColeta(int $idColeta):array
	{
		$historicoColeta = $this->CI->Coletas_model->recebeColetaCliente($idColeta);
		$formasPagamento = $this->CI->FormaPagamento_model->recebeFormasPagamento();
		$residuos        = $this->CI->Residuos_model->recebeTodosResiduos();

		$formasArray = [];
		$residuosArray = [];

		if ($formasPagamento) {
			foreach ($formasPagamento as $v) {
				$formasArray[$v['id']] = $v['forma_pagamento'];
			}
		}

		if ($residuos) {
			foreach ($residuos as $v) {
				$residuosArray[$v['id']] = $v['unidade_medida'] . ' de ' . $v['nome'];
			}
		}

		if ($historicoColeta) {
			$array['formasPagamento'] = $formasArray;
			$array['residuos'] = $residuosArray;
			$array['coleta'] = $historicoColeta;
			return $array;
		}
	}
}

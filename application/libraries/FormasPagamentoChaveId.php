<?php

defined('BASEPATH') or exit('No direct script access allowed');

class FormasPagamentoChaveId
{
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('FormaPagamento_model');
	}

	public function formaPagamentoArrayChaveId(): array
	{
		$formasPagamento = $this->CI->FormaPagamento_model->recebeFormasPagamento();

		$formasArray = [];

		if ($formasPagamento) {
			foreach ($formasPagamento as $v) {
				$formasArray[$v['id']] = $v['forma_pagamento'];
			}
		}

		return $formasArray;
	}
}

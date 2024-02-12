<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ResiduoPagamentoCliente
{
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('ResiduoCliente_model');
	}

	public function residuoPagamentoClienteArrayChaveId($idClientes): array
	{
		$residuoCliente = $this->CI->ResiduoCliente_model->recebeResiduosClientesPorIdCliente($idClientes);

		$residuoPagamentoArray = [];

		if ($residuoCliente) {
			foreach ($residuoCliente as $v) {
				$residuoPagamentoArray[$v['id_cliente']][$v['id_residuo']] = [$v['valor_forma_pagamento'], $v['id_forma_pagamento']];
			}
		}

		return $residuoPagamentoArray;
	}
}

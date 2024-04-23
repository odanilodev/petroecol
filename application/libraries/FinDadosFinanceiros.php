<?php

defined('BASEPATH') or exit('No direct script access allowed');

class FinDadosFinanceiros
{
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
	}

	// soma todos os saldos de todas as contas bancarias
	public function somaSaldosBancarios()
	{
		$this->CI->db->select_sum('saldo');
		$this->CI->db->where('id_empresa', $this->CI->session->userdata('id_empresa'));
		$query = $this->CI->db->get('fin_saldo_bancario');

		return $query->row_array();
	}

	// calcula o total pago e total recebido
	public function totalDadosFinanceiro($coluna, $tabela, $status, $dataInicio, $dataFim)
	{
		$this->CI->db->select_sum($coluna);
		$this->CI->db->where('id_empresa', $this->CI->session->userdata('id_empresa'));
		$this->CI->db->where('status', $status);
		$this->CI->db->where('data_vencimento >=', $dataInicio);
		$this->CI->db->where('data_vencimento <=', $dataFim);
		$query = $this->CI->db->get($tabela);

		return $query->row_array();
	}


}

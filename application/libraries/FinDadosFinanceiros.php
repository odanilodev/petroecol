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

	public function somaSaldosBancariosSetor($setor = null)
	{
		$this->CI->db->select_sum('saldo');
		$this->CI->db->from('fin_saldo_bancario SB');
		$this->CI->db->join('fin_contas_bancarias CB', 'CB.id = SB.id_conta_bancaria', 'LEFT');
		$this->CI->db->where('SB.id_empresa', $this->CI->session->userdata('id_empresa'));

		if ($setor !== 'todos') {
			$this->CI->db->where('CB.id_setor_empresa', $setor);
		}

		$query = $this->CI->db->get();
		return $query->row_array();
	}



	// calcula o total pago e total recebido
	public function totalDadosFinanceiro($coluna, $tabela, $status, $dataInicio, $dataFim, $setor)
	{
		$this->CI->db->select_sum($coluna);
		$this->CI->db->where('id_empresa', $this->CI->session->userdata('id_empresa'));
		$this->CI->db->where('status', $status);

		if ($dataInicio) {

			$this->CI->db->where('data_vencimento >=', $dataInicio);
		}

		if ($dataFim) {

			$this->CI->db->where('data_vencimento <=', $dataFim);
		}

		if ($setor !== 'todos') {
			$this->CI->db->where('id_setor_empresa', $setor);
		}

		$query = $this->CI->db->get($tabela);

		return $query->row_array();
	}

	public function totalFluxoFinanceiro($coluna, $status, $dataInicio, $dataFim, $setor = null)
	{
		$this->CI->db->select_sum($coluna);
		$this->CI->db->where('id_empresa', $this->CI->session->userdata('id_empresa'));
		$this->CI->db->where('movimentacao_tabela', $status);

		// Verifica se o setor foi passado e se é válido
		if (!empty($setor) && $setor !== 'todos') {
			$this->CI->db->where('id_setor_empresa', $setor);
		}

		$this->CI->db->where('data_movimentacao >=', $dataInicio);
		$this->CI->db->where('data_movimentacao <=', $dataFim);
		$query = $this->CI->db->get('fin_fluxo');

		return $query->row_array();
	}

}

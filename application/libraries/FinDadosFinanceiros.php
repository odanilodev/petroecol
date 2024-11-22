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

	public function totalFluxoFinanceiro($coluna, $status, $dataInicio, $dataFim, $setor = null, $filtro = null)
	{

		$filtroSearch = json_decode($filtro, true);

		$this->CI->db->select_sum($coluna);
		$this->CI->db->where('F.id_empresa', $this->CI->session->userdata('id_empresa'));
		$this->CI->db->where('F.movimentacao_tabela', $status);

		// Verifica se o setor foi passado e se é válido
		if (!empty($setor) && $setor !== 'todos') {
			$this->CI->db->where('F.id_setor_empresa', $setor);
		}

		// Aplica os filtros de busca, caso existam
		if (!empty($filtroSearch)) {

			$this->CI->db->join('fin_contas_bancarias CB', 'F.id_conta_bancaria = CB.id', 'left');
			$this->CI->db->join('fin_micros M', 'M.id = F.id_micro', 'left');
			$this->CI->db->join('ci_setores_empresa SE', 'SE.id = F.id_setor_empresa', 'left');
			$this->CI->db->join('fin_forma_transacao FT', 'F.id_forma_transacao = FT.id', 'left');
			$this->CI->db->join('fin_dados_financeiros DF', 'F.id_dado_financeiro = DF.id', 'left');
			$this->CI->db->join('ci_funcionarios FNC', 'F.id_funcionario = FNC.id', 'left');
			$this->CI->db->join('ci_clientes C', 'F.id_cliente = C.id', 'left');

			foreach ($filtroSearch as $key => $value) {

				if ($key === 'search' && !empty($value)) {

					if (preg_match('/[.,]/', $value)) {
						$value = str_replace(['.', ','], ['', '.'], $value);
						$value = (float) $value;
					}

					$this->CI->db->group_start();
					$this->CI->db->where("LOWER(DF.nome) LIKE LOWER('%$value%')");
					$this->CI->db->or_where("LOWER(M.nome) LIKE LOWER('%$value%')");
					$this->CI->db->or_where("LOWER(C.nome) LIKE LOWER('%$value%')");
					$this->CI->db->or_where("LOWER(FNC.nome) LIKE LOWER('%$value%')");
					$this->CI->db->or_where("F.valor LIKE '%$value%'");
					$this->CI->db->or_where("F.observacao LIKE '%$value%'");
					$this->CI->db->or_where("F.data_movimentacao LIKE '%$value%'");
					$this->CI->db->group_end();
				}
			}
		}

		$this->CI->db->where('F.data_movimentacao >=', $dataInicio);
		$this->CI->db->where('F.data_movimentacao <=', $dataFim);
		$query = $this->CI->db->get('fin_fluxo F');

		return $query->row_array();
	}
}

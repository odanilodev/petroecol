<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AgendarFrequencia
{
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('Agendamentos_model');
		$this->CI->load->model('Clientes_model');
		$this->CI->load->model('SetoresEmpresaCliente_model');
		
	}

	public function cadastraAgendamentoFrequencia(int $id_cliente, $data_coleta, $idSetorEmpresa)
	{

		$dias_coleta = $this->CI->SetoresEmpresaCliente_model->recebeFrequenciaSetorCliente($idSetorEmpresa, $id_cliente);

		print_r($idSetorEmpresa);

		exit;

		$ultimoAgendamentoCliente = $this->CI->Agendamentos_model->recebeUltimoAgendamentoCliente($id_cliente);

		$periodo_ultima_coleta = $ultimoAgendamentoCliente['periodo_coleta'] ?? null;
		$hora_ultima_coleta = $ultimoAgendamentoCliente['hora_coleta'] ?? null;

		$data_coleta_obj = new DateTime($data_coleta);
		$data_coleta_obj->modify('+' . $dias_coleta['dia'] . ' days'); // add dias 
		$nova_data_coleta = $data_coleta_obj->format('Y-m-d');

		$dados['id_cliente'] = $id_cliente;
		$dados['data_coleta'] = $nova_data_coleta;
		$dados['hora_coleta'] = $hora_ultima_coleta ?? null;
		$dados['periodo_coleta'] = $periodo_ultima_coleta ?? null;
		$dados['prioridade'] = 0; // define como prioridade comum
		$dados['id_empresa'] = $this->CI->session->userdata('id_empresa');
		$dados['id_setor_empresa'] = $idSetorEmpresa;


		$clienteAgendado = $this->CI->Agendamentos_model->recebeClienteAgendado($id_cliente, $nova_data_coleta);

		if (!$clienteAgendado) {
			$this->CI->Agendamentos_model->insereAgendamento($dados);
		}

		$data['status'] = 2;
		$this->CI->Agendamentos_model->editaStatusAgendamento($id_cliente, $data_coleta, $data);
	}
}

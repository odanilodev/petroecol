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
	}

	public function cadastraAgendamentoFrequencia(int $id_cliente, $data_coleta)
    {

        $dias_coleta = $this->CI->Clientes_model->recebeClienteFrequenciaColeta($id_cliente);
	
		$ultimoAgendamentoCliente = $this->CI->Agendamentos_model->recebeUltimoAgendamentoCliente($id_cliente);

        $periodo_ultima_coleta = $ultimoAgendamentoCliente['periodo_coleta'];
		$hora_ultima_coleta = $ultimoAgendamentoCliente['hora_coleta'];

		$data_coleta_obj = new DateTime($data_coleta);
		$data_coleta_obj->modify('+' . $dias_coleta['dia'] . ' days'); // add dias 
		$nova_data_coleta = $data_coleta_obj->format('Y-m-d');

        $dados['id_cliente'] = $id_cliente;
        $dados['data_coleta'] = $nova_data_coleta;
        $dados['hora_coleta'] = $hora_ultima_coleta ?? null;
        $dados['periodo_coleta'] = $periodo_ultima_coleta ?? null;
        $dados['prioridade'] = 0; // define como prioridade comum
        $dados['id_empresa'] = $this->CI->session->userdata('id_empresa');

		$retorno = $this->CI->Agendamentos_model->insereAgendamento($dados);

        $clienteAgendado = $this->CI->Agendamentos_model->recebeClienteAgendado($dados['id_cliente'], $dados['data_coleta']);

		$agendamentosCliente = $this->CI->Agendamentos_model->recebeAgendamentosCliente($dados['id_cliente'], $data_coleta); 

		if($agendamentosCliente){
			
			foreach($agendamentosCliente as $a){

				if($a['status'] == 0){
					
			
					$data['status'] = 2;
					$this->CI->Agendamentos_model->editaAgendamento($a['id'], $data);
					
				}
				
			}
			
		}

		if ($clienteAgendado) {
			return $this->retornoErro('Este cliente já está agendado para este dia.');
		}
		
		if ($retorno) {
			return $this->retornoSucesso();
		}
	
		return $this->retornoErro('Erro ao agendar! Tente novamente mais tarde.');
	}
	
	private function retornoSucesso()
	{
	return $this->CI->output->set_content_type('application/json')->set_output(json_encode(['success' => true, 'message' => 'Agendamento realizado com sucesso!']));
	}
	
	private function retornoErro($mensagem)
	{
		return $this->CI->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => $mensagem]));
	}


}

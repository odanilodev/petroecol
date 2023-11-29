<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Romaneios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// INICIO controle sessão
		// $this->load->library('Controle_sessao');
		// $res = $this->controle_sessao->controle();
		// if ($res == 'erro') {
		// 	redirect('login/erro', 'refresh');
		// }
		// FIM controle sessão
	}

	public function gerarRomaneioEtiqueta()
{
    $this->load->model('EtiquetaCliente_model');
    $this->load->model('Clientes_model');

    $idEtiqueta = $this->input->post('idEtiqueta');

    $etiquetas = $this->EtiquetaCliente_model->recebeTotalEtiquetasId($idEtiqueta);
    
    // Criar um array para armazenar os id_cliente
    $idClientes = array();

    // Iterar sobre o array de etiquetas para coletar os id_cliente
    foreach ($etiquetas as $etiqueta) {
        $idClientes[] = $etiqueta['id_cliente'];
    }

	$clientes = $this->Clientes_model->recebeClientesIds($idClientes);

    print_r($clientes);

}

}

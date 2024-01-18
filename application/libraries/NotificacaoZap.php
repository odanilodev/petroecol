<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotificacaoZap
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Clientes_model');
    }

    public function enviarTexto($id_cliente, $mensagem)
    {

        $cliente = $this->CI->Clientes_model->recebeCliente($id_cliente);

        // Remover caracteres não numéricos
        $apenasNumeros = preg_replace("/[^0-9]/", "", $cliente['telefone']);
        $zap = "55" . $apenasNumeros;

        $url = "http://centrodainteligencia.com.br/api/index.php/sendText";



        $data = array(
            'number' => "$zap",
            'text' => $mensagem
        );

        $corpo = json_encode($data);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $corpo);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        $headers = array(
            "X-Custom-Header: header-value",
            "Content-Type: application/json",
            "token: JnPYbs6FkC1tiVLREAABoAAAkgA22"
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        $res = json_decode($response, true);
        return $res;
    }
}

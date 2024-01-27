<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotificacaoZap
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Clientes_model');
        $this->CI->load->model('TokenZap_model');
    }

    public function enviarTexto(int $id_cliente, string $mensagem, string $tipo = 'padrao'): string
    {

        $cliente = $this->CI->Clientes_model->recebeCliente($id_cliente);

        // Remover caracteres não numéricos
        $apenasNumeros = preg_replace("/[^0-9]/", "", $cliente['telefone']);
        $zap = "55" . $apenasNumeros;

        $bdToken = $this->CI->TokenZap_model->recebeTokenZap($tipo, $zap);

        if ($bdToken) {
            $token = $bdToken['token'] ?? null;
        } else {
            return 'Api Inativa';
        }

        $url = "http://centrodainteligencia.com.br/api/index.php/sendText";

        //Marcadores para substituição em alertas:
        $mensagem = str_replace('@usuario', $this->CI->session->userdata('nome_usuario'), $mensagem);
        $mensagem = str_replace('@empresa', $this->CI->session->userdata('nome_empresa'), $mensagem);
        $mensagem = str_replace('@cliente', $cliente['nome'], $mensagem);
        
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

        $headers = array(
            "X-Custom-Header: header-value",
            "Content-Type: application/json",
            "token: $token"
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        $res = json_decode($response, true);



        if ($res['ERROR'] ?? null) {
            return $res['ERROR'];
        }

        $res2 = json_decode($res, true);

        if ($res2['keyId']) {
            return 'true';
        }

        return 'Infelizmente não foi possível enviar sua mensagem a este número, tente novamente mais tarde.';
    }
}

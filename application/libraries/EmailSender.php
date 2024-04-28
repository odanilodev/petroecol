<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmailSender
{
    protected $CI;
    public $emailRemetente;
    public $nomeRemetente;
    public $chave_api;
    public $chave_secreta;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('email');
        $this->CI->load->helper('config_master_helper');

        $this->emailRemetente = !empty($this->CI->session->userdata('email_empresa')) ? $this->CI->session->userdata('email_empresa') : dadosEmpresa('email');

        $this->nomeRemetente = !empty($this->CI->session->userdata('nome_empresa')) ? $this->CI->session->userdata('nome_empresa') : dadosEmpresa('nome');

        $this->chave_api = !empty($this->CI->session->userdata('chave_api')) ? $this->CI->session->userdata('chave_api') : dadosEmpresa('chave_api');

        $this->chave_secreta = !empty($this->CI->session->userdata('chave_secreta')) ? $this->CI->session->userdata('chave_secreta') : dadosEmpresa('chave_secreta');
    }

    public function enviarEmail($template, $email, $assunto, $opcao = null)
    {

        switch ($template) {
            case 'definicaoSenha':
                $html = $this->redefinicaoSenha($opcao);
                break;
            default:
                $html =  $this->templatePadrao();
        }

        $this->CI->email->from($this->emailRemetente, $this->nomeRemetente); // Remetente
        $this->CI->email->to($email); // Destinatário
        $this->CI->email->subject($assunto);
        $this->CI->email->message($html);

        return $this->CI->email->send() ? true : false;
    }

    public function enviarEmailAPI($template, $email, $assunto, $opcao = null)
    {

        if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) { // bloquear disparo localhost
            echo 'Não é possivel disparar email local';
            exit;
        }

        switch ($template) {
            case 'definicaoSenha':
                $html = $this->redefinicaoSenha($opcao);
                break;
            case 'enviarCertificado':
                $html = $this->enviarCertificado();
                break;
            default:
                $html =  $this->templatePadrao();
        }

        // Dados da solicitação
        $data = [
            "Messages" => [
                [
                    "From" => [
                        "Email" => $this->emailRemetente,
                        "Name" => $this->nomeRemetente
                    ],
                    "To" => [],
                    "Subject" => $assunto,
                    "TextPart" => $html,
                    "Attachments" => [
                        [
                            'ContentType' => 'application/pdf',
                            'Filename' => 'certificado.pdf',
                            'Base64Content' => base64_encode($opcao)
                        ]
                    ],
                ]
            ]
        ];

        $emailsDestinatarios = ['contato-danilo@hotmail.com', 'centrodainteligencia@gmail.com.br'];

        foreach ($emailsDestinatarios as $emailDestinatario) {
            $data["Messages"][0]["To"][] = [
                "Email" => $emailDestinatario,
                "Name" => "Nome do Destinatário" // Você pode querer personalizar o nome do destinatário aqui
            ];
        }

        // Converte os dados para JSON
        $data_json = json_encode($data);

        // Inicializa a sessão cURL
        $ch = curl_init();

        // Define as opções da solicitação
        curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode("$this->chave_api:$this->chave_secreta")
        ));

        // Executa a solicitação
        $response = curl_exec($ch);

        // Verifica por erros
        if ($response === false) {
            echo "Erro ao enviar a solicitação: " . curl_error($ch);
        } else {
            echo "Solicitação enviada com sucesso!";
            // Aqui você pode fazer algo com a resposta, se desejar
            // Por exemplo, você pode imprimir a resposta:
            echo $response;
        }

        // Fecha a sessão cURL
        curl_close($ch);
    }

    private function redefinicaoSenha($opcao)
    {

        $html = "<h2>Olá, Você solicitou a alteração de senha em nosso sistema.</h2>";

        $html .= "<p>Segue o código para alteração de senha -> " . $opcao . "</p>";

        return $html;
    }

    private function templatePadrao()
    {

        return "<h2>Olá, temos uma mensagem para você!</h2>";
    }

    private function enviarCertificado()
    {

        return "<h2>Olá, segue o certificado em anexo!</h2>";
    }
}

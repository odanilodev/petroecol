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
        if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) { // bloquear disparo localhost
            echo 'Não é possivel disparar email local';
            exit;
        }

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
                $data = $this->redefinicaoSenhaApi($assunto, $opcao);
                break;
            default:
                $html = $this->templatePadrao();
        }

        $this->CI->email->from($this->emailRemetente, $this->nomeRemetente); // Remetente
        $this->CI->email->to($email); // Destinatário
        $this->CI->email->subject($assunto);
        $this->CI->email->message($html);

        return $this->CI->email->send() ? true : false;
    }

    public function enviarEmailAPI($template, $email, $assunto, $opcao = null, $dadosColeta = null)
    {

        if (empty($email)) {
            //echo 'Cliente não tem email cadastrado!';
            return false;
        }

        switch ($template) {
            case 'enviarCertificado':
                $data = $this->enviarCertificado($assunto, $dadosColeta, $opcao);
                break;
            case 'definicaoSenha':
                $data = $this->redefinicaoSenhaApi($assunto, $opcao);
                break;
            default:
                $data = $this->templatePadraoApi($assunto);
        }


        if (strpos($email, ',') !== false) { // um email
            $emailsDestinatarios = explode(',', $email);
        } else { // varios emails
            $emailsDestinatarios = [$email];
        }

        foreach ($emailsDestinatarios as $emailDestinatario) {
            if (!empty($emailDestinatario)) {
                $data["Messages"][0]["To"][] = [
                    "Email" => $emailDestinatario,
                    "Name" => "Cliente"
                ];
            }
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
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode("$this->chave_api:$this->chave_secreta")
            )
        );

        // Executa a solicitação
        $response = curl_exec($ch);

        // Verifica por erros
        if ($response === false) {
            //echo 'Erro ao enviar email!';
            return false;
        }

        $res = json_decode($response, true);

        if ($res['Messages'][0]['Status'] == 'success') {
            //echo 'Enviado com sucesso!';
            return true;
        }

        curl_close($ch);

        //echo 'Erro ao enviar email!!!';
        return false;
    }

    private function redefinicaoSenhaApi($assunto, $opcao)
    {
        $codigoSeparado = implode('|', str_split($opcao));

        $data = array(
            'codigo' => explode('|', $codigoSeparado),
        );

        $html = $this->CI->load->view('admin/paginas/template-emails/redefinir-senha', $data, TRUE);
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
                    "HTMLPart" => $html,
                ]
            ]
        ];

        return $data;
    }

    private function templatePadrao()
    {

        return "<h2>Olá, temos uma mensagem para você!</h2>";
    }

    private function enviarCertificado($assunto, $opcao, $dadosColeta)
    {


        if (count($dadosColeta) > 1) {
            // Pegar a primeira data de coleta
            $primeiraDataColeta = explode('/', reset($dadosColeta)['dataColeta']);
            
            // Pegar a última data de coleta
            $ultimaDataColeta = explode('/', end($dadosColeta)['dataColeta']);

            
            // Extrair o mês das datas
            $dados['mesPrimeiraData'] = $primeiraDataColeta[1] . '/' . $primeiraDataColeta[2];
            $dados['mesUltimaData'] = $ultimaDataColeta[1] . '/' . $ultimaDataColeta[2];
            
        } else {
            // Se houver apenas uma data de coleta
            $dataColetaUnica = explode('/', reset($dadosColeta)['dataColeta']);
            $dados['mesDataColetaUnica'] =  $dataColetaUnica[1] . '/' . $dataColetaUnica[2];
        }

        $html = $this->CI->load->view('admin/paginas/template-emails/enviar-certificado', $dados, TRUE);
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
                    "HTMLPart" => $html,
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

        return $data;
    }

    private function templatePadraoApi($assunto, $opcao = null)
    {

        $html = "<h2>Olá, mensagem de teste!</h2>";
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
                    "HTMLPart" => $html,
                ]
            ]
        ];

        return $data;
    }
}

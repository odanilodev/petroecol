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
                $html = $this->redefinicaoSenha($opcao);
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

    public function enviarEmailAPI($template, $email, $assunto, $opcao = null)
    {

        if (empty($email)) {
            //echo 'Cliente não tem email cadastrado!';
            return false;
        }

        switch ($template) {
            case 'enviarCertificado':
                $data = $this->enviarCertificado($assunto, $opcao);
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

    private function redefinicaoSenha($opcao)
    {
        $codigoSeparado = implode('|', str_split($opcao));
    
        $codigo = explode('|', $codigoSeparado); // Definindo a variável $codigo
    
        $html = '<style>
        body {
          font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif;
          background-color: #f8f9fa;
          margin: 0;
          padding: 0;
          color: #013738;
        }
      
        .email-container {
          display: flex;
          flex-direction: column;
          min-height: 100vh;
          justify-content: center;
          align-items: center;
        }
      
        .container {
          max-width: 600px;
          padding: 20px;
          border-radius: 15px;
          box-shadow: 0px 2px 6px rgba(1, 55, 56, 0.1);
          background-color: #fff;
        }
      
        .logo {
          text-align: center;
          margin-bottom: 20px;
        }
      
        .code-container {
          text-align: center;
          padding: 20px;
          margin-bottom: 20px;
        }
      
        .code {
          display: flex;
          justify-content: center;
          align-items: center;
        }
      
        .code-digit {
          width: 50px;
          height: 50px;
          background-color: #e9ecef;
          border: 2px solid #013738;
          border-radius: 10px;
          margin: 0 5px;
          font-size: 24px;
          line-height: 50px;
          text-align: center;
          display: flex;
          justify-content: center;
          align-items: center;
        }
      
        .line {
          border-top: 2px solid #013738;
          margin: 20px 0;
        }
      
        p {
          font-size: 16px;
          line-height: 1.6;
        }
      
        .footer {
          text-align: center;
          margin-top: 20px;
          color: #6c757d;
          font-size: 14px;
        }
      </style>
      <div class="email-container">
        <div class="container">
          <div class="logo">
            <img src="<?= base_url("assets/img/icons/logo.png") ?>" width="200">
          </div>
          <div class="code-container">
            <h2>Código de Redefinição de Senha</h2>
            <div class="code mt-4">
              <div class="code-digit">1</div>
              <div class="code-digit">1</div>
              <div class="code-digit">2</div>
              <div class="code-digit">3</div>
              <div class="code-digit">4</div>
              <div class="code-digit">5</div>
            </div>
          </div>
          <div class="line"></div>
          <p>Por favor, utilize o código acima para redefinir sua senha. </p>
          <p>Este código é válido por um período limitado de tempo.</p> <!-- Adicionei uma tag de fechamento para o <p> -->
        </div>
        <div class="footer">
          © 2024 Petroecol. Todos os direitos reservados.
        </div>
      </div>';
    
        return $html;
    }
    

    private function templatePadrao()
    {

        return "<h2>Olá, temos uma mensagem para você!</h2>";
    }

    private function enviarCertificado($assunto, $opcao)
    {

        $html = "<h2>Olá, segue o certificado em anexo!</h2>";
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

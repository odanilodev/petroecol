<?php $this->load->helper('meu_helper'); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email de Certificado</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

    .certificado {
      text-align: center;
      margin-bottom: 20px;
    }

    .certificado img {
      max-width: 100%;
      height: auto;
    }

    .contact-info {
      text-align: center;
      margin-bottom: 20px;
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
</head>

<body>
  <div class="email-container">
    <div class="container">
      <div class="logo">
        <img src="https://www.petroecol.eco.br/petroecol/assets/img/icons/logo.png" alt="Logo da Empresa" width="200">
      </div>
      <div class="certificado mt-3">
        <h3>Segue em anexo a este email o seu certificado</h3>
      </div>
      <div class="contact-info">
        <p>Em caso de dúvidas ou para mais informações, entre em contato conosco:</p>
        <p>Email: <?= $emailEmpresa ?></p>
        <p>Telefone Fixo: (14) 3208-7835</p>
        <p>Whatsapp: (14) 99714-4385</p>
      </div>
    </div>
    <div class="footer">
      © 2024 Petroecol. Todos os direitos reservados.
    </div>
  </div>
</body>

</html>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email de Certificado</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
      color: #013738;
      text-align: center;
    }

    .logo {
      margin-bottom: 20px;
    }

    h3 {
      margin-top: 0;
    }

    p {
      font-size: 16px;
      line-height: 1.6;
    }

    .footer {
      margin-top: 20px;
      color: #6c757d;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div class="logo">
    <img src="https://www.petroecol.eco.br/petroecol/assets/img/icons/logo.png" alt="Logo da Empresa" width="200">
  </div>
  <h3>Certificado Petroecol</h3>
  <p>Segue em anexo seu certificado de destinação final referente ao mês <?=$mes ?> de <?= $ano?>.</p>
  <div class="footer">
    © 2024 Petroecol. Todos os direitos reservados.
  </div>
</body>

</html>

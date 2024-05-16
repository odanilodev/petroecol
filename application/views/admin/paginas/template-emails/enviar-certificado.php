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
      text-align: center;
    }

    .logo {
      margin-bottom: 20px;
    }

    .card {
      max-width: 600px;
      margin: auto;
      margin-top: 20px;
      border-radius: 15px;
      box-shadow: 0px 2px 6px rgba(1, 55, 56, 0.1);
    }

    .card-body {
      padding: 20px;
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
  <div class="card">
    <div class="card-body">
      <div class="logo">
        <img src="https://www.petroecol.eco.br/petroecol/assets/img/icons/logo.png" alt="Logo da Empresa" width="200">
      </div>
      <h3>Certificado em anexo</h3>
      <p>Certificado de destinação final referente <?= isset($mesUltimaData) ? 'aos mêses ' . $mesPrimeiraData . ' até ' . $mesUltimaData : 'ao mês ' . $mesDataColetaUnica ?>.</p>
      <div class="footer">
        © 2024 Petroecol. Todos os direitos reservados.
      </div>
    </div>
  </div>
</body>

</html>
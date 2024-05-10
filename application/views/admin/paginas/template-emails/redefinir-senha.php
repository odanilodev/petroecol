<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Template</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Custom CSS */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
      color: #013738;
      /* verde escuro */
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
      /* Border-radius aumentado */
      box-shadow: 0px 2px 6px rgba(1, 55, 56, 0.1);
      /* Sombra sutil */
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
      /* branco */
      border: 2px solid #013738;
      /* verde escuro */
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
      /* verde escuro */
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
      /* cinza */
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
      <div class="code-container">
        <h2>Código de Redefinição de Senha</h2>
        <div class="code mt-4">
          <div class="code-digit"><?= $codigo[0] ?></div>
          <div class="code-digit"><?= $codigo[1] ?></div>
          <div class="code-digit"><?= $codigo[2] ?></div>
          <div class="code-digit"><?= $codigo[3] ?></div>
          <div class="code-digit"><?= $codigo[4] ?></div>
          <div class="code-digit"><?= $codigo[5] ?></div>
        </div>
      </div>
      <div class="line"></div>
      <p>Por favor, utilize o código acima para redefinir sua senha. Este código é válido por um período limitado de tempo.</p>
      <p>Caso não tenha sido você quem solicitou a troca de senha, por favor, desconsidere este e-mail.</p>

    </div>
    <div class="footer">
      © 2024 Petroecol. Todos os direitos reservados.
    </div>
  </div>
</body>

</html>
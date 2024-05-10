<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Template</title>
  <!-- Bootstrap CSS via CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      color: #013738;
    }

    .email-container {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
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
    }

    .line {
      border-top: 2px solid #013738;
      margin: 20px 0;
    }

    .footer {
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
        <img src="../assets/img/icons/logo.png" alt="Logo da Empresa" width="200">
      </div>
      <div class="code-container">
        <h2 class="text-center">Código de Redefinição de Senha</h2>
        <div class="code d-flex justify-content-center align-items-center mt-4">
          <?php foreach ($codigo as $digit) : ?>
            <div class="code-digit"><?= $digit ?></div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="line"></div>
      <p>Por favor, utilize o código acima para redefinir sua senha. Este código é válido por um período limitado de tempo.</p>
      <p>Caso não tenha sido você quem solicitou a troca de senha, por favor, desconsidere este e-mail.</p>
    </div>
    <div class="footer text-center">
      © 2024 Petroecol. Todos os direitos reservados.
    </div>
  </div>

  <!-- Bootstrap JS via CDN (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
</body>

</html>
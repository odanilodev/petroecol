<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Email Template</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      color: #013738;
    }

    .email-container {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      justify-content: center;
      align-items: center;
    }

    .custom-container {
      max-width: 600px;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0px 2px 6px rgba(1, 55, 56, 0.1);
      background-color: #fff;
    }

    .custom-logo {
      text-align: center;
      margin-bottom: 20px;
    }

    .custom-code-container {
      text-align: center;
      padding: 20px;
      margin-bottom: 20px;
    }

    .custom-code-digit {
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

    .custom-line {
      border-top: 2px solid #013738;
      margin: 20px 0;
    }

    p {
      font-size: 16px;
      line-height: 1.6;
    }

    .custom-footer {
      text-align: center;
      margin-top: 20px;
      color: #6c757d;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div class="email-container">
    <div class="custom-container">
      <div class="custom-logo">
        <img src="<?= base_url("assets/img/icons/logo.png") ?>" class="img-fluid" width="200">
      </div>
      <div class="custom-code-container">
        <h2 class="text-center">Código de Redefinição de Senha</h2>
        <div class="row justify-content-center mt-4">
          <div class="col-auto">
            <div class="code-digit"><?= $codigo[0] ?></div>
            <div class="code-digit"><?= $codigo[1] ?></div>
            <div class="code-digit"><?= $codigo[2] ?></div>
            <div class="code-digit"><?= $codigo[3] ?></div>
            <div class="code-digit"><?= $codigo[4] ?></div>
            <div class="code-digit"><?= $codigo[5] ?></div>
          </div>
        </div>
      </div>
      <hr class="custom-line">
      <p class="text-center">Por favor, utilize o código acima para redefinir sua senha.</p>
      <p class="text-center">Este código é válido por um período limitado de tempo.</p>
    </div>
    <div class="custom-footer">
      © 2024 Petroecol. Todos os direitos reservados.
    </div>
  </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <link rel="stylesheet" href="<?=base_url('/assets/css/template-emails/redefinir-senha.css')?>">
</head>
<body>
    <div class="email-container">
        <div class="container">
            <div class="logo">
                <img src="../assets/img/icons/logo.png" alt="Logo da Empresa" width="200">
            </div>
            <div class="code-container">
                <h2>Código de Redefinição de Senha</h2>
                <div class="code mt-4">
                    <div class="code-digit"><?=$codigo[0]?></div>
                    <div class="code-digit"><?=$codigo[1]?></div>
                    <div class="code-digit"><?=$codigo[2]?></div>
                    <div class="code-digit"><?=$codigo[3]?></div>
                    <div class="code-digit"><?=$codigo[4]?></div>
                    <div class="code-digit"><?=$codigo[5]?></div>
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

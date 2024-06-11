<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 100%;
            max-height: 150px;
        }

        h3 {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 12px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .declaration {
            background-color: #f9f9f9;
            padding: 10px;
            border-left: 5px solid #006600;
            margin-top: 30px;
        }

        .signature {
            text-align: center;
            margin-top: 30px;
            overflow: hidden;
        }

        .signature img {
            max-width: 10%;
            margin: 15px;
        }

        .date-header {
            background-color: #e0e0e0;
            font-weight: bold;
            padding: 10px;
        }

        .date-section {
            margin-top: 30px;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="header">
            <img style="max-width: 260px;"
                src="<?= base_url_upload('certificados/logos/' . $modelo_certificado['logo']) ?>" alt="Logo">
            <p style="font-size: 12px; padding-top: 10px;"><?= $modelo_certificado['descricao']; ?></p>
        </div>

        <h3><?= $modelo_certificado['titulo']; ?></h3>

        <table>
            <tr>
                <th colspan="3"><?= chave('certificados-pdf-titulo-gerador') ?>: <?= $clientes_coletas['nome'] ?></th>
            </tr>
            <tr>
                <td colspan="3">
                    <strong><?= chave('certificados-pdf-titulo-razao-social') ?>: </strong>
                    <?= $clientes_coletas['razao_social'] ? $clientes_coletas['razao_social'] : "Não informado."; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong><?= chave('certificados-pdf-titulo-cnpj') ?>: </strong>
                    <?= $clientes_coletas['cnpj'] ? $clientes_coletas['cnpj'] : "Não informado." ?>
                </td>
                <td>
                    <strong><?= chave('certificados-pdf-titulo-estado') ?>: </strong>
                    <span><?= $clientes_coletas['estado'] ? $clientes_coletas['estado'] : "Não informado." ?></span>
                </td>
                <td>
                    <strong><?= chave('certificados-pdf-titulo-telefone') ?>: </strong>
                    <?= $clientes_coletas['telefone'] ? $clientes_coletas['telefone'] : "Não informado." ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <strong><?= chave('certificados-pdf-titulo-endereco') ?>: </strong>
                    <?= "{$clientes_coletas['rua']}, {$clientes_coletas['numero']} {$clientes_coletas['bairro']} - {$clientes_coletas['cidade']} / {$clientes_coletas['estado']}" ?>
                </td>
            </tr>
        </table>

        <h3>Resíduos Coletados</h3>

        <?php
        // Agrupar os dados por data de coleta
        $coletasPorData = [];
        foreach ($dados as $dado) {
            foreach ($dado['quantidade_coletada'] as $i => $quantidade) {
                $dataColeta = $dado['dataColeta'];
                $residuo = $dado['residuos'][$i];
                if (!isset($coletasPorData[$dataColeta])) {
                    $coletasPorData[$dataColeta] = [];
                }
                $coletasPorData[$dataColeta][] = ['quantidade' => $quantidade, 'residuo' => $residuo];
            }
        }
        ?>

        <?php foreach ($coletasPorData as $data => $coletas): ?>
            <div class="date-section">
                <div class="date-header"><?= $data ?></div>
                <table>
                    <thead>
                        <tr>
                            <th>Tipo do Resíduo</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coletas as $coleta): ?>
                            <tr>
                                <td><?= $residuosColetatos[$coleta['residuo']] ?></td>
                                <td><?= $coleta['quantidade'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>

        <?php if ($modelo_certificado['declaracao']): ?>
            <div class="declaration">
                <h4 style="font-weight: bold; margin-bottom: 10px;">Declaração</h4>
                <p style="font-size: 12px;"><?= $modelo_certificado['declaracao']; ?></p>
            </div>
        <?php endif; ?>

        <div class="signature">
            <div style="width: 50%; float: left;">
                <?php if ($modelo_certificado['assinatura']): ?>
                    <img src="<?= base_url_upload('certificados/assinaturas/' . $modelo_certificado['assinatura']) ?>"
                        alt="Assinatura" style="width: 40%;">
                <?php endif; ?>
            </div>

            <div style="width: 50%; float: right;">
                <?php if ($modelo_certificado['carimbo']): ?>
                    <img src="<?= base_url_upload('certificados/carimbos/' . $modelo_certificado['carimbo']) ?>"
                        alt="Carimbo" style="width: 50%;">
                <?php endif; ?>
            </div>
        </div>

    </div>

</body>

</html>
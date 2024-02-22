<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            width: 50%;
            color: #404040;
        }

        .tabela {
            width: 50%;
        }

        body {
            font-family: 'sans-serif';
        }

        .w-50 {
            width: 10% !important;
        }
    </style>

</head>

<body>

    <div style="width: 100%;">

        <div style="padding: 5px" align="center">
            <img src="<?= base_url_upload('certificados/logos/' . $modelo_certificado['logo']) ?>" style="max-width: 200px; max-height: 100px;">

            <p align="center" style="font-size: 12px;">
                <?= $modelo_certificado['descricao']; ?>
            </p>

        </div>

        <div style="margin-top: 5px">
            <h3 style="font-weight: bold; text-transform:uppercase"><?= $modelo_certificado['titulo']; ?> </h3>
        </div>

        <div style="margin-top: 45px;">

            <table class="table">
                <thead>

                    <tr>
                        <td colspan="3">
                            <strong><?= chave('certificados-pdf-titulo-gerador') ?>:</strong> <?= $clientes_coletas['nome'] ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <strong><?= chave('certificados-pdf-titulo-razao-social') ?>: </strong> <?= $clientes_coletas['razao_social'] ? $clientes_coletas['razao_social'] : "Não informado."; ?>
                        </td>
                    </tr>

                    <tr>

                        <td scope="col" style="width: 280px;">
                            <strong><?= chave('certificados-pdf-titulo-cnpj') ?>: </strong> <?= $clientes_coletas['cnpj'] ? $clientes_coletas['cnpj'] : "Não informado." ?>
                        </td>

                        <td scope="col" style="width: 150px;">
                            <strong><?= chave('certificados-pdf-titulo-estado') ?>: </strong> <span><?= $clientes_coletas['estado'] ? $clientes_coletas['estado'] : "Não informado." ?></span>
                        </td>

                        <td scope="col" style="width: 280px;">
                            <strong><?= chave('certificados-pdf-titulo-telefone') ?>: </strong> <?= $clientes_coletas['telefone'] ? $clientes_coletas['telefone'] : "Não informado." ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <strong><?= chave('certificados-pdf-titulo-endereco') ?>: </strong> <?= "{$clientes_coletas['rua']}, {$clientes_coletas['numero']} {$clientes_coletas['bairro']} - {$clientes_coletas['cidade']} / {$clientes_coletas['estado']}" ?>
                        </td>
                    </tr>

                </thead>
            </table>



        </div>

        <div style="margin-top: 45px;">

            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 15px;" scope="col">Qtd / Tipo do resíduo</th>
                        <th style="width: 15px;" scope="col">Data</th>
                    </tr>
                </thead>
                <tbody>

                <?php

                    foreach ($dados as $dado) :
                        
                        for ($i = 0; $i < count($dado['quantidade_coletada']); $i++) : 

                            if ($this->uri->segment(5) && $dado['residuos'][$i] == $this->uri->segment(5)) : ?>

                                <tr>
                                    <td style="width: 15px;"><?= $dado['quantidade_coletada'][$i] ?> <?= $residuosColetatos[$dado['residuos'][$i]] ?></td>
                                    <td style="width: 15px;"><?= $dado['dataColeta'] ?></td>
                                </tr>
                            
                    <?php
                            elseif (!$this->uri->segment(5)) : ?>

                                <tr>
                                    <td style="width: 15px;"><?= $dado['quantidade_coletada'][$i] ?> <?= $residuosColetatos[$dado['residuos'][$i]] ?></td>
                                    <td style="width: 15px;"><?= $dado['dataColeta'] ?></td>
                                </tr>

                            <?php

                            endif;
                        endfor;
                    endforeach;
                ?>

                </tbody>
            </table>



        </div>

    </div>

    <?php if ($modelo_certificado['declaracao']) { ?>

        <h4 style="font-weight: bold; margin-top: 50px;">
            <?= strtoupper(chave('declaracao'))?>
            <hr style="font-size: 0.5px;">
            <p style="font-weight: 100; font-size: 11px">
                <?= $modelo_certificado['declaracao']; ?>
            </p>
        </h4>

    <?php } ?>


    <div style="width: 100%; display: flex; flex-wrap: wrap; margin-top: 40px">
        <div align="center">

            <?php if ($modelo_certificado['assinatura']) { ?>
                <img style="width: 30%; display: block; margin: 15px" src="<?= base_url_upload('certificados/assinaturas/' . $modelo_certificado['assinatura']) ?>">
            <?php } ?>

            <?php if ($modelo_certificado['carimbo']) { ?>
                <img style="width: 30%; display: block; margin: 15px" src="<?= base_url_upload('certificados/carimbos/' . $modelo_certificado['carimbo']) ?>">
            <?php } ?>
        </div>

    </div>


</body>

</html>
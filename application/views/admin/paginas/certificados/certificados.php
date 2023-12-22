
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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

    </style>

</head>

<body>

    <div style="width: 100%;">

        <div style="padding: 5px" align="center">
            <img src="<?= base_url('assets/img/icons/logo.jpg') ?>" style="max-height: 30px;">

            <p align="center" style="font-size: 12px;">
                A  Petroecol Soluções Ambientais - Petroecol, cadastrada sob o CNPJ: 04.744.853/0001-99, localizada em
                Rua Margarida Genaro 2-189, Loteamento Empresarial Bauru - Bauru - SP atuando sob a cetesb
                7007444 certifica a destinação dos resíduos listados abaixo, para o gerador e data indicados.
            </p>

        </div>

        <div style="margin-top: 5px">
            <h3 style="font-weight: bold;">CERTIFICADO DE DESTINAÇÃO FINAL </h3>


            <div style="font-size: 14px" class="col-md-6">
                Data: <strong><?= date('d/m/Y', strtotime($clientes_coletas['data_coleta'])); ?></strong> <br>
            </div>

        </div>

        <div style="margin-top: 45px;">

            <table class="table">
                <thead>

                    <tr>
                        <td colspan="3">
                            <strong>Gerador:</strong> <?= $clientes_coletas['CLIENTE'] ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <strong>RAZÃO SOCIAL: </strong> <?= $clientes_coletas['razao_social'] ? $clientes_coletas['razao_social'] : "Não informado."; ?>
                        </td>
                    </tr>

                    <tr>

                        <td scope="col" style="width: 280px;">
                            <strong>CNPJ: </strong> <?= $clientes_coletas['cnpj'] ? $clientes_coletas['cnpj'] : "Não informado." ?>
                        </td>

                        <td scope="col" style="width: 150px;">
                            <strong>UF: </strong> <span><?= $clientes_coletas['estado'] ? $clientes_coletas['estado'] : "Não informado." ?></span>
                        </td>

                        <td scope="col" style="width: 280px;">
                            <strong>Telefone: </strong> <?= $clientes_coletas['telefone'] ? $clientes_coletas['telefone'] : "Não informado." ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <strong>Endereço: </strong> <?= "{$clientes_coletas['rua']}, {$clientes_coletas['numero']} {$clientes_coletas['bairro']} - {$clientes_coletas['cidade']} / {$clientes_coletas['estado']}" ?>
                        </td>
                    </tr>

                </thead>
            </table>



        </div>

        <div style="margin-top: 45px;">

            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 15px;" scope="col">Atendimento</th>
                        <th style="width: 15px;" scope="col">Tipo do resíduo</th>
                        <th scope="col" style="width: 15px;">Quantidade</th>
                        <th style="width: 15px;" scope="col">Data</th>
                    </tr>
                </thead>
                <tbody>

                    <?php for ($i = 0; $i < count($residuos_coletados); $i++) { ?>
                        <tr>
                            <td style="width: 15px;"><?= $clientes_coletas['cod_romaneio'] ?></td>
                            <td style="width: 15px;"><?= $residuos_coletados[$i] ?> </td>
                            <td style="width: 15px;"><?= $quantidade_residuos_coletados[$i] . $medida_residuos_coletados[$i] ?></td>
                            <td style="width: 15px;"><?= date('d/m/Y', strtotime($clientes_coletas['data_coleta'])); ?></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>



        </div>

    </div>

    <h4 style="font-weight: bold; margin-top: 50px;">
        DECLARAÇÃO
        <hr style="font-size: 0.5px;">
        <p style="font-weight: 100; font-size: 11px">
            Certificamos, para os devidos fins, que os resíduos estavam acondicionados de forma adequada e apropriada para transporte, e que a referida
            quantidade teve uma destinação final ambientalmente adequada, segundo a legislação em vigor.
        </p>
    </h4>


</body>

</html>
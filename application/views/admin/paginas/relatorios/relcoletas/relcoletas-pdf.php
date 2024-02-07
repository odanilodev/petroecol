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
            <!-- <img src="<?= base_url_upload('certificados/logos/' . $modelo_certificado['logo']) ?>" style="max-width: 200px; max-height: 100px;"> -->

            <p align="center" style="font-size: 12px;">
                descrição do bagulho
            </p>

        </div>

        <div style="margin-top: 5px">
            <h3 style="font-weight: bold; text-transform:uppercase">Relatório de clientes </h3>
        </div>

        <div style="margin-top: 10px;">
            

            <table class="table">
                <tbody>

                    <tr>
                        <td style="width: 15px;">4 movimentações</td>
                        <td style="width: 15px;">150.00 L</td>
                        <td style="width: 350px !important;">75.00 L/Movimentação</td>
                        <td style="width: 15px;">R$-1.80/L</td>
                        <td style="width: 15px;">R$-270.00</td>
                    </tr>

                </tbody>
                <thead>
                    <tr>
                        <th style="width: 15px;" scope="col">Data</th>
                        <th style="width: 15px;" scope="col">Movimentado</th>
                        <th style="width: 25px;" scope="col">Valor</th>
                        <th style="width: 15px;" scope="col">Motorista</th>
                        <th style="width: 15px;" scope="col">Veículo</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td style="width: 15px;">442</td>
                        <td style="width: 15px;">32323232</td>
                        <td style="width: 25px;">32323232</td>
                        <td style="width: 15px;">32323232</td>
                        <td style="width: 15px;">32323232</td>
                    </tr>

                </tbody>
            </table>



        </div>

    </div>

</body>

</html>
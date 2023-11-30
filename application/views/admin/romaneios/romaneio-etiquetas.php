<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Romaneio</title>
    <meta charset="utf-8">

    <style>

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 55%;
            display: flex;
            flex-direction: column;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            width: 30%;
            color: #404040;
        }

        /* Estilo para ajustar a largura das tabelas individualmente (opcional) */
        .tabela {
            width: 48%;
            /* Ajuste conforme necessário */
        }
    </style>


</head>

<body>


    <!--Header-->

    <div style="width: 100%;">
        <div style="padding: 5px" align="center">
            <img src="<?= base_url('assets/img/icons/logo.jpg')?>" style="max-height: 30px;">
        </div>

        <div style="margin-top: 5px">
            <div style="font-size: 14px" class="col-md-6">
                Data: 01/10/2019
            </div>
        </div>

        <div style="margin-top: 2px;">
            <nobr>
                <span style="font-size: 13px; max-width: 25%;">Motorista:</span>
                <span style="margin-left: 8%; font-size: 13px; max-width: 25%;">Ajudante:
                </span>
                <span style="margin-left: 8%; font-size: 13px; max-width: 25%;">Placa: </span>

                <span style="margin-left: 8%; font-size: 13px; max-width: 25%;">Romaneio: 000122</span>

            </nobr>
        </div>
        <hr style="font-size: 0.5px; margin-top: 5px;">


    </div>

    <!--EndHeader-->



    <div style="width: 100%;">
        <h4 style="margin-top: 30px; margin-bottom: 5px"><b>Bauru</b></h4>

        <table>

            <thead>
                <tr style="font-size: 14px" align="left">
                    <th>Nome Cliente</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>Forma de Pagto</th>
                    <th>Ultima Coleta</th>
                    <th>Qtde Retirado</th>
                    <th>Valor Pago</th>
                    <th>Observação</th>
                </tr>
            </thead>

            <tbody>


                <?php foreach ($clientes as $v) { ?>


                    <tr style="font-size: 11px" align="left">
                        <td><?= $v['nome']; ?></td>
                        <td><?= "{$v['rua']}, {$v['numero']} {$v['bairro']}"; ?></td>
                        <td><?= $v['telefone']; ?></td>
                        <td>Dinheiro</td>
                        <td>14/10/2021</td>
                        <td>50kg</td>
                        <td>5.000,00</td>
                        <td><?= $v['observacao']; ?></td>

                    </tr>

                <?php } ?>


            </tbody>

        </table>


    </div>



</body>

</html>
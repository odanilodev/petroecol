<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Romaneio</title>
    <meta charset="utf-8">


</head>

<body>


    <!--Header-->

    <div style="width: 100%;">
        <div style="background-color: #DBDBDB" align="center">
            PETROECOL SOLUÇÕES AMBIENTAIS
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



    <style>
        td {
            border-bottom: 0.5px solid #000;
        }

        ;
    </style>

    <!--EndHeader-->



    <div style="width: 100%;">
        <h4 style="margin-top: 30px; margin-bottom: 5px"><b>Bauru</b></h4>

        <table>

            <thead>
                <tr style="font-size: 14px" align="left">
                    <th style="padding-left: 22px">Código</th>
                    <th style="padding-left: 22px">Nome Cliente</th>
                    <th style="padding-left: 22px">Endereço</th>
                    <th style="padding-left: 22px">Telefone</th>
                    <th style="padding-left: 22px">Observação</th>
                    <th style="padding-left: 22px">Forma de Pagto</th>
                    <th style="padding-left: 22px">Ultima Coleta</th>
                    <th style="padding-left: 22px">Qtde Retirado</th>
                    <th style="padding-left: 22px">Valor Pago</th>
                </tr>
            </thead>

            <tbody>


                <?php foreach ($clientes as $v) { ?>


                    <tr style="font-size: 11px" align="left">
                        <td style="padding-left: 23px"><?= $v['codigo'] ?></td>
                        <td style="padding-left: 23px"><?= $v['nome']; ?></td>
                        <td style="padding-left: 23px"><?= "{$v['rua']}, {$v['numero']} {$v['bairro']}";?></td>
                        <td style="padding-left: 23px"><?= $v['telefone']; ?></td>
                        <td style="padding-left: 23px"><?= $v['observacao']; ?></td>
                        <td style="padding-left: 23px">Dinheiro</td>
                        <td style="padding-left: 23px">14/10/2021</td>
                        <td style="padding-left: 23px">50kg</td>
                        <td style="padding-left: 23px">5.000,00</td>

                    </tr>

                <?php } ?>


            </tbody>

        </table>


    </div>



</body>

</html>



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

        th,
        td {
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
            <img src="<?= base_url('assets/img/icons/logo.jpg') ?>" style="max-height: 30px;">
        </div>

        <div style="margin-top: 5px">
        <h3 style="font-weight: 100;">Romaneio: <span style="font-weight: bold;"><?= $codigo ?></span></h3>

            <div style="font-size: 14px" class="col-md-6">
                Data: <?= date("d/m/Y", strtotime($data_romaneio)); ?> 
            </div>
        </div>

        <div style="margin-top: 2px;">
            <nobr>
                <span style="font-size: 13px; max-width: 25%;">Responsavel:</span>
                <span style="margin-left: 8%; font-size: 13px; max-width: 25%;">Ajudante:</span>
                <span style="margin-left: 8%; font-size: 13px; max-width: 25%;">Placa: </span>
            </nobr>
        </div>
        <hr style="font-size: 0.5px; margin-top: 5px;">
    </div>

    <!--EndHeader-->

    <div style="width: 100%;"> 

        <?php
        $currentCity = null;
        $tableOpen = false;

        foreach ($clientes as $v) {
            // Verifica se a cidade do cliente mudou
            if ($v['cidade'] !== $currentCity) {
                // Se sim, fecha a tabela anterior (se existir)
                if ($tableOpen) {
                    echo '</tbody></table>';
                }
                // Abre uma nova tabela
                echo "<h4 style='margin-top: 30px; margin-bottom: 5px'><b>{$v['cidade']}</b></h4>";
                echo '<table>';
        ?>
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
                <?php
                $currentCity = $v['cidade'];
                $tableOpen = true;
            }
                ?>
                <tr style="font-size: 11px" align="left">
                    <td><?= $v['nome']; ?></td>
                    <td><?= "{$v['rua']}, {$v['numero']} {$v['bairro']}"; ?></td>
                    <td><?= $v['telefone']; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= $v['observacao']; ?></td>
                </tr>
            <?php
        }

        // Fecha a última tabela
        if ($tableOpen) {
            echo '</tbody></table>';
        }
            ?>

    </div>

</body>

</html>
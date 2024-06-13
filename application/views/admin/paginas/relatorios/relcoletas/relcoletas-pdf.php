<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Coleta</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }

        .header {
            display: flex;
            justify-content: space-between;
        }

        .header img {
            width: 120px;
        }

        .header h3 {
            margin: 0;
            font-size: 18px;
        }

        .container {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #444;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="header">
        <div style='width: 100%; display: flex; align-items: center;'>

            <div style="flex: 1; text-align: left;">
                <img src="<?= base_url('assets/img/icons/logo-slogan.jpg') ?>" alt="Logomarca"
                    style="max-width: 45%; height: auto;">
            </div>

            <div style="flex: 1; text-align: right; margin-top: -30px;">
                <h3 style="font-weight: bold; text-transform: uppercase;">Relatório de coletas</h3>
            </div>

        </div>
    </div>

    <div style="margin-top: 40px;">

        <?php
        $movimentacoes_por_residuo_geral = 0;
        $movimentado_geral = [];
        $valor_total_geral = [];
        $valor_total_mensal_geral = [];

        $unique_collection_days = [];
        ?>

        <?php foreach ($dados as $id_cliente => $dado) { ?>

            <h3 style="font-weight: bold; text-transform:uppercase"><?= $dado['nome'] ?? $dado['razao_social'] ?></h3>

            <?php
            // Group collections by residue
            $residue_collections = [];
            foreach ($dado['coletas'] as $coleta) {
                $data_coleta = $coleta['data_coleta'];
                if (!in_array($data_coleta, $unique_collection_days)) {
                    $unique_collection_days[] = $data_coleta;
                }

                foreach ($coleta['residuos'] as $key => $residuo) {
                    if (in_array($residuo, $ids_residuos)) {
                        if (!isset($residue_collections[$residuos[$residuo]['nome']])) {
                            $residue_collections[$residuos[$residuo]['nome']] = [];
                        }
                        $quantity = $coleta['quantidade_coletada'][$key];
                        $value = isset($residuoPagamentoCliente[$id_cliente][$residuo][0]) ? $quantity * $residuoPagamentoCliente[$id_cliente][$residuo][0] : 0;
                        $payment_type = isset($residuoPagamentoCliente[$id_cliente][$residuo][1]) ? $formasPagamento[$residuoPagamentoCliente[$id_cliente][$residuo][1]] : '';

                        $residue_collections[$residuos[$residuo]['nome']][] = [
                            'data_coleta' => $coleta['data_coleta'],
                            'motorista' => $coleta['motorista'],
                            'quantidade' => $quantity,
                            'valor' => $value,
                            'tipo_pagamento' => $payment_type,
                            'unidade_medida' => $residuos[$residuo]['unidade_medida']
                        ];

                        if (isset($movimentado_geral[$residuo])) {
                            $movimentado_geral[$residuo] += $quantity;
                        } else {
                            $movimentado_geral[$residuo] = $quantity;
                        }

                        if (isset($valor_total_geral[$payment_type])) {
                            $valor_total_geral[$payment_type] += $value;
                        } else {
                            $valor_total_geral[$payment_type] = $value;
                        }

                        if (isset($valor_total_mensal_geral[$payment_type])) {
                            $valor_total_mensal_geral[$payment_type] += $value;
                        } else {
                            $valor_total_mensal_geral[$payment_type] = $value;
                        }
                    }
                }
                $movimentacoes_por_residuo_geral++;
            }

            foreach ($residue_collections as $residue => $collections) {
                echo "<h4>$residue</h4>";
                echo '<table class="table">
                        <thead>
                            <tr>
                                <th style="width: 15px;" scope="col">Data</th>
                                <th style="width: 15px;" scope="col">Motorista</th>
                                <th style="width: 15px;" scope="col">Quantidade</th>
                                <th style="width: 15px;" scope="col">Total</th>
                                <th style="width: 15px;" scope="col">Total Base</th>
                            </tr>
                        </thead>
                        <tbody>';
                foreach ($collections as $collection) {
                    echo "<tr>
                            <td style=\"width: 15px;\">{$collection['data_coleta']}</td>
                            <td style=\"width: 15px;\">{$collection['motorista']}</td>
                            <td style=\"width: 15px;\">{$collection['quantidade']} {$collection['unidade_medida']}</td>
                            <td style=\"width: 15px;\">{$collection['valor']} {$collection['tipo_pagamento']}</td>
                            <td style=\"width: 15px;\">{$collection['valor']} {$collection['tipo_pagamento']}</td>
                          </tr>";
                }
                echo '</tbody></table>';
            }
            ?>

        <?php } ?>


        <h3 style="font-weight: bold; text-transform:uppercase">TOTAIS</h3>
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 15px;" scope="col">Movimentações</th>
                    <th style="width: 15px;" scope="col">Movimentado</th>
                    <th style="width: 15px;" scope="col">Total</th>
                    <th style="width: 15px;" scope="col">Total Base</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td align="center" style="width: 45px;">
                        <?= count($unique_collection_days) ?> coletas
                    </td>
                    <td style="width: 15px;">
                        <?php
                        foreach ($movimentado_geral as $key => $mov) {
                            echo '<p>' . $mov . ' ' . ($residuos[$key]['unidade_medida'] . ' de ' . $residuos[$key]['nome'] ?? "") . '</p>';
                        }
                        ?>
                    </td>
                    <td style="width: 15px;">
                        <?php
                        foreach ($valor_total_geral as $key => $val) {
                            echo '<p>' . (is_numeric($val) ? 'R$ ' . number_format($val, 2, ',', '.') : $val) . ' ' . ($key) . '</p>';
                        }
                        ?>
                    </td>
                    <td style="width: 15px;">
                        <?php
                        foreach ($valor_total_mensal_geral as $key => $val) {
                            echo '<p>' . (is_numeric($val) ? 'R$ ' . number_format($val, 2, ',', '.') : $val) . ' ' . ($key) . '</p>';
                        }
                        ?>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

    <div class="footer">
        Relatório gerado em <?= date('d/m/Y'); ?>
    </div>

</body>

</html>
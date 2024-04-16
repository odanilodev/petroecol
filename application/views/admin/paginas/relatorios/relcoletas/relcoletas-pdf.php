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
            font-size: 20px;
        }

        .container {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #013738;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #013738;
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
                <h3 style="font-weight: bold; text-transform: uppercase;">Relatório de clientes</h3>
            </div>

        </div>
    </div>

    <div style="margin-top: 40px;">

        <?php
        $movimentacoes_por_residuo_geral = 0;
        $movimentado_geral = [];
        $valor_total_mensal_geral = [];
        ?>

        <?php foreach ($dados as $id_cliente => $dado) { ?>

            <h3 style="font-weight: bold; text-transform:uppercase"><?= $dado['nome'] ?? $dado['razao_social'] ?></h3>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 15px;" scope="col">Data</th>
                        <th style="width: 15px;" scope="col">Motorista</th>
                        <th style="width: 15px;" scope="col">Movimentado</th>
                        <th style="width: 15px;" scope="col">Total</th>
                        <?php if (!$filtrar_geral) { ?>
                            <th style="width: 15px;" scope="col">Total Base</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $movimentacoes_por_residuo = 0;
                    $movimentado = [];
                    $valor_total = [];
                    $valor_total_mensal = [];

                    foreach ($dado['coletas'] as $coleta): ?>

                        <tr>
                            <td style="width: 15px;"><?= $coleta['data_coleta'] ?></td>
                            <td style="width: 15px;"><?= $coleta['motorista'] ?></td>

                            <td style="width: 15px;">

                                <?php
                                $valor_base_cliente = '';
                                if ($coleta['residuos']) {


                                    foreach ($coleta['residuos'] as $key => $residuo):

                                        if (!is_numeric($coleta['quantidade_coletada'][$key])) {
                                            $coleta['quantidade_coletada'][$key] = 0;
                                        }

                                        if (isset($movimentado[$residuo])) {

                                            $movimentado[$residuo] += $coleta['quantidade_coletada'][$key] ?? 0;
                                            if (isset($residuoPagamentoCliente[$id_cliente])) {
                                                $valor_total_mensal[$residuoPagamentoCliente[$id_cliente][$residuo][1]] += ($coleta['quantidade_coletada'][$key] ?? 0) * ($residuoPagamentoCliente[$id_cliente][$residuo][0] ?? 0);
                                            }
                                        } else {

                                            $movimentado[$residuo] = $coleta['quantidade_coletada'][$key] ?? 0;

                                            if (isset($residuoPagamentoCliente[$id_cliente][$residuo][1])) {
                                                $valor_total_mensal[$residuoPagamentoCliente[$id_cliente][$residuo][1]] = ($coleta['quantidade_coletada'][$key] ?? 0) * ($residuoPagamentoCliente[$id_cliente][$residuo][0] ?? 0);
                                            }
                                        }

                                        if ($filtrar_geral) {
                                            echo '<p>' . ($coleta['quantidade_coletada'][$key] ?? 0) . ' ' . ($residuos[$residuo] ?? "") . '</p>';
                                        } else {
                                            echo '<p>' . ($coleta['quantidade_coletada'][$key] ?? 0) . ' ' . ($residuos[$residuo] ?? "") . ' (' . ($residuoPagamentoCliente[$id_cliente][$residuo][0] ?? 0) . ')</p>';
                                        }


                                        if (isset($residuoPagamentoCliente[$id_cliente][$residuo][1])) {
                                            $valor_base_cliente .= '<p>' . ($coleta['quantidade_coletada'][$key] ?? 0) * ($residuoPagamentoCliente[$id_cliente][$residuo][0] ?? 0) . ' ' . ($formasPagamento[$residuoPagamentoCliente[$id_cliente][$residuo][1]] ?? '') . '</p>';
                                        }

                                        $movimentacoes_por_residuo++;
                                        $movimentacoes_por_residuo_geral++;

                                    endforeach;
                                }

                                ?>


                            </td>

                            <td style="width: 15px; display:none">
                                <?php
                                if (!empty($coleta['pagamentos'])) {
                                    foreach ($coleta['pagamentos'] as $key => $pagamento) {
                                        if (!isset($valor_total[$pagamento])) {
                                            $valor_total[$pagamento] = ['valor' => 0, 'tipo_pagamento' => ''];
                                        }

                                        // Assegura que o valor seja tratado corretamente como numérico ou zero.
                                        $valorPagamento = $coleta['valor_pagamento'][$key] ?? 0;
                                        $valorPagamento = is_numeric($valorPagamento) ? (float) $valorPagamento : 0;

                                        $valor_total[$pagamento]['valor'] += $valorPagamento;
                                        $valor_total[$pagamento]['tipo_pagamento'] = $coleta['tipo_pagamento'][$key] ?? '';

                                        // Verifica se o valor é float para decidir sobre a formatação.
                                        if (is_float($valorPagamento)) {
                                            $formattedValue = number_format($valorPagamento, 2, ',', '.');
                                        } else {
                                            // Para valores não-float, mantém a representação original (ou 0).
                                            $formattedValue = $valorPagamento;
                                        }

                                        if (isset($coleta['tipo_pagamento'][$key]) && $coleta['tipo_pagamento'][$key] == 1) {
                                            echo "<p>R$${formattedValue} " . ($formasPagamento[$pagamento] ?? "") . "</p>";
                                        } else {
                                            echo "<p>${formattedValue} " . ($formasPagamento[$pagamento] ?? "") . "</p>";
                                        }
                                    }
                                }
                                ?>
                            </td>


                            <?php if (!$filtrar_geral) { ?>
                                <td style="width: 15px;">
                                    <?= $valor_base_cliente ?>
                                </td>
                            <?php } ?>
                        </tr>

                    <?php endforeach; ?>

                    <tr>
                        <td colspan="2" align="center" style="width: 45px;"><?= $movimentacoes_por_residuo ?> movimentações
                        </td>
                        <td style="width: 15px;">

                            <?php
                            foreach ($movimentado as $key => $mov) {

                                if (isset($movimentado_geral[$key])) {
                                    $movimentado_geral[$key] += $mov;
                                } else {
                                    $movimentado_geral[$key] = $mov;
                                }

                                echo '<p>' . $mov . ' ' . ($residuos[$key] ?? "") . '</p>';
                            }
                            ?>

                        </td>
                        <td style="width: 15px;">

                            <?php
                            foreach ($valor_total as $key => $val) {

                                if (isset($valor_total_geral[$key])) {
                                    $valor_total_geral[$key]['valor'] += $val['valor'];
                                } else {
                                    $valor_total_geral[$key]['valor'] = $val['valor'];
                                    $valor_total_geral[$key]['tipo_pagamento'] = $val['tipo_pagamento'];
                                }

                                if ($val['tipo_pagamento'] == 1) {
                                    echo '<p> R$' . (number_format($val['valor'], 2, ',', '.')) . ' ' . ($formasPagamento[$key] ?? "") . '</p>';
                                } else {
                                    echo '<p>' . $val['valor'] . ' ' . ($formasPagamento[$key] ?? "") . '</p>';
                                }
                            }
                            ?>

                        </td>

                        <?php if (!$filtrar_geral) { ?>
                            <td style="width: 15px;">
                                <?php
                                foreach ($valor_total_mensal as $key => $val) {

                                    if (isset($valor_total_mensal_geral[$key])) {
                                        $valor_total_mensal_geral[$key] += $val;
                                    } else {
                                        $valor_total_mensal_geral[$key] = $val;
                                    }

                                    echo '<p>' . $val . ' ' . ($formasPagamento[$key] ?? "") . '</p>';
                                }
                                ?>

                            </td>
                        <?php } ?>

                    </tr>

                </tbody>
            </table>

        <?php } ?>


        <h3 style="font-weight: bold; text-transform:uppercase">TOTAIS</h3>
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 15px;" scope="col">Quantidade</th>
                    <th style="width: 15px;" scope="col">Movimentado</th>
                    <th style="width: 15px;" scope="col">Total</th>
                    <?php if (!$filtrar_geral) { ?>
                        <th style="width: 15px;" scope="col">Total Base</th>
                    <?php } ?>

                </tr>
            </thead>
            <tbody>

                <tr>
                    <td align="center" style="width: 45px;"><?= $movimentacoes_por_residuo_geral ?> movimentações</td>
                    <td style="width: 15px;">

                        <?php
                        foreach ($movimentado_geral as $key => $mov) {
                            echo '<p>' . $mov . ' ' . ($residuos[$key] ?? "") . '</p>';
                        }
                        ?>

                    </td>
                    <td style="width: 15px;">

                        <?php
                        if (isset($valor_total_geral)) {
                            foreach ($valor_total_geral as $key => $val) {
                                if ($val['tipo_pagamento'] == 1) {
                                    echo '<p>R$' . (number_format($val['valor'], 2, ',', '.')) . ' ' . ($formasPagamento[$key] ?? "") . '</p>';
                                } else {
                                    echo '<p>' . $val['valor'] . ' ' . ($formasPagamento[$key] ?? "") . '</p>';
                                }
                            }
                        }
                        ?>

                    </td>
                    <?php if (!$filtrar_geral) { ?>
                        <td style="width: 15px;">

                            <?php
                            foreach ($valor_total_mensal_geral as $key => $val) {
                                echo '<p>' . $val . ' ' . ($formasPagamento[$key] ?? "") . '</p>';
                            }
                            ?>

                        </td>
                    <?php } ?>
                </tr>

            </tbody>
        </table>

    </div>

    </div>

    <div class="footer">
        Relatório gerado em <?= date('d/m/Y'); ?>
    </div>

</body>

</html>
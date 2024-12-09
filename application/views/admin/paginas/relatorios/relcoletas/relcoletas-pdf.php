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
            font-size: 12px;
            border-collapse: collapse;
            margin-top: 0px;
            margin-bottom: 25px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px !important;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #444;
            color: #fff;
            font-size: 11px;
            /* Tamanho do cabeçalho menor */
            padding: 6px !important;
            /* Reduz o espaçamento interno (padding) */
        }


        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #444;
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
        <div style='width: 100%; display: flex; align-items: center'>

            <div style="flex: 1; text-align: left;">
                <img src="<?= base_url('assets/img/icons/logo-slogan.jpg') ?>" alt="Logomarca"
                    style="max-width: 45%; height: auto;">
            </div>

            <div style="flex: 1; text-align: right; margin-top: -30px;">
                <h3 style="font-weight: bold; text-transform: uppercase; font-size: 16px;">Relatório de coletas
                </h3>
                <h3 style="font-weight: bold; text-transform: uppercase; font-size: 16px;">
                    <?= date("d/m/Y", strtotime($data_inicio)) ?> - <?= date("d/m/Y", strtotime($data_fim)) ?>
                </h3>
            </div>

        </div>
    </div>


    <div style="margin-top: 40px;">

        <?php
        $movimentacoes_por_residuo_geral = 0;
        $movimentado_geral = [];
        $valor_total_mensal_geral = [];
        $residuos_coletados = [];

        // Organize os dados por resíduos
        foreach ($dados as $id_cliente => $dado) {
            foreach ($dado['coletas'] as $coleta) {
                // Usamos um conjunto (set) para rastrear os resíduos processados para esta coleta
                $residuos_processados = [];
                foreach ($coleta['residuos'] as $key => $residuo) {
                    // Verificamos se o resíduo já foi processado para esta coleta
                    if (!in_array($residuo, $residuos_processados) && in_array($residuo, $ids_residuos)) {
                        $residuos_coletados[$residuo]['cliente'][$id_cliente]['nome'] = $dado['nome'] ?? $dado['razao_social'];
                        $residuos_coletados[$residuo]['cliente'][$id_cliente]['coletas'][] = $coleta;

                        // Adicionamos o resíduo ao conjunto de resíduos processados
                        $residuos_processados[] = $residuo;
                    }
                }
            }
        }


        // Gere a tabela para cada resíduo
        foreach ($residuos_coletados as $residuo_id => $residuo_dados) {

            ?>

            <?php foreach ($residuo_dados['cliente'] as $id_cliente => $cliente_dados) {
                $movimentado = [];
                $valor_total = [];
                $valor_total_mensal = [];
                $movimentacoes_por_residuo = 0;
                ?>


                <h4 style="font-weight: bold; text-transform:uppercase; margin-bottom: 0px;">
                    <?= $cliente_dados['nome'] ?> -
                    <?= $residuos[$residuo_id]['nome'] ?? "" ?>
                </h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 5px;" scope="col">Data</th>
                            <th style="width: 5px;" scope="col">Motorista</th>
                            <th style="width: 5px;" scope="col">Movimentado</th>
                            <th style="width: 5px;" scope="col">Total</th>
                            <?php if (!$filtrar_geral) { ?>
                                <th style="width: 5px;" scope="col">Total Base</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($cliente_dados['coletas'] as $coleta):
                            $residuoEncontrado = false;

                            foreach ($coleta['residuos'] as $key => $residuo) {
                                if ($residuo == $residuo_id) {
                                    $residuoEncontrado = true;
                                    break;
                                }
                            }



                            if ($residuoEncontrado):
                                ?>
                                <tr>
                                    <td style="width: 10px;"><?= $coleta['data_coleta'] ?></td>
                                    <td style="width: 10px;"><?= $coleta['motorista'] ?></td>

                                    <td style="width: 10px;">
                                        <?php
                                        $valor_base_cliente = '';
                                        foreach ($coleta['residuos'] as $key => $residuo):
                                            if ($residuo == $residuo_id) {
                                                if (isset($coleta['quantidade_coletada'][$key])) {
                                                    // Substitui a vírgula por ponto
                                                    $valor = str_replace(',', '.', $coleta['quantidade_coletada'][$key]);

                                                    // Verifica se o valor ajustado é numérico
                                                    if (!is_numeric($valor)) {
                                                        $coleta['quantidade_coletada'][$key] = 0;
                                                    } else {
                                                        $coleta['quantidade_coletada'][$key] = (float) $valor; // Converte para float para garantir cálculos corretos
                                                    }
                                                }


                                                if (isset($movimentado[$residuo])) {
                                                    $movimentado[$residuo] += $coleta['quantidade_coletada'][$key] ?? 0;
                                                    if (isset($residuoPagamentoCliente[$id_cliente])) {
                                                        if (isset($residuoPagamentoCliente[$id_cliente][$residuo][1])) {
                                                            $valor_total_mensal[$residuoPagamentoCliente[$id_cliente][$residuo][1]] += ($coleta['quantidade_coletada'][$key] ?? 0) * ($residuoPagamentoCliente[$id_cliente][$residuo][0] ?? 0);
                                                        }
                                                    }
                                                } else {
                                                    $movimentado[$residuo] = $coleta['quantidade_coletada'][$key] ?? 0;
                                                    if (isset($residuoPagamentoCliente[$id_cliente][$residuo][1])) {
                                                        $valor_total_mensal[$residuoPagamentoCliente[$id_cliente][$residuo][1]] = ($coleta['quantidade_coletada'][$key] ?? 0) * ($residuoPagamentoCliente[$id_cliente][$residuo][0] ?? 0);
                                                    }
                                                }

                                                if ($filtrar_geral) {
                                                    echo '<p>' . ($coleta['quantidade_coletada'][$key] ?? 0) . ' ' . ($residuos[$residuo]['unidade_medida'] ?? "") . ' de ' . ($residuos[$residuo]['nome'] ?? "") . '</p>';
                                                } else {
                                                    echo '<p>' . ($coleta['quantidade_coletada'][$key] ?? 0) . ' ' . ($residuos[$residuo]['unidade_medida'] ?? "") . ' de ' . ($residuos[$residuo]['nome'] ?? "") . ' (' . ($residuoPagamentoCliente[$id_cliente][$residuo][0] ?? 0) . ')</p>';
                                                }

                                                if (isset($residuoPagamentoCliente[$id_cliente][$residuo][1])) {
                                                    $valor_base_cliente .= '<p>' . ($coleta['quantidade_coletada'][$key] ?? 0) * ($residuoPagamentoCliente[$id_cliente][$residuo][0] ?? 0) . ' ' . ($formasPagamento[$residuoPagamentoCliente[$id_cliente][$residuo][1]] ?? '') . '</p>';
                                                }

                                                $movimentacoes_por_residuo++;
                                                $movimentacoes_por_residuo_geral++;
                                            }
                                        endforeach;
                                        ?>
                                    </td>

                                    <td style="width: 10px; display:none">
                                        <?php

                                        if (!empty($coleta['pagamentos'])) {

                                            foreach ($coleta['pagamentos'] as $key => $pagamento) {

                                                if (!isset($valor_total[$pagamento])) {
                                                    $valor_total[$pagamento] = ['valor' => 0, 'tipo_pagamento' => ''];
                                                }

                                                $valorPagamento = $coleta['valor_pagamento'][$key] ?? 0;
                                                $valorPagamento = is_numeric($valorPagamento) ? (float) $valorPagamento : 0;

                                                $valor_total[$pagamento]['valor'] += $valorPagamento;
                                                $valor_total[$pagamento]['tipo_pagamento'] = $coleta['tipo_pagamento'][$key] ?? '';

                                                if (isset($coleta['tipo_pagamento'][$key]) && $coleta['tipo_pagamento'][$key] == 1) {
                                                    $formattedValue = number_format($valorPagamento, 2, ',', '.');
                                                } else {
                                                    $formattedValue = $valorPagamento;
                                                }


                                                if (isset($coleta['tipo_pagamento'][$key]) && $coleta['tipo_pagamento'][$key] == 1) {
                                                    echo "<p>R$$formattedValue " . ($formasPagamento[$pagamento] ?? $formasTransacao[$pagamento]) . "</p>";
                                                } else {
                                                    echo "<p>$formattedValue " . ($formasPagamento[$pagamento] ?? $formasTransacao[$pagamento]) . "</p>";
                                                }
                                            }
                                        }
                                        ?>
                                    </td>

                                    <?php if (!$filtrar_geral) { ?>
                                        <td style="width: 10px;">
                                            <?= $valor_base_cliente ?>
                                        </td>
                                    <?php } ?>
                                </tr>

                            <?php endif;
                        endforeach; ?>

                        <tr>
                            <td colspan="2" align="center" style="width: 10px;"><?= $movimentacoes_por_residuo ?> movimentações
                            </td>
                            <td style="width: 10px;">
                                <?php
                                foreach ($movimentado as $key => $mov) {
                                    if (isset($movimentado_geral[$key])) {
                                        $movimentado_geral[$key] += $mov;
                                    } else {
                                        $movimentado_geral[$key] = $mov;
                                    }
                                    echo '<p>' . $mov . ' ' . ($residuos[$key]['unidade_medida'] ?? "") . ' de ' . ($residuos[$key]['nome'] ?? "") . '</p>';
                                }
                                ?>
                            </td>
                            <td style="width: 10px;">
                                <?php
                                foreach ($valor_total as $key => $val) {
                                    if (isset($valor_total_geral[$key])) {
                                        $valor_total_geral[$key]['valor'] += $val['valor'];
                                    } else {
                                        $valor_total_geral[$key]['valor'] = $val['valor'];
                                        $valor_total_geral[$key]['tipo_pagamento'] = $val['tipo_pagamento'];
                                    }
                                    if ($val['tipo_pagamento'] == 1) {
                                        echo '<p> R$' . (number_format($val['valor'], 2, ',', '.')) . ' ' . ($formasPagamento[$key] ?? $formasTransacao[$key]) . '</p>';
                                    } else {
                                        echo '<p>' . $val['valor'] . ' ' . ($formasPagamento[$key] ?? $formasTransacao[$key]) . '</p>';
                                    }
                                }
                                ?>
                            </td>

                            <?php if (!$filtrar_geral) { ?>
                                <td style="width: 10px;">
                                    <?php
                                    foreach ($valor_total_mensal as $key => $val) {
                                        if (isset($valor_total_mensal_geral[$key])) {
                                            $valor_total_mensal_geral[$key] += $val;
                                        } else {
                                            $valor_total_mensal_geral[$key] = $val;
                                        }
                                        echo '<p>' . $val . ' ' . ($formasPagamento[$key] ?? $formasTransacao[$key]) . '</p>';
                                    }
                                    ?>
                                </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>

            <?php } ?>

        <?php } ?>

        <h3 style="font-weight: bold; text-transform:uppercase">TOTAIS GERAIS</h3>
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 8px;" scope="col">Quantidade</th>
                    <th style="width: 8px;" scope="col">Movimentado</th>
                    <th style="width: 8px;" scope="col">Total</th>
                    <?php if (!$filtrar_geral) { ?>
                        <th style="width: 8px;" scope="col">Total Base</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center" style="width: 45px;"><?= $movimentacoes_por_residuo_geral ?> movimentações</td>
                    <td style="width: 8px;">
                        <?php
                        foreach ($movimentado_geral as $key => $mov) {
                            echo '<p>' . $mov . ' ' . ($residuos[$key]['unidade_medida'] ?? "") . ' de ' . ($residuos[$key]['nome'] ?? "") . '</p>';
                        }
                        ?>
                    </td>
                    <td style="width: 8px;">
                        <?php
                        if (isset($valor_total_geral)) {
                            foreach ($valor_total_geral as $key => $val) {
                                if ($val['tipo_pagamento'] == 1) {
                                    echo '<p>R$ ' . (number_format($val['valor'], 2, ',', '.')) . ' ' . ($formasPagamento[$key] ?? $formasTransacao[$key]) . '</p>';
                                } else {
                                    echo '<p>' . $val['valor'] . ' ' . ($formasPagamento[$key] ?? $formasTransacao[$key]) . '</p>';
                                }
                            }
                        }
                        ?>
                    </td>
                    <?php if (!$filtrar_geral) { ?>
                        <td style="width: 8px;">
                            <?php
                            foreach ($valor_total_mensal_geral as $key => $val) {
                                echo '<p>' . $val . ' ' . ($formasPagamento[$key] ?? $formasTransacao[$key]) . '</p>';
                            }
                            ?>
                        </td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>


    </div>

    <div class="footer">
        Relatório gerado em <?= date('d/m/Y'); ?>
    </div>

</body>

</html>
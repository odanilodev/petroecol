<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Coleta</title>

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

        <div style="margin-top: 5px">
            <h3 style="font-weight: bold; text-transform:uppercase">Relatório de clientes </h3>
            <h3 style="font-weight: bold; text-transform:uppercase">PETROECOL SOLUÇÕES AMBIENTAIS</h3>
        </div>

        <div style="margin-top: 10px;">

            <?php
            $movimentacoes_por_residuo_geral = 0;
            $movimentado_geral = [];
            $valor_total_geral = [];
            ?>

            <?php foreach ($dados as $id_cliente => $dado) { ?>

                <h3 style="font-weight: bold; text-transform:uppercase"><?= $dado['razao_social'] ?></h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 15px;" scope="col">Data</th>
                            <th style="width: 15px;" scope="col">Motorista</th>
                            <th style="width: 15px;" scope="col">Valor</th>
                            <th style="width: 15px;" scope="col">Movimentado</th>
                            <th style="width: 15px;" scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $movimentacoes_por_residuo = 0;
                        $movimentado = [];
                        $valor_total = [];

                        foreach ($dado['coletas'] as $coleta) : ?>

                            <tr>
                                <td style="width: 15px;"><?= $coleta['data_coleta'] ?></td>
                                <td style="width: 15px;"><?= $coleta['motorista'] ?></td>
                                <td style="width: 15px;">R$1.80</td>

                                <td style="width: 15px;">

                                    <?php
                                    foreach ($coleta['residuos'] as $key => $residuo) :

                                        if (!is_numeric($coleta['quantidade_coletada'][$key])) {
                                            $coleta['quantidade_coletada'][$key] = 0;
                                        }

                                        if (isset($movimentado[$residuo])) {
                                            $movimentado[$residuo] += $coleta['quantidade_coletada'][$key] ?? 0;
                                        } else {
                                            $movimentado[$residuo] = $coleta['quantidade_coletada'][$key] ?? 0;
                                        }


                                        echo '<p>' . ($coleta['quantidade_coletada'][$key] ?? 0) . ' ' . $residuos[$residuo] . '</p>';

                                        $movimentacoes_por_residuo++;
                                        $movimentacoes_por_residuo_geral++;

                                    endforeach;

                                    ?>


                                </td>

                                <td style="width: 15px;">

                                    <?php

                                    foreach ($coleta['pagamentos'] as $key => $pagamento) :

                                        if (!is_numeric($coleta['valor_pagamento'][$key])) {
                                            $coleta['valor_pagamento'][$key] = 0;
                                        }

                                        if (isset($valor_total[$pagamento])) {
                                            $valor_total[$pagamento] += $coleta['valor_pagamento'][$key] ?? 0;
                                        } else {
                                            $valor_total[$pagamento] = $coleta['valor_pagamento'][$key] ?? 0;
                                        }

                                        echo '<p>' . ($coleta['valor_pagamento'][$key] ?? 0) . ' ' . $formasPagamento[$pagamento] . '</p>';

                                    endforeach;

                                    ?>

                                </td>
                            </tr>

                        <?php endforeach; ?>

                        <tr>
                            <td colspan="3" align="center" style="width: 45px;"><?= $movimentacoes_por_residuo ?> movimentações</td>
                            <td style="width: 15px;">

                                <?php
                                foreach ($movimentado as $key => $mov) {

                                    if (isset($movimentado_geral[$key])) {
                                        $movimentado_geral[$key] += $mov;
                                    } else {
                                        $movimentado_geral[$key] = $mov;
                                    }

                                    echo '<p>' . $mov . ' ' . $residuos[$key] . '</p>';
                                }
                                ?>

                            </td>
                            <td style="width: 15px;">

                                <?php
                                foreach ($valor_total as $key => $val) {

                                    if (isset($valor_total_geral[$key])) {
                                        $valor_total_geral[$key] += $val;
                                    } else {
                                        $valor_total_geral[$key] = $val;
                                    }

                                    echo '<p>' . $val . ' ' . $formasPagamento[$key] . '</p>';
                                }
                                ?>

                            </td>
                        </tr>

                    </tbody>
                </table>

            <?php } ?>


            <h3 style="font-weight: bold; text-transform:uppercase">TOTAIS</h3>
            <table class="table">
                <tbody>

                    <tr>
                        <td align="center" style="width: 45px;"><?= $movimentacoes_por_residuo_geral ?> movimentações</td>
                        <td colspan="2" style="width: 15px;">

                            <?php
                            foreach ($movimentado_geral as $key => $mov) {
                                echo '<p>' . $mov . ' ' . $residuos[$key] . '</p>';
                            }
                            ?>

                        </td>
                        <td colspan="2" style="width: 15px;">

                            <?php
                            foreach ($valor_total_geral as $key => $val) {
                                echo '<p>' . $val . ' ' . $formasPagamento[$key] . '</p>';
                            }
                            ?>

                        </td>
                    </tr>

                </tbody>
            </table>

        </div>

    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Romaneio</title>
    <meta charset="utf-8">

    <style>
        body {
            font-family: 'arial, sans-serif';
        }

        table {
            font-family: 'arial, sans-serif';
            border-collapse: collapse;
            width: 70%;
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
            width: 40%;
            /* Ajuste conforme necessário */
        }
    </style>
</head>

<body>

    <!--Header-->

    <div style="width: 100%; display: flex; justify-content: space-between;">
        <div>
            <img src="<?= base_url('assets/img/icons/logo-slogan.jpg') ?>" style="max-height: 20px; float:right;">
            <h3 style="font-weight: 100;">Romaneio: <span style="font-weight: bold;"><?= $codigo ?></span></h3>
            <strong> Data: </strong><?= date("d/m/Y", strtotime($data_romaneio)); ?>
        </div>
    </div>

    <div style="margin-top: 2px;">
        <nobr>
            <span style="font-size: 13px; max-width: 25%;"><strong> Responsavel: </strong> <?= $responsavel ?></span><br>
            <!-- <span style="margin-left: 8%; font-size: 13px; max-width: 25%;"><strong> Ajudante: </strong> <?= $ajudante ?></span><br> -->
            <span style="margin-left: 8%; font-size: 13px; max-width: 25%;"><strong> Placa: </strong><?= strtoupper($placa) ?> </span>
        </nobr>
    </div>

    <hr style="font-size: 0.5px; margin-top: 5px;">

    <!--EndHeader-->

    <div style="width: 100%;">
        <?php
        $cidadeAtual = null;
        $tabelaAberta = false;

        foreach ($clientes as $cliente) {

            // Verifica se a cidade do cliente mudou
            if (trim(strtolower($cliente['cidade'])) !== $cidadeAtual) {
                // Se sim, fecha a tabela anterior (se existir)
                if ($tabelaAberta) {
                    echo '</tbody></table>';
                }
                // Abre uma nova tabela
                echo "<h4 style='margin-top: 30px; margin-bottom: 5px'><b>{$cliente['cidade']}</b> </h4>";
                echo '<table>';
        ?>
                <thead>
                    <tr style="font-size: 14px;">
                        <th>Nome Cliente</th>
                        <th>Endereço</th>
                        <th>Telefone</th>
                        <th>Forma de Pagto</th>
                        <th>Recipientes</th>
                        <th>Qtde Retirado</th>
                        <th>Valor Pago</th>
                        <th>Observação</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $cidadeAtual = trim(strtolower($cliente['cidade']));
                $tabelaAberta = true;
            } ?>

                <tr style="font-size: 11px;">
                    <td><?= $cliente['nome']; ?> <?= in_array($cliente['id'], array_column($id_cliente_prioridade, 'id_cliente')) ? '<span style="font-weight: bold; font-size: 20px">*</span>' : '' ?></td>
                    <td><?= "{$cliente['rua']}, {$cliente['numero']} {$cliente['bairro']}"; ?></td>
                    <td><?= $cliente['telefone']; ?></td>
                    <td>
                        <p><?= $cliente['forma_pagamento']; ?></p><br>
                        <p><?= $cliente['observacao_pagamento'] ?? ""; ?></p>
                    </td>

                    <td>
                        <?php
                        $chave = $cliente['id'];
                        if (array_key_exists($chave, $recipientes_clientes)) {
                            foreach ($recipientes_clientes[$chave] as $recipiente) {
                                echo "<p> {$recipiente['nome_recipiente']} - {$recipiente['quantidade']} </p>";
                            }
                        }
                        ?>
                    </td>

                    <td></td>
                    <td></td>
                    <td><?= $cliente['observacao']; ?></td>
                </tr>
            <?php
        }

        // Fecha a última tabela
        if ($tabelaAberta) {
            echo '</tbody></table>';
        }
            ?>
    </div>


</body>

</html>
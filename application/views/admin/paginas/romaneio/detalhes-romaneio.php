<div class="contents">
    <!--EndHeader-->
    <div id="members" data-list='{"valueNames":["customer","email","mobile_number","city","last_active","joined"],"page":10,"pagination":true}'>

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
                    echo '
                    <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
                    <div class="table-responsive scrollbar ms-n1 ps-1">
                    <table class="table table-lg mb-0 table-hover text-center">';
            ?>
                    <thead>
                        <tr style="font-size: 14px;">
                            <th class="sort align-middle">Nome Cliente</th>
                            <th class="sort align-middle">Endereço</th>
                            <th class="sort align-middle">Telefone</th>
                            <th class="sort align-middle">Forma de Pagto</th>
                            <th class="sort align-middle">Recipientes</th>
                            <th class="sort align-middle">Qtde Retirado</th>
                            <th class="sort align-middle">Valor Pago</th>
                            <th class="sort align-middle">Observação</th>
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
                echo '</tbody></table></div></div>';
            }
                ?>
        </div>
    </div>
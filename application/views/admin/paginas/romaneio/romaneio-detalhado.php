<div class="content">
    <div id="members" data-list='{"valueNames":["customer","email","mobile_number","city","last_active","joined"],"page":10,"pagination":true}'>
    <h3>Romaneio: <?= $detalhes_romaneio[0]['cod_romaneio']; ?></h3>

        <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
            <div class="table-responsive scrollbar ms-n1 ps-1">
                <table class="table table-lg mb-0 table-hover text-center">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Responsável</th>
                            <th>Data Romaneio</th>
                            <th>Resíduos Coletados</th>
                            <th>Quantidade Coletada</th>
                            <th>Forma de Pagamento</th>
                            <th>Valor Pago</th>
                            <th>Observação</th>
                            <th>Coletado</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="members-table-body">
                        <?php
                            $totalValorPago = 0;
                            $totalQuantidade = 0;
                            $totaisPorResiduo = [];
                            $totaisPorFormaPagamento = [];

                            foreach ($detalhes_romaneio as $v) {
                                ?>
                                <tr>
                                    <td><?= $v['id_cliente']; ?></td>
                                    <td><?= $v['id_responsavel']; ?></td>
                                    <td><?= date('d/m/Y', strtotime($v['data_coleta'])); ?></td>
                                    <td>
                                        <?php foreach ($v['residuos_coletados'] as $key => $residuo) { ?>
                                            <?= $residuo; ?><br>
                                            <?php
                                            // Inicializa o total para o resíduo se ainda não existir
                                            if (!isset($totaisPorResiduo[$residuo])) {
                                                $totaisPorResiduo[$residuo] = 0;
                                            }
                                            $totaisPorResiduo[$residuo] += $v['quantidade_coletada'][$key];
                                        } ?>
                                    </td>
                                    <td>
                                        <?php foreach ($v['quantidade_coletada'] as $quantidade) { 
                                            $totalQuantidade += $quantidade;
                                            ?>
                                            <?= $quantidade; ?><br>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php foreach ($v['forma_pagamento'] as $key => $forma) { ?>
                                            <?= $forma; ?><br>
                                            <?php
                                            // Inicializa o total para a forma de pagamento se ainda não existir
                                            if (!isset($totaisPorFormaPagamento[$forma])) {
                                                $totaisPorFormaPagamento[$forma] = 0;
                                            }
                                            $totaisPorFormaPagamento[$forma] += $v['valor_pago'][$key];
                                        } ?>
                                    </td>
                                    <td>
                                        <?php foreach ($v['valor_pago'] as $valor) { 
                                            $totalValorPago += $valor;
                                            ?>
                                            <?= $valor; ?><br>
                                        <?php } ?>
                                    </td>
                                    <td><?= $v['observacao']; ?></td>
                                    <td><?= $v['coletado'] ? 'Sim' : 'Não'; ?></td>
                                </tr>
                            <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5"></td>
                            <td colspan="2">Totais por Resíduo:</td>
                            <td colspan="2">
                                <?php foreach ($totaisPorResiduo as $residuo => $total) { ?>
                                    <?= $residuo . ': ' . $total . '<br>'; ?>
                                <?php } ?>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                            <td colspan="2">Totais por Forma de Pagamento:</td>
                            <td colspan="2">
                                <?php foreach ($totaisPorFormaPagamento as $forma => $total) { ?>
                                    <?= $forma . ': ' . $total . '<br>'; ?>
                                <?php } ?>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

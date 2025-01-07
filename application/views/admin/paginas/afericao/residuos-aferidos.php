<div class="content">
    <div id="members">

        <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
            <div class="row align-items-end justify-content-between pb-5 pt-5 g-3">
                <div class="col-auto">
                    <h3>Resíduos Aferidos</h3>
                </div>
            </div>
            <div class="table-responsive scrollbar ms-n1 ps-1">
                <table class="table table-sm fs--1 mb-0">
                    <thead>
                        <tr class="py-3">
                            <th class="sort align-middle text-center" scope="col">Romaneio</th>
                            <th class="sort align-middle text-center" scope="col">Responsável</th>
                            <th class="sort align-middle text-center" scope="col">Resíduo</th>
                            <th class="sort align-middle text-center" scope="col">Quantidade coletada</th>
                            <th class="sort align-middle text-center" scope="col">Aferido</th>
                            <th class="sort align-middle text-center" scope="col">Custos</th>
                            <th class="sort align-middle text-center" scope="col">Gasto total</th>
                            <th class="sort align-middle text-center" scope="col">Trajeto</th>
                        </tr>
                    </thead>

                    <tbody class="list" id="members-table-body">

                        <?php foreach ($residuosAferidos as $residuoAferido) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                <td class="align-middle text-center white-space-nowrap py-3">
                                    <?= $residuoAferido['cod_romaneio']; ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap py-3">
                                    <?= ucfirst($residuoAferido['RESPONSAVEL']); ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap py-3">
                                    <?= ucfirst($residuoAferido['RESIDUO']); ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap py-3">
                                    <?= $residuoAferido['quantidade_coletada']; ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap py-3">
                                    <span class="text-<?= $residuoAferido['aferido'] >= $residuoAferido['quantidade_coletada'] ? 'success' : 'danger'?>"><?=  $residuoAferido['aferido']; ?></span>
                                </td>

                                <td class="align-middle text-center white-space-nowrap py-3">
                                    <?= $residuoAferido['aferido'] ? number_format($residuoAferido['VALOR_TOTAL_COLETA'] / $residuoAferido['aferido'], 2, ',', '.') : ''; ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap py-3">
                                    <?= $residuoAferido['VALOR_TOTAL_COLETA'] ? number_format($residuoAferido['VALOR_TOTAL_COLETA'], 2, ',', '.') : ''; ?>
                                </td> 

                                <td class="align-middle text-center white-space-nowrap py-3">
                                    <?= $residuoAferido['TRAJETO']; ?>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
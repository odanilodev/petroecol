<div class="content">
    <div id="members">
        <div class="row align-items-center justify-content-between g-3 mb-2">

            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <p>Romaneio: <?= $this->uri->segment(3) ?></p>

                    <input type="hidden" class="codigo-romaneio" value="<?= $this->uri->segment(3) ?>">
                </div>

            </div>

        </div>
        <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
            <div class="table-responsive scrollbar ms-n1 ps-1">
                <table class="table table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th class="sort align-middle text-center" scope="col">Resíduo coletado</th>
                            <th class="sort align-middle text-center" scope="col">Quantidade coletada</th>
                            <th style="width: 120px;" class="sort align-middle text-center" scope="col">Aferido</th>
                        </tr>
                    </thead>

                    <tbody class="list" id="members-table-body">

                        <?php

                        $residuosAgrupados = [];

                        foreach ($coletas as $coleta) {

                            $residuosColetados = json_decode($coleta['residuos_coletados'], true);
                            $quantidadesColetadas = json_decode($coleta['quantidade_coletada'], true);

                            for ($i = 0; $i < count($residuosColetados); $i++) {

                                $idResiduo = $residuosColetados[$i];
                                $quantidade = $quantidadesColetadas[$i];

                                if (isset($residuosAgrupados[$idResiduo])) {
                                    $residuosAgrupados[$idResiduo]['quantidade'] += $quantidade;
                                } else {
                                    $residuosAgrupados[$idResiduo]['quantidade'] = $quantidade;
                                    $residuosAgrupados[$idResiduo]['id_setor_empresa'] = $coleta['id_setor_empresa'];
                                }
                            }
                        }
                        ?>

                        <?php foreach ($residuosAgrupados as $idResiduo => $dadosResiduos) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                <td class="align-middle text-center white-space-nowrap py-3">
                                    <?= $residuosArray[$idResiduo]; ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap py-3">
                                    <?= $dadosResiduos['quantidade']; ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap py-3">
                                    <input type="number" class="form-control input-aferido text-center"
                                        data-id-setor-empresa="<?= $dadosResiduos['id_setor_empresa'] ?>"
                                        data-id-residuo="<?= $idResiduo; ?>"
                                        data-qtd-coletada="<?= $dadosResiduos['quantidade']; ?>">
                                </td>
                            </tr>
                        <?php } ?>




                    </tbody>
                </table>

                <div style="float: right;">
                    <button class="btn btn-phoenix-success my-4 d-flex btn-finalizar-afericao">Finalizar</button>
                </div>

            </div>

        </div>
    </div>
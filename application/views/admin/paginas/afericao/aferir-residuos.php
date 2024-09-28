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
                            <th style="width: 120px;" class="sort align-middle text-center" scope="col">Medida</th>
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
                                    $residuosAgrupados[$idResiduo]['id_trajeto'] += $coleta['id_trajeto'];
                                } else {
                                    $residuosAgrupados[$idResiduo]['quantidade'] = $quantidade;
                                    $residuosAgrupados[$idResiduo]['id_setor_empresa'] = $coleta['id_setor_empresa'];
                                    $residuosAgrupados[$idResiduo]['id_trajeto'] = $coleta['id_trajeto'];
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
                                    <?= number_format($dadosResiduos['quantidade'], 0, '', '.'); ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap py-3 div-input-aferido">
                                    <input type="number" class="form-control input-aferido text-center input-obrigatorio"
                                        data-id-setor-empresa="<?= $dadosResiduos['id_setor_empresa'] ?>"
                                        data-id-residuo="<?= $idResiduo; ?>"
                                        data-qtd-coletada="<?= $dadosResiduos['quantidade']; ?>"
                                        data-id-trajeto="<?= $dadosResiduos['id_trajeto'] ?>">
                                    <div class="d-none aviso-obrigatorio">Preencha este campo.</div>
                                </td>

                                <td class="align-middle text-center white-space-nowrap py-3">
                                    <select class="form-select select-medida input-obrigatorio">
                                        <option selected disabled value="">Selecione</option>

                                        <?php foreach ($unidadesMedidas as $unidadeMedida) { ?>
                                            <option value="<?= $unidadeMedida['id']?>"><?= ucfirst($unidadeMedida['nome'])?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="d-none aviso-obrigatorio">Preencha este campo.</div>
                                </td>
                            </tr>
                        <?php } ?>




                    </tbody>
                </table>

                <div style="float: right;">
                    <div class="p-3">
                        <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    </div>
                    <button class="btn btn-phoenix-success my-4 d-flex btn-finalizar-afericao btn-form">Finalizar</button>
                </div>

            </div>

        </div>
    </div>
<div class="content">

    <div class="pb-5">
        <div class="row g-4">
            <div class="col-12 col-xxl-12">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-success-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-success " data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <?= number_format($faturamento['valor'], 2, ',', '.') ?></span></h4>
                                <p class="text-800 fs--1 mb-0">Faturamento - <?= $dataInicio ? "$dataInicio - $dataFim" : "Últimos 30 dias" ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-danger-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-danger " data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <?= number_format($despesa['valor'], 2, ',', '.') ?></span></h4>
                                <p class="text-800 fs--1 mb-0">Total Despesas - <?= $dataInicio ? "$dataInicio - $dataFim" : "Últimos 30 dias" ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-info-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-info-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-info " data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <?= number_format($balancoFinanceiro, 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Balanço</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-primary-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-primary-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-primary " data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0"><span class="total-recebido-front"><?= isset($porcentagemFaturamento) ? number_format($porcentagemFaturamento, 2, ',', '.') : "0" ?>%</span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Faturamento em %</p>
                            </div>
                        </div>
                    </div>

                </div>
                <hr class="bg-200 mb-6 mt-3" />
            </div>

            <form id="filtroForm" action="<?= base_url('finDre/index') ?>" method="post">
                <div class="col-12">
                    <div class="row align-items-center g-4">
                        <div class="col-12 col-md-4">
                            <div class="ms-3">
                                <input class="form-control datetimepicker" value="<?= $dataInicio ?>" required name="data_inicio" id="data_inicio" type="text" placeholder="Data Início" data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="ms-3">
                                <input class="form-control datetimepicker" value="<?= $dataFim ?>" required name="data_fim" id="data_fim" type="text" placeholder="Data Fim" data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="ms-3">
                                <button type="submit" class="btn btn-phoenix-secondary bg-white hover-bg-100 w-100">Filtrar</button>
                            </div>
                        </div>
                    </div>
                    <hr class="bg-200 mb-6 mt-4" />
                </div>
            </form>

        </div>
    </div>

    <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
        <div data-list='{"valueNames":["td_tipo","td_valor","td_porcentagem"],"page":40,"pagination":true}'>
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <h3>Despesas</h3>
                </div>

            </div>
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr class="text-center">
                            <th class="sort align-middle" scope="col" data-sort="td_tipo">Tipo de despesa</th>
                            <th class="sort ps-5 align-middle" scope="col" data-sort="td_valor">Valor Pago</th>
                            <th class="sort ps-5 align-middle" scope="col" data-sort="td_porcentagem">% em relação ao faturamento</th>
                            <th class="sort text-end pe-0 align-middle" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">

                        <?php foreach ($despesas as $despesa) { ?>

                            <tr class="hover-actions-trigger btn-reveal-trigger position-static text-center">

                                <td class="align-middle td_tipo">
                                    <h6 class="text-900 mb-0">
                                        <?= $despesa['MACRO']?>
                                    </h6>
                                </td>

                                <td class="align-middle td_valor">
                                    <h6 class="mb-0 text-900">
                                        R$ <?= number_format($despesa['total_pago'], 2, ',', '.') ?>

                                    </h6>
                                </td>

                                <td class="align-middle td_porcentagem">
                                    <h6 class="text-900 mb-0">

                                        <?php $porcentagemFatura = ($faturamento['valor'] - $despesa['total_pago']) / $faturamento['valor'] * 100;?>
                                        <?=  number_format($porcentagemFatura, 2, ',', '.') ?>%
                                    </h6>
                                </td>

                                <td class="align-middle white-space-nowrap text-end pe-0">
                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item" href="#!" data-bs-toggle="modal" data-bs-target="#modalVisualizarFluxoCaixa">
                                                <span class="fas fa-eye"></span> Visualizar
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
<div class="content">

    <div class="pb-5">
        <div class="row g-4">
            <div class="col-12 col-xxl-12">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-info-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-info-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-info " data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <span class="total-caixa-front"><?= number_format($saldoTotal['saldo'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Total Caixa</p>
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
                                <h4 class="mb-0">R$ <span class="total-pago-front"><?= number_format($totalSaida['valor'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Total Saida</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-success-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-success " data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <span class="total-recebido-front"><?= number_format($totalEntrada['valor'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Total Entrada</p>
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
                                <h4 class="mb-0">R$ <span class="total-recebido-front"><?= number_format($balancoFinanceiro, 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Balanço</p>
                            </div>
                        </div>
                    </div>

                </div>
                <hr class="bg-200 mb-6 mt-3" />
            </div>

            <form id="filtroForm" action="<?= base_url('finFluxoCaixa/index') ?>" method="post">
                <div class="col-12">
                    <div class="row align-items-center g-4">
                        <div class="col-12 col-md-3">
                            <div class="ms-3">
                                <input class="form-control datetimepicker" value="<?= $dataInicio ?>" required name="data_inicio" id="data_inicio" type="text" placeholder="Data Início" data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="ms-3">
                                <input class="form-control datetimepicker" value="<?= $dataFim ?>" required name="data_fim" id="data_fim" type="text" placeholder="Data Fim" data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="ms-3">
                                <select class="select-validation select-orientacao" required name="movimentacao" id="movimentacao">
                                    <option selected disabled value=''>Tipo movimentação</option>
                                    <option <?= $tipoMovimentacao == 1 ? 'selected' : '' ?> value="1">Entrada</option>
                                    <option <?= $tipoMovimentacao == 0 ? 'selected' : '' ?> value="0">Saída</option>
                                    <option <?= $tipoMovimentacao == 'ambas' ? 'selected' : '' ?> value="ambas">Ambas
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-3" style="padding:0;">
                            <div class="d-flex ms-3">
                                <button type="submit" class="btn btn-phoenix-secondary bg-white hover-bg-100 me-2 <?= !$dataInicio ? 'w-100' : 'w-75'; ?>">Filtrar</button>
                                <?php if ($dataInicio) { ?>
                                    <a href="<?= base_url('finFluxoCaixa'); ?>" class="btn btn-phoenix-danger" title="Limpar Filtro"><i class="fas fa-ban"></i></a>
                                <?php } ?>
                            </div>
                        </div>


                    </div>
                    <hr class="bg-200 mb-6 mt-4" />
                </div>
            </form>

        </div>
    </div>

    <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
        <div id="members" data-list='{"valueNames":["td_data","td_recebido","td_transacao","td_tipo","td_valor","td_setor","td_micro","td_observacao"],"page":10,"pagination":true}'>
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <h3>Fluxo de caixa</h3>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="row g-2 gy-3">

                        <div class="col-auto flex-1">
                            <div class="search-box">
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input class="form-control search-input search form-control-sm" type="search" placeholder="Buscar" aria-label="Search" />
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>
                        </div>

                        <div class="col-auto">

                            <button class="btn btn-sm btn-phoenix-secondary bg-white hover-bg-100 action-btn btn-novo-lancamento" type="button" data-bs-toggle="modal" data-bs-target="#modalEntradaFluxo">Novo Lançamento</button>

                        </div>

                    </div>
                </div>
            </div>
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table id="table-fluxo" class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr class="text-center">
                            <th class="white-space-nowrap fs--1 ps-0 align-middle">
                                <div class="form-check mb-0 fs-0">
                                    <input class="form-check-input" id="checkbox-bulk-reviews-select" type="checkbox" data-bulk-select='{"body":"table-latest-review-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle text-center" scope="col" data-sort="td_data">Data</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_recebido">Pago/Recebido</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_transacao">Forma de Transação</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_tipo">Tipo</th>
                            <th class="sort ps-5 align-middle text-center" scope="col" data-sort="td_valor">Valor</th>
                            <th class="sort ps-5 align-middle text-center" scope="col" data-sort="td_setor">Setor</th>
                            <th class="sort ps-5 align-middle text-center" scope="col" data-sort="td_micro">Micro</th>
                            <th class="sort ps-5 align-middle text-center" scope="col" data-sort="td_observacao">Observação</th>
                            <th class="sort text-end pe-0 align-middle" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">

                        <?php foreach ($movimentacoes as $movimentacao) { ?>

                            <tr class="hover-actions-trigger btn-reveal-trigger position-static text-center">

                                <td class="fs--1 align-middle ps-0">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input" type="checkbox" />
                                    </div>
                                </td>

                                <td class="align-middle text-center data white-space-nowrap td_data">
                                    <h6 class="mb-0 text-900 text-center">
                                        <?= date('d/m/Y', strtotime($movimentacao['data_movimentacao'])); ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-center td_recebido">
                                    <h6 class="mb-0 text-900">

                                        <?php 
                                            if ($movimentacao['nome_dado_financeiro']) { 
                                                echo ucfirst($movimentacao['nome_dado_financeiro']);
                                            } else if (($movimentacao['FUNCIONARIO'])) {
                                                echo ucfirst($movimentacao['FUNCIONARIO']);
                                            } else {
                                                echo ucfirst($movimentacao['CLIENTE']);
                                            }
                                        ?>
                                    </h6>
                                </td>


                                <td class="align-middle text-center td_transacao">
                                    <h6 class="text-900 mb-0">
                                        <?= $movimentacao['nome_forma_transacao'] ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-center ps-3 td_tipo">
                                    <?php if ($movimentacao['movimentacao_tabela'] == 0) : ?>
                                        <span class="badge badge-phoenix fs--2 badge-phoenix-warning">
                                            <span class="badge-label">Saída</span>
                                            <span class="ms-1" data-feather="trending-down" style="height:12.8px;width:12.8px;"></span>
                                        </span>
                                    <?php else : ?>
                                        <span class="badge badge-phoenix fs--2 badge-phoenix-success">
                                            <span class="badge-label">Entrada</span>
                                            <span class="ms-1" data-feather="trending-up" style="height:12.8px;width:12.8px;"></span>
                                        </span>
                                    <?php endif; ?>
                                </td>


                                <td class="align-middle text-center">
                                    <h6 class="mb-0 text-900 text-center">
                                        <?= 'R$ ' . number_format($movimentacao['valor'], 2, ',', '.') ?>
                                    </h6>

                                    <div class="d-none td_valor">
                                        <input type="hidden" value="<?= $movimentacao['valor']; ?>">
                                    </div>
                                </td>

                                <td class="align-middle text-center td_setor">
                                    <h6 class="text-900 mb-0">
                                        <?= $movimentacao['NOME_SETOR'] ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-center td_micro">
                                    <h6 class="text-900 mb-0">
                                        <?= $movimentacao['NOME_MICRO'] ?>
                                    </h6>
                                </td>

                                <td class="align-middle td_observacao">
                                    <h6 class="text-900 mb-0">
                                        <?= $movimentacao['observacao'] ?? '-' ?>
                                    </h6>
                                </td>

                                <td class="align-middle white-space-nowrap text-end pe-0">
                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item" href="#!" data-bs-toggle="modal" data-bs-target="#modalVisualizarFluxoCaixa" onclick="visualizarFluxo(<?= $movimentacao['id'] ?>)">
                                                <span class="fas fa-eye"></span> Visualizar
                                            </a>

                                            <a class="dropdown-item" href="#!" onclick="deletarFluxo(<?= $movimentacao['id']; ?>, <?= $movimentacao['id_conta_bancaria']; ?>, <?= $movimentacao['valor']; ?>, <?= $movimentacao['movimentacao_tabela'] ?>)">
                                                <span class="fas fa-trash"></span> Deletar
                                            </a>

                                        </div>
                                    </div>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div>

            <!-- Links de Paginação usando classes Bootstrap -->
            <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
                <div class="col-auto d-none">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">Ver todos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">Ver menos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="col-auto d-flex w-100 justify-content-end mt-2 mb-2">
                    <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal visualizar contas a receber -->
    <div class="modal fade" tabindex="-1" id="modalVisualizarFluxoCaixa">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title data-fluxo"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">
                                            <div class="col-sm-12 col-xxl-12 border-bottom py-3">
                                                <table class="w-100 table-stats">
                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-id-card-alt" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Grupo Macro/Micro</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">
                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break macro-micro html-clean">
                                                                Conta de Água
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300" data-feather="calendar" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Recebido</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">
                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break recebido data-coleta html-clean">
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-money-check-alt" data-feather="calendar" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Valor</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">
                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break valor-fluxo html-clean">

                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-money-check-alt" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Forma Pagamento</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">

                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break forma-pagamento html-clean">

                                                            </div>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-money-check-alt" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Setor</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">

                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break setor-empresa html-clean">

                                                            </div>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-message" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Observação</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">

                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break observacao html-clean">

                                                            </div>

                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Incluir lançamento Caixa -->
    <div class="modal fade" tabindex="-1" id="modalEntradaFluxo">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Lançamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Tipo</label>
                                                    <select class="form-select input-fluxo-obrigatorio select-tipo-conta">
                                                        <option selected disabled>Selecione</option>
                                                        <option value="1">Entrada</option>
                                                        <option value="0">Saída</option>

                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data</label>
                                                    <input class="form-control datetimepicker input-fluxo-obrigatorio input-coleta mascara-data" required name="data_movimentacao" type="text" placeholder="dd/mm/aaaa" data-options='{"disableMobile":true,"allowInput":true, "dateFormat": "d/m/Y"}' style="cursor: pointer;" />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Grupos
                                                        Macros</label>
                                                    <select class="form-select select2 select-macros input-fluxo-obrigatorio dados-conta" name="macros">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($macros as $macro) { ?>
                                                            <option value="<?= $macro['id'] ?>"><?= $macro['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-4 ">
                                                    <label class="text-body-highlight fw-bold mb-2 ">Grupos
                                                        Micros</label>
                                                    <select disabled class="form-select select2 select-micros input-fluxo-obrigatorio dados-conta" name="micros">
                                                        <option selected disabled value="">Selecione</option>
                                                        <!-- JS -->
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Grupo
                                                        recebidos</label>
                                                    <select class="form-select select2 select-grupo-recebidos select2 input-fluxo-obrigatorio" name="grupo-recebido">
                                                        <option selected disabled>Selecione</option>
                                                        <?php foreach ($grupos as $grupo) { ?>
                                                            <option value="<?= $grupo['id'] ?>"><?= $grupo['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                        <option value="clientes">Clientes</option>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>


                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Recebido</label>
                                                    <select class="form-select select2 select-recebido select2 input-fluxo-obrigatorio" name="cadastroFinanceiro">
                                                        <option selected disabled>Selecione</option>
                                                        <?php foreach ($dadosFinanceiro as $dadoFinanceiro) { ?>
                                                            <option value="<?= $dadoFinanceiro['id'] ?>">
                                                                <?= $dadoFinanceiro['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Conta
                                                        Bancária</label>
                                                    <select name="contaBancaria" class="form-select select2 select-conta-bancaria input-fluxo-obrigatorio">
                                                        <option value="" selected disabled>Selecione</option>
                                                        <?php foreach ($contasBancarias as $contaBancaria) { ?>
                                                            <option value="<?= $contaBancaria['id_conta_bancaria'] ?>">
                                                                <?= $contaBancaria['apelido'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Forma
                                                        Pagamento</label>
                                                    <select name="formaPagamento" class="form-select select2 select-forma-pagamento select2 input-fluxo-obrigatorio">
                                                        <option value="" selected disabled>
                                                            Selecione</option>
                                                        <?php foreach ($formasTransacao as $formaTransacao) { ?>
                                                            <option value="<?= $formaTransacao['id'] ?>">
                                                                <?= $formaTransacao['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                    <input class="form-control input-valor-recebido mascara-dinheiro input-valor-unic input-fluxo-obrigatorio" required name="valor" type="text" placeholder="Valor">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>
                                            </div>


                                            <div class="col-lg-12">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                    <textarea name="observacao" class="form-control"></textarea>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button class="btn btn-success btn-form btn-insere-fluxo" type="button">Salvar</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>
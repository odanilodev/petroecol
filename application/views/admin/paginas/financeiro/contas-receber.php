<div class="content">
    <div class="pb-5">
        <div class="row g-4">
            <div class="col-12 col-xxl-6">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-md-4">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-success-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-success " data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <span class="total-caixa-front"><?= number_format($saldoTotal['saldo'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Total Caixa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-success-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-success " data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <span class="total-recebido-front"><?= number_format($totalRecebido['valor_recebido'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Total Recebido</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-warning-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-warning" data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <span class="total-aberto-front"><?= number_format($emAberto['valor'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">A Receber</p>
                            </div>
                        </div>
                    </div>

                </div>
                <hr class="bg-200 mb-6 mt-3" />
            </div>
            <div class="col-12 col-xxl-6">
                <form id="filtroForm" action="<?= base_url('finContasReceber/index') ?>" method="post">
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
                                    <select class="select-validation select-orientacao" required name="status" id="movimentacao">
                                        <option selected disabled value=''>Status</option>
                                        <option <?= $status == 1 ? 'selected' : '' ?> value="1">Recebido</option>
                                        <option <?= $status == 0 ? 'selected' : '' ?> value="0">A receber</option>
                                        <option <?= $status == 'ambas' ? 'selected' : '' ?> value="ambas">Ambas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
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
    </div>
    <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
        <div id="members" data-list='{"valueNames":["td_vencimento","td_valor", "td_valor_recebido","td_status","td_data_recebimento","td_recebido" ],"page":10,"pagination":true}'>
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <h3>Contas a receber</h3>
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

                            <button class="btn btn-sm btn-phoenix-secondary bg-white hover-bg-100 action-btn novo-lancamento" type="button" data-bs-toggle="modal" data-bs-target="#modalEntradaContasReceber">Lançamento</button>

                        </div>

                    </div>
                </div>
            </div>
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs--1 ps-0 align-middle">
                                <div class="form-check mb-0 fs-0">
                                    <input class="form-check-input" id="checkbox-bulk-reviews-select" type="checkbox" data-bulk-select='{"body":"table-latest-review-body"}' />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle text-center" scope="col" data-sort="td_vencimento">Vencimento
                            </th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_valor">Valor</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_valor_recebido">
                                Valor
                                Recebido</th>
                            <th class="sort text-start ps-5 align-middle text-center" scope="col" data-sort="td_status">
                                Status</th>
                            <th class="sort white-space-nowrap align-middle text-center" scope="col" data-sort="td_data_recebimento">Data
                                Recebimento</th>
                            <th class="sort text-start align-middle text-center" scope="col" data-sort="td_recebido">
                                Recebido</th>
                            <th class="sort text-end pe-0 align-middle" scope="col"></th>
                            <th class="sort text-end pe-0 align-middle" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">
                        <?php foreach ($contasReceber as $contaReceber) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                <td class="fs--1 align-middle ps-0">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input" type="checkbox" data-bulk-select-row='' />
                                    </div>
                                </td>

                                <td class="align-middle product white-space-nowrap text-center td_vencimento">
                                    <h6 class="mb-0 text-900">
                                        <?= date('d/m/Y', strtotime($contaReceber['data_vencimento'])) ?>
                                    </h6>
                                </td>

                                <td class="align-middle white-space-nowrap fs--2 text-center td_valor">
                                    <h6 class="mb-0 text-900" value="<?= $contaReceber['valor']; ?>">
                                        <?= 'R$' . number_format($contaReceber['valor'], 2, ',', '.'); ?>
                                    </h6>
                                </td>

                                <td class="align-middle white-space-nowrap fs--2 text-center td_valor_recebido">
                                    <h6 class="mb-0 text-900 valor-recebido-<?= $contaReceber['id'] ?>" value="<?= $contaReceber['valor_recebido'] ?>">
                                        <?= $contaReceber['valor_recebido'] ? 'R$' . number_format($contaReceber['valor_recebido'], 2, ',', '.') : '-' ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-start ps-3 status text-center td_status">
                                    <span class="badge badge-phoenix fs--2 <?= $contaReceber['status'] ? "badge-phoenix-success" : "badge-phoenix-danger" ?> tipo-status-conta-<?= $contaReceber['id'] ?>">
                                        <span data-valor="<?= number_format($contaReceber['valor'], 2, ',', '.'); ?>" class="badge-label cursor-pointer receber-conta status-pagamento-table-<?= $contaReceber['id'] ?>" data-id-dado-financeiro="<?= $contaReceber['id_dado_financeiro'] ?>" data-id="<?= $contaReceber['id'] ?>" <?= !$contaReceber['status'] ? 'data-bs-toggle="modal" data-bs-target="#modalReceberConta"' : '' ?>>
                                            <?= $contaReceber['status'] ? "Recebido" : "A receber" ?>
                                        </span>

                                        <span class="ms-1 icone-status-conta-<?= $contaReceber['id'] ?>" data-feather="<?= $contaReceber['status'] ? "check" : "slash" ?>" style="height:12.8px;width:12.8px;"></span>

                                    </span>
                                </td>

                                <td class="align-middle product white-space-nowrap text-center td_data_recebimento">
                                    <h6 class="mb-0 text-900 data-recebimento-<?= $contaReceber['id'] ?>">
                                        <?= $contaReceber['data_recebimento'] ? date('d/m/Y', strtotime($contaReceber['data_recebimento'])) : '-' ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-start time text-center td_recebido">
                                    <h6 class="text-900 mb-0">
                                        <?= $contaReceber['RECEBIDO'] ?>
                                    </h6>
                                </td>

                                <td class="align-middle review text-center">
                                    <h6 class="mb-0 text-900"></h6>
                                </td>

                                <td class="align-middle white-space-nowrap text-end pe-0 text-center">

                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item" href="#!" data-bs-toggle="modal" data-bs-target="#modalVisualizarContasReceber">
                                                <span class="fas fa-eye"></span> Visualizar
                                            </a>
                                            <?php if (!$contaReceber['status']) { ?>

                                                <a class="dropdown-item editar-lancamento" href="#!" data-bs-toggle="modal" data-id="<?= $contaReceber['id'] ?>" data-valor="<?= number_format($contaReceber['valor'], 2, ',', '.'); ?>" data-bs-target="#modalEditarContasReceber">
                                                    <span class="fas fa-pencil"></span> Editar
                                                </a>

                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item receber-conta" data-id="<?= $contaReceber['id'] ?>" href="#!" data-bs-toggle="modal" data-bs-target="#modalReceberConta">Receber
                                                    Conta</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
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
    <div class="modal fade" tabindex="-1" id="modalVisualizarContasReceber">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalhes da conta</h5>
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
                                                                <p class="fw-bold mb-0">Empresa</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">
                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break data-coleta html-clean">
                                                                Centro da Inteligência
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300" data-feather="calendar" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Data de vencimento</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">
                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break data-coleta html-clean">
                                                                10/04/2024
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300" data-feather="calendar" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Data de Emissão</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">
                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break responsavel-coleta html-clean">
                                                                10/04/2024
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-money-check-alt" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Valor</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">

                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break residuos-coletados html-clean">
                                                                R$ 250,25
                                                            </div>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-money-check-alt" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Valor Pago</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">

                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break residuos-coletados html-clean">
                                                                R$ 240,25
                                                            </div>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-money-check-alt" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Valor em Aberto</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">

                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break residuos-coletados html-clean">
                                                                R$ 10,00
                                                            </div>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-money-check-alt" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Observação</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2">

                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break residuos-coletados html-clean">
                                                                observação detalhada aparecerá aqui
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

                    <button class="btn btn-success btn-form" type="button">Realizar Pagamento</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Entrada Contas a receber -->

    <div class="modal fade" tabindex="-1" id="modalEntradaContasReceber">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalhes da conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body form-entrada-receber">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Grupos
                                                        Macros</label>
                                                    <select class="form-select select2 select-macros input-obrigatorio" name="macros">
                                                        <option selected disabled>Selecione</option>
                                                        <?php foreach ($macros as $macro) { ?>
                                                            <option value="<?= $macro['id'] ?>">
                                                                <?= $macro['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Grupos
                                                        Micros</label>
                                                    <select disabled class="form-select select2 select-micros input-obrigatorio" name="micros">
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
                                                    <select class="form-select select2 select-grupo-recebidos input-obrigatorio" name="grupo-recebido">
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
                                                    <select class="form-select select2 select-recebido input-obrigatorio" name="recebido">
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
                                                    <label class="text-body-highlight fw-bold mb-2">Parcelas</label>
                                                    <select class="form-select select2 select-parcelas" name="parcelas">
                                                        <option selected disabled>Selecione</option>
                                                        <option value="1">1x</option>
                                                        <option value="2">2x</option>
                                                        <option value="3">3x</option>
                                                        <option value="4">4x</option>
                                                        <option value="5">5x</option>
                                                        <option value="6">6x</option>
                                                        <option value="7">7x</option>
                                                        <option value="8">8x</option>
                                                        <option value="9">9x</option>
                                                        <option value="10">10x</option>
                                                        <option value="11">11x</option>
                                                        <option value="12">12x</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data
                                                        Vencimento</label>
                                                    <input class="form-control datetimepicker cursor-pointer input-data-vencimento input-obrigatorio" required name="data_vencimento" type="text" placeholder="dd/mm/aaaa" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data Emissão</label>
                                                    <input class="form-control datetimepicker cursor-pointer input-data-emissao" required name="data_emissao" type="text" placeholder="dd/mm/aaaa" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                    <input class="form-control mascara-dinheiro input-valor input-obrigatorio" required name="valor" type="text" placeholder="Valor total da conta">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>
                                                

                                            </div>

                                            <div class="col-lg-8">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                    <textarea class="form-control observacao" name="observacao"></textarea>
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
                    <button class="btn btn-primary btn-form" type="button" onclick="cadastraContasReceber('form-entrada-receber')">Salvar</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Contas a receber -->
    <div class="modal fade" tabindex="-1" id="modalEditarContasReceber">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editando Detalhes da conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body form-editar-receber">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data Vencimento</label>
                                                    <input class="form-control datetimepicker cursor-pointer input-data-vencimento input-obrigatorio dados-conta" required name="data_vencimento" type="text" placeholder="dd/mm/aaaa" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>
                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data Emissão</label>
                                                    <input class="form-control datetimepicker cursor-pointer input-data-emissao dados-conta" required name="data_emissao" type="text" placeholder="dd/mm/aaaa" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                    <input class="form-control input-obrigatorio mascara-dinheiro input-editar-valor dados-conta" required name="valor" type="text" placeholder="Valor total da conta">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-12 div-observacao">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                    <textarea class="form-control input-observacao" name="observacao"></textarea>
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
                    <input type="hidden" class="id-editar-conta">
                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button class="btn btn-success btn-form" type="button" onclick="cadastraContasReceber('form-editar-receber')">Salvar</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Receber conta -->
    <div class="modal fade" tabindex="-1" id="modalReceberConta">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Receber pagamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-md-4">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data
                                                        Recebimento</label>
                                                    <input class="form-control datetimepicker input-data-recebimento cursor-pointer" name="data_recebimento" type="text" placeholder="dd/mm/aaaa" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                                                </div>
                                            </div>

                                            <div class="campos-pagamento row">
                                                <div class="col-lg-4 duplica-pagamento">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Conta
                                                            Bancária</label>
                                                        <select class="form-select select2 select-conta-bancaria">
                                                            <option value="" selected disabled>Selecione</option>
                                                            <?php foreach ($contasBancarias as $contaBancaria) { ?>
                                                                <option value="<?= $contaBancaria['id_conta_bancaria'] ?>">
                                                                    <?= $contaBancaria['apelido'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 duplica-pagamento">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Forma
                                                            Pagamento</label>
                                                        <select class="form-select select2 select-forma-pagamento">
                                                            <option value="" selected disabled>Selecione</option>
                                                            <?php foreach ($formasTransacao as $formaTransacao) { ?>
                                                                <option value="<?= $formaTransacao['id'] ?>">
                                                                    <?= $formaTransacao['nome'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 duplica-pagamento">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                        <input class="form-control input-valor-recebido mascara-dinheiro input-valor-unic" required name="valor" type="text" placeholder="Valor">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 mt-5">
                                                    <button title="Mais formas de pagamento" type="button" class="btn btn-phoenix-success bg-white hover-bg-100" onclick="duplicarFormasPagamento()">+</button>
                                                </div>
                                            </div>
                                            <div class="campos-duplicados row">
                                                <!-- JS -->
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                    <textarea class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p style="padding-left: 1rem;">Total:
                    <span class="valor-total-conta fw-bold">
                        <!-- JS -->
                    </span>
                </p>

                <div class="modal-footer">
                    <input type="hidden" class="id-conta-pagamento">
                    <input type="hidden" class="id-dado-financeiro">
                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button class="btn btn-primary btn-form" type="button" onclick="receberConta()">Pagar
                        Conta</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
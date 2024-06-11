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
                                <h4 class="mb-0">R$ <span class="total-caixa-front"><?= number_format($saldoTotal['saldo'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Total Caixa</p>
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
                                <h4 class="mb-0">R$ <span class="total-pago-front"><?= number_format($totalPago['valor'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Total Pago</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-warning-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-warning" data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <span class="total-aberto-front"><?= number_format($emAberto['valor'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Despesas em Aberto</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-info-300" data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-info-100" data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-info" data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <span class="total-setor-front"><?= number_format($porSetor['saldo'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Saldo do Setor <?= $nomeSaldoSetor ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="bg-200 mb-6 mt-3" />
            </div>

            <div class="col-12 col-xxl-12 mt-0">
                <form id="filtroForm" action="<?= base_url('finContasPagar/') ?>" method="post">
                    <div class="col-12">
                        <div class="row align-items-center g-4">

                            <h4 class="ms-3">Filtrar resultados</h4>

                            <div class="col-12 col-md-3">
                                <div class="ms-3">
                                    <input class="form-control datetimepicker" value="<?= $dataInicio ?>" required name="data_inicio" id="data_inicio" type="text" placeholder="Selecione a data de início" data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="ms-3">
                                    <input class="form-control datetimepicker" value="<?= $dataFim ?>" required name="data_fim" id="data_fim" type="text" placeholder="Seleciona a data final" data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="ms-3">
                                    <select class="select-validation select-orientacao" required name="status" id="status">
                                        <option <?= $status == 'ambas' ? 'selected' : '' ?> disabled> Status da conta</option>
                                        <option <?= $status == '0' ? 'selected' : '' ?> value="0">Em aberto</option>
                                        <option <?= $status == '1' ? 'selected' : '' ?> value="1">Paga</option>
                                        <option <?= $status == 'ambas' && $this->uri->segment(2) == 'index' ? 'selected' : '' ?> value="ambas">Ambos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="ms-3">
                                    <select class="select-validation select-setor" required name="setor" id="setor">
                                        <option selected disabled>Setor da conta</option>
                                        <option <?= $idSetor == 'todos' ? 'selected' : '' ?> value="todos">Todos</option>
                                        <?php foreach ($setoresEmpresa as $setor) { ?>
                                            <option <?= $idSetor == $setor['id'] ? 'selected' : '' ?> value="<?= $setor['id'] ?>"><?= $setor['nome'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="nomeSetor" id="nomeSetor">

                            <div class="col-12 col-md-2">
                                <div class="ms-3">
                                    <button type="submit" class="btn btn-phoenix-secondary bg-white hover-bg-100 <?=!$dataInicio ? 'w-100' : '';?>">Filtrar</button>

                                    <?php if ($dataInicio) { ?>
                                        <a href="<?= base_url('finContasPagar'); ?>" class="btn btn-phoenix-danger" title="Limpar Filtro"><i class="fas fa-ban"></i></a>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
                <hr class="bg-200 mb-6 mt-4" />
            </div>
        </div>
    </div>

    <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
        <div id="members" data-list='{"valueNames":["td_vencimento","td_valor","td_valor_pago","td_status_pgto","td_data_pagamento","td_empresa","td_recebido","td_setor", "td_observacao"],"page":10,"pagination":true}'>
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <h3>Contas a pagar

                        <a href="#" class="btn btn-phoenix-success d-none btn-pagar-tudo mx-2" data-bs-toggle="modal" data-bs-target="#modalPagarVariasContas"><span data-feather="dollar-sign"></span> Pagar
                            todos</a>
                        <a href="#" class="btn btn-phoenix-danger d-none btn-excluir-contas mx-2" onclick="deletaContaPagar()"><span class="fas fa-trash"></span> Excluir tudo</a>



                    </h3>
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

                            <button class="btn btn-sm btn-phoenix-secondary bg-white hover-bg-100 action-btn novo-lancamento" type="button" data-bs-toggle="modal" data-bs-target="#modalTipoContasPagar">Lançamento</button>

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
                                    <input class="form-check-input check-all-element cursor-pointer" id="checkbox-bulk-reviews-select" type="checkbox" />
                                </div>
                            </th>
                            <th class="sort white-space-nowrap align-middle text-center" scope="col" data-sort="Vencimento">Vencimento
                            </th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_valor">Valor</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_valor_pago">Valor Pago
                            </th>
                            <th class="sort text-start ps-5 align-middle text-center" scope="col" data-sort="td_status_pgto">Status</th>
                            <th class="sort align-middle text-center" style="text-align: center; vertical-align: middle;" scope="col" data-sort="td_data_pagamento text-center">Data do Pagamento</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_empresa">Empresa</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_setor">Setor</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_observacao">Observação</th>
                            
                            <th class="sort text-end pe-0 align-middle text-center" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">

                        <?php foreach ($contasPagar as $contaPagar) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static tr-pagamento">

                                <td class="fs--1 align-middle ps-0">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input check-element cursor-pointer <?= !$contaPagar['status'] ? 'check-aberto' : '' ?>" type="checkbox" value="<?= $contaPagar['id'] ?>" data-id-dado-financeiro="<?= $contaPagar['id_dado_financeiro'] ?>" data-nome-empresa="<?= $contaPagar['RECEBIDO'] ? ucfirst($contaPagar['RECEBIDO']) : ucfirst($contaPagar['CLIENTE']); ?>" data-id-dado-cliente="<?= $contaPagar['id_cliente'] ?>"/>
                                    </div>
                                </td>

                                <td class="align-middle product white-space-nowrap td_vencimento text-center">
                                    <h6 class="mb-0 text-900">
                                        <?= date('d/m/Y', strtotime($contaPagar['data_vencimento'])) ?>
                                    </h6>
                                </td>

                                <td class="align-middle rating white-space-nowrap fs--2 td_valor text-center <?= !$contaPagar['status'] ? 'td-valor-aberto' : '' ?>" data-valor="<?= $contaPagar['valor'] ?>">
                                    <h6 class="mb-0 text-900">R$
                                        <?= number_format($contaPagar['valor'], 2, ',', '.'); ?>
                                    </h6>
                                </td>

                                <td class="align-middle review td_valor_pago text-center">
                                    <h6 class="mb-0 text-900 valor-pago-<?= $contaPagar['id'] ?>">R$
                                        <?= number_format($contaPagar['valor_pago'], 2, ',', '.'); ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-start ps-3 status td_status_pgto text-center">
                                    <span class="badge badge-phoenix fs--2 <?= $contaPagar['status'] ? "badge-phoenix-success" : "badge-phoenix-danger" ?> tipo-status-conta-<?= $contaPagar['id'] ?>">
                                        <span data-valor="<?= number_format($contaPagar['valor'], 2, ',', '.'); ?>" class="badge-label cursor-pointer realizar-pagamento status-pagamento-<?= $contaPagar['id'] ?>" data-id="<?= $contaPagar['id'] ?>" data-id-dado-financeiro="<?= $contaPagar['id_dado_financeiro'] ?>" <?= !$contaPagar['status'] ? 'data-bs-toggle="modal" data-bs-target="#modalPagarConta"' : "" ?> data-id-dado-cliente="<?= $contaPagar['id_cliente'] ?>">
                                            <?= $contaPagar['status'] ? "Pago" : "Em aberto" ?>
                                        </span>
                                        <span class="ms-1 icone-status-conta-<?= $contaPagar['id'] ?>" data-feather="<?= $contaPagar['status'] ? "check" : "slash" ?>" style="height:12.8px;width:12.8px;"></span>
                                    </span>
                                </td>

                                <td class="align-middle customer white-space-nowrap td_data_pagamento text-center">
                                    <h6 class="mb-0 text-900">
                                        <span class="data-pagamento-<?= $contaPagar['id'] ?>"><?= isset($contaPagar['data_pagamento']) ? date('d/m/Y', strtotime($contaPagar['data_pagamento'])) : '-' ?></span>
                                    </h6>
                                </td>

                                <td class="align-middle review td_empresa text-center">
                                    <h6 class="mb-0 text-900">

                                        <?= $contaPagar['RECEBIDO'] ? ucfirst($contaPagar['RECEBIDO']) : ucfirst($contaPagar['CLIENTE']);?>
                                    </h6>
                                </td>

                                <td class="align-middle product white-space-nowrap td_setor text-center">
                                    <h6 class="mb-0 text-900">
                                        <?= $contaPagar['SETOR']; ?>
                                    </h6>
                                </td>

                                <td class="align-middle product white-space-nowrap td_setor text-center">
                                    <h6 class="mb-0 text-900">
                                        <?= $contaPagar['observacao']; ?>
                                    </h6>
                                </td>

                                <td class="align-middle white-space-nowrap text-end pe-0">

                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item" href="#" onclick="visualizarConta(<?= $contaPagar['id'] ?>)" data-bs-toggle="modal" data-bs-target="#modalVisualizarContasPagar">
                                                <span class="fas fa-eye"></span> Visualizar
                                            </a>

                                            <?php if (!$contaPagar['status']) { ?>
                                                <a class="dropdown-item editar-lancamento btn-editar-<?= $contaPagar['id'] ?>" href="#!" data-bs-toggle="modal" data-id="<?= $contaPagar['id'] ?>" data-valor="<?= number_format($contaPagar['valor'], 2, ',', '.'); ?>" data-bs-target="#modalEditarContasPagar">
                                                    <span class="fas fa-pencil"></span> Editar
                                                </a>

                                                <a class="dropdown-item editar-lancamento btn-excluir-<?= $contaPagar['id'] ?>" href="#" onclick="deletaContaPagar(<?= $contaPagar['id'] ?>)">
                                                    <span class="fas fa-trash"></span> Excluir
                                                </a>

                                                <div class="dropdown-divider btn-realizar-pagamento-<?= $contaPagar['id'] ?>"></div>
                                                <a class="dropdown-item realizar-pagamento btn-realizar-pagamento-<?= $contaPagar['id'] ?>" data-valor="<?= number_format($contaPagar['valor'], 2, ',', '.'); ?>" data-id="<?= $contaPagar['id'] ?>" href="#!" data-bs-toggle="modal" data-bs-target="#modalPagarConta" data-id-dado-cliente="<?= $contaPagar['id_cliente'] ?>" data-id-dado-financeiro="<?= $contaPagar['id_dado_financeiro'] ?>">Realizar
                                                    Pagamento</a>
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


    <!-- Modal visualizar contas a pagar -->
    <div class="modal fade" tabindex="-1" id="modalVisualizarContasPagar">
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
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-id-card" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Setor</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">
                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break setor-empresa html-clean">
                                                                <!-- JS -->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-id-card-alt" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Empresa</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">
                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break nome-empresa html-clean">
                                                                <!-- JS -->
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300" data-feather="calendar" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Data de vencimento</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">
                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break data-vencimento html-clean">
                                                                <!-- JS -->
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300" data-feather="calendar" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Data de Emissão</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">
                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break data-emissao html-clean">
                                                                <!-- JS -->
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr class="div-data-pagamento d-none">
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300" data-feather="calendar" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Data de Pagamento</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">

                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break data-pagamento html-clean">
                                                                <!-- JS -->
                                                            </div>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-money-check-alt" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Valor</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">

                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break valor-conta html-clean">
                                                                <!-- JS -->
                                                            </div>

                                                        </td>
                                                    </tr>

                                                    <tr class="div-valor-pago d-none">
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-money-check-alt" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Valor Pago</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">

                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break valor-pago html-clean">
                                                                <!-- JS -->
                                                            </div>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300 fas fa-message" style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Observação</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">

                                                            <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break obs-conta html-clean">
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

                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal escolher tipo de lançamento Contas a Pagar -->

    <div class="modal fade" tabindex="-1" id="modalTipoContasPagar">
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

                                            <div class="col-lg-12">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Tipo de conta</label>
                                                    <select class="form-select select-tipo-conta" name="tipo-conta">
                                                        <option selected disabled value="">Selecione</option>
                                                        <option value="comum">Comum</option>
                                                        <option value="recorrente">Recorrente</option>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
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
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>
                    <button class="btn btn-info btn-form btn-proxima-etapa-lancamento" type="button">Próxima Etapa</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Lançamento Contas a Pagar Comum -->

    <div class="modal fade" tabindex="-1" id="modalLancamentoContasPagar">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Lançamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body form-entrada-pagar">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-lg-12">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Setor da Empresa</label>
                                                    <select class="form-select select2 select-setor-empresa input-obrigatorio dados-conta" name="setor">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($setoresEmpresa as $setor) { ?>
                                                            <option value="<?= $setor['id'] ?>"><?= $setor['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4 div-select-macro">
                                                    <label class="text-body-highlight fw-bold mb-2">Grupos
                                                        Macros</label>
                                                    <select class="form-select select2 select-macros input-obrigatorio dados-conta" name="macros">
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
                                                <div class="mb-4 div-select-micro">
                                                    <label class="text-body-highlight fw-bold mb-2 ">Grupos
                                                        Micros</label>
                                                    <select disabled class="form-select select2 select-micros input-obrigatorio dados-conta" name="micros">
                                                        <option selected disabled value="">Selecione</option>
                                                        <!-- JS -->
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>


                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">
                                                        Grupo de Credores</label>
                                                    <select class="form-select select2 select-grupo-recebidos input-obrigatorio dados-conta" name="grupo-recebido">
                                                        <option selected disabled value="">Selecione</option>
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

                                                <div class="mb-4 ">
                                                    <label class="text-body-highlight fw-bold mb-2">Recebido</label>
                                                    <select disabled class="form-select select2 select-recebido input-obrigatorio dados-conta" name="recebido">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($dadosFinanceiro as $dadoFinanceiro) { ?>
                                                            <option data-nome="<?= $dadoFinanceiro['nome'] ?>" value="<?= $dadoFinanceiro['id'] ?>">
                                                                <?= $dadoFinanceiro['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    <input type="hidden" name="nome-recebido" class="nome-recebido">

                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Parcelas</label>
                                                    <select class="form-select select2 select-parcela dados-conta" name="parcelas">
                                                        <option selected disabled value="">Selecione</option>
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
                                                    <input class="form-control input-obrigatorio mascara-dinheiro dados-conta" required name="valor" type="text" placeholder="Valor total da conta">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>


                                            </div>

                                            <div class="col-lg-8 div-observacao">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                    <textarea class="form-control dados-conta" name="observacao"></textarea>
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
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Voltar</button>
                    <button class="btn btn-success btn-form" type="button" onclick="cadastraContasPagar('form-entrada-pagar')">Salvar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Contas a Pagar Recorrentes -->

    <div class="modal fade" tabindex="-1" id="modalSelecionarContasPagarRecorrentes">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Selecione as contas recorrentes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">
                                            <div class="table-responsive mx-n1 px-1 scrollbar">
                                                <table class="table fs--1 mb-0 border-top border-200">
                                                    <thead>
                                                        <tr>
                                                            <th class="white-space-nowrap fs--1 ps-0 align-middle">
                                                                <div class="form-check mb-0 fs-0">
                                                                    <input class="form-check-input check-all-modal-element cursor-pointer" id="checkbox-bulk-reviews-select" type="checkbox" />
                                                                </div>
                                                            </th>
                                                            <th class="sort align-middle text-center" scope="col" data-sort="td_valor">Credor</th>
                                                            <th class="sort align-middle text-center" scope="col" data-sort="td_valor">Micro</th>
                                                            <th class="sort text-start ps-5 align-middle text-center" scope="col" data-sort="td_status_pgto">Dia do Pagamento</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list" id="table-latest-review-body">

                                                        <?php foreach ($contasRecorrentes as $contaRecorrente) { ?>
                                                            <tr class="hover-actions-trigger btn-reveal-trigger position-static tr-pagamento">

                                                                <td class="fs--1 align-middle ps-0">
                                                                    <div class="form-check mb-0 fs-0">
                                                                        <input class="form-check-input check-element-modal check-element cursor-pointer" type="checkbox" value="<?= $contaRecorrente['id'] ?>" />
                                                                    </div>
                                                                </td>

                                                                <td class="align-middle product white-space-nowrap td_vencimento text-center">
                                                                    <h6 class="mb-0 text-900">

                                                                        <?= $contaRecorrente['RECEBIDO'] ? ucfirst($contaRecorrente['RECEBIDO']) : ucfirst($contaRecorrente['CLIENTE']);?>

                                                                    </h6>
                                                                </td>

                                                                <td class="align-middle product white-space-nowrap td_vencimento text-center">
                                                                    <h6 class="mb-0 text-900">
                                                                        <?= $contaRecorrente['MICRO'] ?>
                                                                    </h6>
                                                                </td>

                                                                <td class="align-middle rating white-space-nowrap fs--2 td_valor text-center">
                                                                    <h6 class="mb-0 text-900">
                                                                        <?= $contaRecorrente['dia_pagamento']; ?>
                                                                    </h6>
                                                                </td>
                                                                
                                                            </tr>

                                                        <?php } ?>
                                                    </tbody>
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
                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Voltar</button>
                    <button class="btn btn-info btn-form btn-proxima-etapa-recorrente" type="button">Próxima etapa</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalLancamentoContasPagarRecorrentes">
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
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0 lista-contas-recorrentes form-entrada-pagar-recorrentes">
                                           <!-- JS -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Voltar</button>
                    <button class="btn btn-success btn-form" type="button" onclick="cadastraMultiplasContasPagar('form-entrada-pagar-recorrentes')">Salvar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Contas a Pagar -->

    <div class="modal fade" tabindex="-1" id="modalEditarContasPagar">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editando Detalhes da conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body form-editar-pagar">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-lg-12">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Setor da Empresa</label>
                                                    <select class="form-select select2 select-setor-empresa input-obrigatorio" name="setor">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($setoresEmpresa as $setor) { ?>
                                                            <option value="<?= $setor['id'] ?>"><?= $setor['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
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
                                                    <input class="form-control input-obrigatorio mascara-dinheiro input-editar-valor" required name="valor" type="text" placeholder="Valor total da conta">
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
                    <button class="btn btn-success btn-form" type="button" onclick="cadastraMultiplasContasPagar('form-editar-pagar')">Salvar</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal Pagar conta -->
    <div class="modal fade" tabindex="-1" id="modalPagarConta">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Realizar pagamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12">
                                <div class="col-sm-12 col-xxl-12 py-3">
                                    <div class="mx-0 row">
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <label class="text-body-highlight fw-bold mb-2">Data
                                                    Pagamento</label>
                                                <input class="form-control datetimepicker input-data-pagamento cursor-pointer input-obrigatorio-unic" name="data_pagamento" type="text" placeholder="dd/mm/aaaa" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                                                <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                            </div>
                                        </div>

                                        <div class="campos-pagamento row">
                                            <div class="col-md-4 duplica-pagamento">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Conta
                                                        Bancária</label>
                                                    <select class="form-select select2 select-conta-bancaria-unic input-obrigatorio-unic">
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
                                            <div class="col-md-4 duplica-pagamento">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Forma
                                                        Pagamento</label>
                                                    <select class="form-select select2 select-forma-pagamento-unic input-obrigatorio-unic">
                                                        <option value="" selected disabled>Selecione</option>

                                                        <?php foreach ($formasTransacao as $formaTransacao) { ?>
                                                            <option value="<?= $formaTransacao['id'] ?>">
                                                                <?= $formaTransacao['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>
                                            </div>
                                            <div class="col-md-3 duplica-pagamento">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                    <input class="form-control input-valor-unic input-obrigatorio-unic input-valor mascara-dinheiro input-valor-pagamento" required name="valor" type="text" placeholder="Valor">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>
                                            </div>
                                            <div class="col-md-1 mt-5">
                                                <button title="Mais formas de pagamento" type="button" class="btn btn-phoenix-success duplicar-pagamento">+</button>
                                            </div>
                                            <div class="campos-duplicados">
                                                <!-- JS -->
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-4">
                                                <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                <textarea class="form-control obs-pagamento-inicio"></textarea>
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
                    <input type="hidden" class="id-dado-cliente">
                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button class="btn btn-primary btn-form" type="button" onclick="realizarPagamento()">Pagar
                        Conta</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal pagar várias contas de uma vez -->
    <div class="modal fade" tabindex="-1" id="modalPagarVariasContas">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Realizar pagamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="div-pagamento-inicial row ">

                                                <div class="col-md-12">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Data
                                                            Pagamento</label>
                                                        <input class="form-control datetimepicker input-obrigatorio-inicio input-data-pagamento data-pagamento-inicio cursor-pointer" name="data_pagamento" type="text" placeholder="dd/mm/aaaa" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Conta
                                                            Bancária</label>
                                                        <select class="form-select select2 input-obrigatorio-inicio select-conta-bancaria-inicio">
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

                                                <div class="col-6">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Forma
                                                            Pagamento</label>
                                                        <select class="campos form-select select2 select-forma-pagamento-inicio input-obrigatorio-inicio">
                                                            <option value="" selected disabled>Selecione</option>

                                                            <?php foreach ($formasTransacao as $formaTransacao) { ?>
                                                                <option value="<?= $formaTransacao['id'] ?>">
                                                                    <?= $formaTransacao['nome'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="campos-pagamento-inicio row d-none">
                                                <div class="col-lg-4 mb-4 duplica-pagamento-multiplo">
                                                    <label class="text-body-highlight fw-bold mb-2">Conta
                                                        Bancária</label>
                                                    <select class="campos form-select select-conta-bancaria conta-bancaria">
                                                        <option value="" selected disabled>Selecione</option>
                                                        <?php foreach ($contasBancarias as $contaBancaria) { ?>
                                                            <option value="<?= $contaBancaria['id_conta_bancaria'] ?>">
                                                                <?= $contaBancaria['apelido'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 duplica-pagamento-multiplo">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Forma
                                                            Pagamento</label>
                                                        <select class="campos form-select select-forma-pagamento forma-pagamento">
                                                            <option value="" selected disabled>Selecione</option>

                                                            <?php foreach ($formasTransacao as $formaTransacao) { ?>
                                                                <option value="<?= $formaTransacao['id'] ?>">
                                                                    <?= $formaTransacao['nome'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 duplica-pagamento-multiplo">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                        <input class="campos form-control input-valor mascara-dinheiro valor-pago" required name="valor" type="text" placeholder="Valor">
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-1 mt-5">
                                                    <button title="Mais formas de pagamento" type="button" class="btn btn-phoenix-success" onclick="duplicarFormaPagamentoModal(event)">+</button>
                                                </div>
                                            </div>

                                            <div class="campos-pagamentos-novos row">
                                                <!-- JS -->
                                            </div>
                                            <div class="col-lg-12 div-obs-pagamento">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                    <textarea class="form-control obs-pagamento"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="total-contas">
                        Total: <span class="total-em-aberto-modal fw-bold"></span>
                    </div>
                    <div>
                        <input type="hidden" class="id-conta-pagamento">
                        <input type="hidden" class="id-dado-financeiro">
                        <input type="hidden" class="id-dado-cliente">
                        <div class="spinner-border text-primary load-form d-none" role="status"></div>
                        <button class="btn btn-primary btn-form finalizar-varios-pagamentos btn-envia d-none" type="button" onclick="realizarVariosPagamentos()">Pagar Contas</button>
                        <button class="btn btn-primary proxima-etapa-pagamento" type="button">Próxima Etapa</button>
                        <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
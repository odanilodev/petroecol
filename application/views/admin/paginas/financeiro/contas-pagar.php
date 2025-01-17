<div class="content">
    <div>
        <div class="row g-4">
            <div class="col-12 col-xxl-12">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-success-300"
                                    data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100"
                                    data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-success "
                                    data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <span
                                        class="total-caixa-front"><?= number_format($saldoTotal['saldo'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Total Caixa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-success-300"
                                    data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100"
                                    data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-success "
                                    data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <span
                                        class="total-pago-front"><?= number_format($totalPago['valor'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Total Pago</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-warning-300"
                                    data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100"
                                    data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-warning"
                                    data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <span
                                        class="total-aberto-front"><?= number_format($emAberto['valor'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Despesas em Aberto</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex align-items-center">
                            <span class="fa-stack" style="min-height: 46px;min-width: 46px;">
                                <span class="fa-solid fa-square fa-stack-2x text-info-300"
                                    data-fa-transform="down-4 rotate--10 left-4"></span>
                                <span class="fa-solid fa-circle fa-stack-2x stack-circle text-info-100"
                                    data-fa-transform="up-4 right-3 grow-2"></span>
                                <span class="fa-stack-1x fa-solid fas fa-dollar-sign text-info"
                                    data-fa-transform="shrink-2 up-8 right-6"></span>
                            </span>
                            <div class="ms-3">
                                <h4 class="mb-0">R$ <span
                                        class="total-setor-front"><?= number_format($porSetor['saldo'], 2, ',', '.') ?></span>
                                </h4>
                                <p class="text-800 fs--1 mb-0">Saldo do Setor <?= $nomeSaldoSetor ?? "" ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="bg-200 mb-6 mt-3" />
            </div>

            <div class="col-12 col-xxl-12 mt-0">
                <form id="filtroForm" action="<?= base_url('finContasPagar/index/filtro') ?>" method="post">
                    <div class="col-12 mb-4">

                        <div class="row align-items-center g-4">
                            <h4 class="ms-3">Filtrar resultados</h4>

                            <div class="col-12 col-md-2">
                                <div class="ms-3">
                                    <input class="form-control datetimepicker" value="<?= $dataInicio ?? "" ?>" required
                                        name="data_inicio" id="data_inicio" type="text" placeholder="Data Início"
                                        data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}'
                                        style="cursor: pointer;" autocomplete="off" />
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="ms-3">
                                    <input class="form-control datetimepicker" value="<?= $dataFim ?? "" ?>" required
                                        name="data_fim" id="data_fim" type="text" placeholder="Data Fim"
                                        data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}'
                                        style="cursor: pointer;" autocomplete="off" />
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="ms-3">
                                    <select class="select-validation select-orientacao" required name="status" id="status">
                                        <option <?= $status == 'ambas' ? 'selected' : '' ?> disabled value=''>Status da Conta</option>
                                        <option <?= $status == '0' ? 'selected' : '' ?> value="0">Em aberto</option>
                                        <option <?= $status == '1' ? 'selected' : '' ?> value="1">Paga</option>
                                        <option <?= $status == 'ambas' ? 'selected' : '' ?> value="ambas">Ambos</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-2">
                                <div class="ms-3">
                                    <select class="select-validation" required name="setor" id="setor">
                                        <option selected disabled value=''>Setor da Conta</option>
                                        <option <?= $idSetor == 'todos' ? 'selected' : '' ?> value="todos">Todos</option>
                                        <?php foreach ($setoresEmpresa as $setor) { ?>
                                            <option <?= $idSetor == $setor['id'] ? 'selected' : '' ?>
                                                value="<?= $setor['id'] ?>"><?= $setor['nome'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="d-flex ms-3">
                                    <button type="submit"
                                        class="btn btn-phoenix-secondary bg-white hover-bg-100 me-2 <?= !$dataInicio ? 'w-100' : 'w-75'; ?>">Filtrar</button>

                                    <?php if ($dataInicio || !empty($cookie_filtro_contas_pagar['search'])) { ?>
                                        <button id="exportarBtn" class="btn btn-phoenix-secondary me-2">
                                            <span class="txt-exportar-btn">Exportar</span>
                                            <div class="spinner-border spinner-border-sm loader-btn-exportar d-none"
                                                role="status" style="width: 0.9rem; height: 0.9rem;"></div>
                                        </button>

                                        <a href="<?= base_url('finContasPagar/index/all'); ?>" class="btn btn-phoenix-danger"
                                            title="Limpar Filtro"><i class="fas fa-ban"></i></a>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                        <!-- <hr class="bg-200 mb-6 mt-4" /> -->
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
        <div id="members" data-list='{"valueNames":["td_vencimento", "td_valor", "td_valor_pago", "td_status_pgto", "td_data_pagamento", "td_empresa", "td_setor", "td_micro", "td_observacao"], "pagination":false}'>
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <div class="d-flex align-items-center">
                        <h3 class="me-3 teste-btn">Contas a pagar</h3>
                        <div class="btn-acoes-elementos-selecionados d-none">
                            <button class="btn btn-phoenix-info dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="contador-elementos-selecionados"></span>
                                Selecionados
                            </button>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <button class="dropdown-item btn-pagar-todos" data-bs-toggle="modal" data-bs-target="#modalPagarVariasContas">
                                        <span data-feather="dollar-sign"></span> Pagar todos
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item btn-excluir-contas" onclick="deletaContaPagar()">
                                        <span data-feather="trash"></span> Excluir tudo
                                    </button>
                                </li>
                            </ul>

                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="row g-2 gy-3">

                        <div class="col-auto flex-1">
                            <div class="search-box">
                                <form action="<?= base_url('finContasPagar/index/1') ?>" method="POST" class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input name="search" value="<?= $cookie_filtro_contas_pagar['search'] ?? null ?>" class="form-control search-input " type="search" placeholder="Buscar" aria-label="Search">
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>
                        </div>

                        <div class="col-auto">

                            <button class="btn btn-sm btn-phoenix-secondary bg-white hover-bg-100 action-btn novo-lancamento" type="button" data-bs-toggle="modal" data-bs-target="#modalTipoContasPagar">+ Lançamento</button>

                        </div>

                    </div>
                </div>
            </div>


            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table id="table-contas-pagar" class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs--1 ps-0 align-middle">
                                <div class="form-check mb-0 fs-0">
                                    <input class="form-check-input cursor-pointer check-todos-elementos" id="checkbox-bulk-reviews-select" type="checkbox" onclick="selecionarTodosElementos()" />
                                </div>
                            </th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_vencimento">Vencimento
                            </th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_valor">Valor</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_valor_pago">Valor Pago
                            </th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_status_pgto">Status</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_data_pagamento">Data do
                                Pagamento</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_empresa">Credor</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_setor">Setor</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_micro">Micro</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_observacao">Observação
                            </th>


                            <th class="sort text-end pe-0 align-middle text-center" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">

                        <?php foreach ($contasPagar as $contaPagar) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static tr-pagamento">

                                <td class="fs--1 align-middle ps-0">
                                    <div class="form-check mb-0 fs-0">
                                        <input
                                            class="form-check-input check-input cursor-pointer <?= !$contaPagar['status'] ? 'check-elemento check-' . $contaPagar['id'] : '' ?>"
                                            type="checkbox" value="<?= $contaPagar['id'] ?>"
                                            data-id-dado-financeiro="<?= $contaPagar['id_dado_financeiro'] ?>"
                                            data-id-funcionario="<?= $contaPagar['id_funcionario'] ?>"
                                            data-nome-empresa="<?= $contaPagar['RECEBIDO'] ? ucfirst($contaPagar['RECEBIDO']) : ($contaPagar['CLIENTE'] ? ucfirst($contaPagar['CLIENTE']) : strtoupper($contaPagar['NOME_FUNCIONARIO'])) ?>"
                                            data-id-dado-cliente="<?= $contaPagar['id_cliente'] ?>"
                                            data-valor="<?= $contaPagar['valor'] ?>"
                                            data-setor="<?= $contaPagar['SETOR'] ?>"
                                            data-id-setor-empresa="<?= $contaPagar['id_setor_empresa'] ?>" />

                                    </div>
                                </td>

                                <td class="align-middle product white-space-nowrap td_vencimento text-center">
                                    <h6 class="mb-0 text-900">
                                        <?= date('d/m/Y', strtotime($contaPagar['data_vencimento'])) ?>
                                    </h6>
                                </td>

                                <td class="align-middle rating white-space-nowrap fs--2 text-center">
                                    <h6 class="mb-0 text-900">R$
                                        <?= number_format($contaPagar['valor'], 2, ',', '.'); ?>
                                    </h6>
                                    <div class="td_valor">
                                        <input type="hidden" value="<?= $contaPagar['valor'] ?>">
                                    </div>
                                </td>

                                <td class="align-middle review text-center">
                                    <h6 class="mb-0 text-900 valor-pago-<?= $contaPagar['id'] ?>">R$
                                        <?= number_format($contaPagar['valor_pago'], 2, ',', '.'); ?>
                                    </h6>
                                    <div class="td_valor_pago">
                                        <input type="hidden" value="<?= $contaPagar['valor_pago'] ?>">
                                    </div>
                                </td>

                                <td class="align-middle text-start ps-3 status td_status_pgto text-center">

                                    <span
                                        class="badge badge-phoenix fs--2 <?= $contaPagar['status'] ? "badge-phoenix-success" : "badge-phoenix-danger" ?> tipo-status-conta-<?= $contaPagar['id'] ?>">
                                        <span data-setor="<?= $contaPagar['id_setor_empresa'] ?>"
                                            data-valor="<?= number_format($contaPagar['valor'], 2, ',', '.'); ?>"
                                            class="badge-label cursor-pointer realizar-pagamento status-pagamento-<?= $contaPagar['id'] ?>"
                                            data-id="<?= $contaPagar['id'] ?>"
                                            data-id-dado-financeiro="<?= $contaPagar['id_dado_financeiro'] ?>"
                                            data-id-funcionario="<?= $contaPagar['id_funcionario'] ?>"
                                            <?= !$contaPagar['status'] ? 'data-bs-toggle="modal" data-bs-target="#modalPagarConta"' : "" ?>
                                            data-id-dado-cliente="<?= $contaPagar['id_cliente'] ?>">
                                            <?= $contaPagar['status'] ? "Pago " . $contaPagar['numero_parcela'] ?? '' : "Em aberto " . $contaPagar['numero_parcela'] ?? '' ?>
                                        </span>
                                        <span class="ms-1 icone-status-conta-<?= $contaPagar['id'] ?>"
                                            data-feather="<?= $contaPagar['status'] ? "check" : "slash" ?>"
                                            style="height:12.8px;width:12.8px;"></span>
                                    </span>
                                </td>

                                <td class="align-middle customer white-space-nowrap td_data_pagamento text-center">
                                    <h6 class="mb-0 text-900">
                                        <span
                                            class="data-pagamento-<?= $contaPagar['id'] ?>"><?= isset($contaPagar['data_pagamento']) ? date('d/m/Y', strtotime($contaPagar['data_pagamento'])) : '-' ?></span>
                                    </h6>
                                </td>

                                <td class="align-middle review td_empresa text-center">
                                    <h6 class="mb-0 text-900">

                                        <?= $contaPagar['RECEBIDO'] ? ucfirst($contaPagar['RECEBIDO']) : ($contaPagar['CLIENTE'] ? ucfirst($contaPagar['CLIENTE']) : strtoupper($contaPagar['NOME_FUNCIONARIO'])); ?>

                                    </h6>
                                </td>

                                <td class="align-middle product white-space-nowrap td_setor text-center">
                                    <h6 class="mb-0 text-900">
                                        <?= $contaPagar['SETOR']; ?>
                                    </h6>
                                </td>

                                <td class="align-middle product white-space-nowrap td_micro text-center">
                                    <h6 class="mb-0 text-900">
                                        <?= $contaPagar['NOME_MICRO']; ?>
                                    </h6>
                                </td>

                                <td class="align-middle product white-space-nowrap td_observacao text-center">
                                    <h6 class="mb-0 text-900">
                                        <?= empty($contaPagar['observacao']) ? '-' : (strlen($contaPagar['observacao']) > 50 ? substr($contaPagar['observacao'], 0, 50) . '...' : $contaPagar['observacao']) ?>
                                    </h6>
                                </td>


                                <td class="align-middle white-space-nowrap text-end pe-0">

                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                                class="fas fa-ellipsis-h fs--2"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item" href="#"
                                                onclick="visualizarConta(<?= $contaPagar['id'] ?>)" data-bs-toggle="modal"
                                                data-bs-target="#modalVisualizarContasPagar">
                                                <span class="fas fa-eye"></span> Visualizar
                                            </a>

                                            <?php if (!$contaPagar['status']) { ?>
                                                <a class="dropdown-item editar-lancamento btn-editar-<?= $contaPagar['id'] ?>"
                                                    href="#!" data-bs-toggle="modal" data-id="<?= $contaPagar['id'] ?>"
                                                    data-valor="<?= number_format($contaPagar['valor'], 2, ',', '.'); ?>"
                                                    data-bs-target="#modalEditarContasPagar">
                                                    <span class="fas fa-pencil"></span> Editar
                                                </a>

                                                <a class="dropdown-item editar-lancamento btn-excluir-<?= $contaPagar['id'] ?>"
                                                    href="#" onclick="deletaContaPagar(<?= $contaPagar['id'] ?>)">
                                                    <span class="fas fa-trash"></span> Excluir
                                                </a>

                                                <div class="dropdown-divider btn-realizar-pagamento-<?= $contaPagar['id'] ?>">
                                                </div>
                                                <a class="dropdown-item realizar-pagamento btn-realizar-pagamento-<?= $contaPagar['id'] ?>"
                                                    data-valor="<?= number_format($contaPagar['valor'], 2, ',', '.'); ?>"
                                                    data-id="<?= $contaPagar['id'] ?>" href="#!" data-bs-toggle="modal"
                                                    data-bs-target="#modalPagarConta"
                                                    data-id-dado-cliente="<?= $contaPagar['id_cliente'] ?>"
                                                    data-id-funcionario="<?= $contaPagar['id_funcionario'] ?>"
                                                    data-id-dado-financeiro="<?= $contaPagar['id_dado_financeiro'] ?>">Realizar
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
            <!-- Links de Paginação usando classes Bootstrap -->
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation" style="display: flex; float: right">
                        <ul class="pagination-customizada mt-5">
                            <?= $this->pagination->create_links(); ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal visualizar contas a pagar -->
    <div class="modal fade" tabindex="-1" id="modalVisualizarContasPagar">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
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
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span
                                                                        class="text-info-600 dark__text-info-300 fas fa-id-card"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Setor</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">
                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break setor-empresa html-clean">
                                                                <!-- JS -->
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span
                                                                        class="text-info-600 dark__text-info-300 fas fa-tag"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Macro</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">
                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break nome-macro html-clean">
                                                                <!-- JS -->
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span
                                                                        class="text-info-600 dark__text-info-300 fas fa-tag"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Micro</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">
                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break nome-micro html-clean">
                                                                <!-- JS -->
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span
                                                                        class="text-info-600 dark__text-info-300 fas fa-id-card-alt"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0 label-empresa-funcionario">Empresa</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">
                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break nome-empresa html-clean">
                                                                <!-- JS -->
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300"
                                                                        data-feather="calendar"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Data de vencimento</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">
                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break data-vencimento html-clean">
                                                                <!-- JS -->
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300"
                                                                        data-feather="calendar"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Data de Emissão</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">
                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break data-emissao html-clean">
                                                                <!-- JS -->
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr class="div-data-pagamento d-none">
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span class="text-info-600 dark__text-info-300"
                                                                        data-feather="calendar"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Data de Pagamento</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">

                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break data-pagamento html-clean">
                                                                <!-- JS -->
                                                            </div>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span
                                                                        class="text-info-600 dark__text-info-300 fas fa-money-check-alt"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Valor</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">

                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break valor-conta html-clean">
                                                                <!-- JS -->
                                                            </div>

                                                        </td>
                                                    </tr>

                                                    <tr class="div-valor-pago d-none">
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span
                                                                        class="text-info-600 dark__text-info-300 fas fa-money-check-alt"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Valor Pago</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">

                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break valor-pago html-clean">
                                                                <!-- JS -->
                                                            </div>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="py-2 w-50">
                                                            <div class="d-inline-flex align-items-center">
                                                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                                                    style="width:24px; height:24px">
                                                                    <span
                                                                        class="text-info-600 dark__text-info-300 fas fa-message"
                                                                        style="width:16px; height:16px"></span>
                                                                </div>
                                                                <p class="fw-bold mb-0">Observação</p>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                                        <td class="py-2 w-50">

                                                            <div
                                                                class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break obs-conta html-clean">
                                                                <!-- JS -->
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
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
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
                                                    <label class="text-body-highlight fw-bold mb-2">Tipo de
                                                        conta</label>
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
                    <button class="btn btn-info btn-form btn-proxima-etapa-lancamento" type="button">Próxima
                        Etapa</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Lançamento Contas a Pagar Comum -->

    <div class="modal fade" tabindex="-1" id="modalLancamentoContasPagar">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
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
                                                    <label class="text-body-highlight fw-bold mb-2">Setor da
                                                        Empresa</label>
                                                    <select
                                                        class="form-select select2 select-setor-empresa input-obrigatorio dados-conta"
                                                        name="setor">
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
                                                    <select
                                                        class="form-select select2 select-macros input-obrigatorio dados-conta"
                                                        name="macros">
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
                                                    <select disabled
                                                        class="form-select select2 select-micros input-obrigatorio dados-conta"
                                                        name="micros">
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
                                                    <select
                                                        class="form-select select2 select-grupo-recebidos input-obrigatorio dados-conta"
                                                        name="grupo-recebido">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($grupos as $grupo) { ?>
                                                            <option value="<?= $grupo['id'] ?>"><?= $grupo['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                        <option value="clientes">Clientes</option>
                                                        <option value="funcionarios">Funcionários</option>

                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4 ">
                                                    <label class="text-body-highlight fw-bold mb-2">Recebido</label>
                                                    <select disabled
                                                        class="form-select select2 select-recebido input-obrigatorio dados-conta"
                                                        name="recebido">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($dadosFinanceiro as $dadoFinanceiro) { ?>
                                                            <option data-nome="<?= $dadoFinanceiro['nome'] ?>"
                                                                value="<?= $dadoFinanceiro['id'] ?>">
                                                                <?= $dadoFinanceiro['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    <input type="hidden" name="nome-recebido" class="nome-recebido">

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Parcelas</label>
                                                    <select class="form-select select2 select-parcela dados-conta"
                                                        name="parcelas">
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

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data Emissão</label>
                                                    <input
                                                        class="form-control datetimepicker cursor-pointer input-data-emissao dados-conta mascara-data"
                                                        required name="data_emissao" type="text"
                                                        placeholder="dd/mm/aaaa"
                                                        data-options='{"disableMobile":true, "allowInput":true, "dateFormat":"d/m/Y"}' />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>

                                            <div class="text-resumo-parcelas d-none">

                                                <p>Resumo de Parcelas</p>
                                                <hr>
                                            </div>

                                            <div class="col-12 mb-2 text-primeira-parcela d-none">1ª Parcela </div>

                                            <div class="col-lg-6 div-input-data-vencimento div-input-primeira-data">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data de Vencimento</label>

                                                    <input
                                                        class="form-control datetimepicker cursor-pointer input-data-vencimento input-obrigatorio dados-conta mascara-data input-data-primeira-parcela"
                                                        required name="data_vencimento" type="text"
                                                        placeholder="dd/mm/aaaa"
                                                        data-options='{"disableMobile":true, "allowInput":true, "dateFormat":"d/m/Y"}' />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>
                                            </div>



                                            <div class="col-lg-6 div-input-valor div-input-primeiro-valor">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                    <input
                                                        class="form-control input-obrigatorio mascara-dinheiro dados-conta input-valor-primeira-parcela"
                                                        required name="valor" type="text"
                                                        placeholder="Valor total da conta">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <hr>


                                            <div class="mt-3 div-resumo-parcelas d-none">

                                                <div class="resumo-parcelas row">
                                                    <!-- JS -->
                                                </div>
                                            </div>

                                            <div class="col-lg-12 div-observacao">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                    <textarea class="form-control dados-conta obs-pagamento"
                                                        name="observacao"></textarea>
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
                    <button class="btn btn-success btn-form" type="button"
                        onclick="cadastraContasPagar('form-entrada-pagar')">Salvar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Contas a Pagar Recorrentes -->

    <div class="modal fade" tabindex="-1" id="modalSelecionarContasPagarRecorrentes">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
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
                                                                    <input
                                                                        class="form-check-input check-all-modal-element cursor-pointer"
                                                                        id="checkbox-bulk-reviews-select"
                                                                        type="checkbox" />
                                                                </div>
                                                            </th>
                                                            <th class="sort align-middle text-center" scope="col"
                                                                data-sort="td_setor">Setor</th>
                                                            <th class="sort align-middle text-center" scope="col"
                                                                data-sort="td_valor">Credor</th>
                                                            <th class="sort align-middle text-center" scope="col"
                                                                data-sort="td_valor">Micro</th>
                                                            <th class="sort text-start ps-5 align-middle text-center"
                                                                scope="col" data-sort="td_status_pgto">Dia do Pagamento
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list" id="table-latest-review-body">

                                                        <?php foreach ($contasRecorrentes as $contaRecorrente) { ?>
                                                            <tr
                                                                class="hover-actions-trigger btn-reveal-trigger position-static tr-pagamento">

                                                                <td class="fs--1 align-middle ps-0">
                                                                    <div class="form-check mb-0 fs-0">
                                                                        <input
                                                                            class="form-check-input check-element-modal check-element cursor-pointer"
                                                                            type="checkbox"
                                                                            value="<?= $contaRecorrente['id'] ?>" />
                                                                    </div>
                                                                </td>

                                                                <td
                                                                    class="align-middle product white-space-nowrap td_vencimento text-center">
                                                                    <h6 class="mb-0 text-900">

                                                                        <?= ucfirst($contaRecorrente['SETOR']); ?>

                                                                    </h6>
                                                                </td>

                                                                <td
                                                                    class="align-middle product white-space-nowrap td_vencimento text-center">
                                                                    <h6 class="mb-0 text-900">

                                                                        <?= $contaRecorrente['RECEBIDO'] ? ucfirst($contaRecorrente['RECEBIDO']) : ucfirst($contaRecorrente['CLIENTE']); ?>

                                                                    </h6>
                                                                </td>

                                                                <td
                                                                    class="align-middle product white-space-nowrap td_vencimento text-center">
                                                                    <h6 class="mb-0 text-900">
                                                                        <?= $contaRecorrente['MICRO'] ?>
                                                                    </h6>
                                                                </td>

                                                                <td
                                                                    class="align-middle rating white-space-nowrap fs--2 td_valor text-center">
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
                    <button class="btn btn-info btn-form btn-proxima-etapa-recorrente" type="button">Próxima
                        etapa</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalLancamentoContasPagarRecorrentes">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
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
                                        <div
                                            class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0 lista-contas-recorrentes form-entrada-pagar-recorrentes">
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
                    <button class="btn btn-success btn-form" type="button"
                        onclick="cadastraMultiplasContasPagar('form-entrada-pagar-recorrentes')">Salvar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Contas a Pagar -->

    <div class="modal fade" tabindex="-1" id="modalEditarContasPagar">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
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
                                                    <label class="text-body-highlight fw-bold mb-2">Setor da
                                                        Empresa</label>
                                                    <select
                                                        class="form-select select2 select-setor-empresa select-setor-empresa-editar input-obrigatorio"
                                                        name="setor">
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
                                                    <select
                                                        class="form-select select2 select-macros-editar input-obrigatorio dados-conta"
                                                        name="macros">
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
                                                    <select disabled
                                                        class="form-select select2 select-micros input-obrigatorio dados-conta"
                                                        name="micros">
                                                        <option selected disabled value="">Selecione</option>
                                                        <!-- JS -->
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>


                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Grupo de
                                                        Credores</label>
                                                    <select class="form-select select-grupo-recebidos input-obrigatorio dados-conta"
                                                        name="grupo-recebido">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($grupos as $grupo) { ?>
                                                            <option value="<?= $grupo['id'] ?>"><?= $grupo['nome'] ?>
                                                            </option>
                                                        <?php } ?>
                                                        <option value="clientes">Clientes</option>
                                                        <option value="funcionarios">Funcionários</option>

                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-4 ">
                                                    <label class="text-body-highlight fw-bold mb-2">Recebido</label>
                                                    <select disabled
                                                        class="form-select select2 select-recebido input-obrigatorio dados-conta"
                                                        name="recebido">
                                                        <option selected disabled value="">Selecione</option>
                                                        <?php foreach ($dadosFinanceiro as $dadoFinanceiro) { ?>
                                                            <option data-nome="<?= $dadoFinanceiro['nome'] ?>"
                                                                value="<?= $dadoFinanceiro['id'] ?>">
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
                                                    <label class="text-body-highlight fw-bold mb-2">Data
                                                        Vencimento</label>
                                                    <input
                                                        class="form-control datetimepicker cursor-pointer input-data-vencimento input-obrigatorio mascara-data"
                                                        required name="data_vencimento" type="text"
                                                        placeholder="dd/mm/aaaa"
                                                        data-options='{"disableMobile":true,"allowInput":true,"dateFormat":"d/m/Y"}' />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>
                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Data Emissão</label>
                                                    <input
                                                        class="form-control datetimepicker cursor-pointer input-data-emissao mascara-data"
                                                        required name="data_emissao" type="text"
                                                        placeholder="dd/mm/aaaa"
                                                        data-options='{"disableMobile":true,"allowInput":true,"dateFormat":"d/m/Y"}' />
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                    <input
                                                        class="form-control input-obrigatorio mascara-dinheiro input-editar-valor"
                                                        required name="valor" type="text"
                                                        placeholder="Valor total da conta">
                                                </div>

                                            </div>

                                            <div class="col-lg-12 div-observacao">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                    <textarea class="form-control input-observacao"
                                                        name="observacao"></textarea>
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
                    <input type="hidden" class="input-id-setor">
                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button class="btn btn-success btn-form cadastra-conta-pagar" type="button"
                        onclick="cadastraContasPagar('form-editar-pagar')">Salvar</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal Pagar conta -->
    <div class="modal fade" tabindex="-1" id="modalPagarConta">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
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
                                                <input
                                                    class="form-control datetimepicker input-data-pagamento cursor-pointer input-obrigatorio-unic mascara-data"
                                                    name="data_pagamento" type="text" placeholder="dd/mm/aaaa"
                                                    data-options='{"disableMobile":true,"allowInput":true,"dateFormat":"d/m/Y"}' />
                                                <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                            </div>
                                        </div>

                                        <div class="campos-pagamento row">
                                            <div class="col-md-4 duplica-pagamento">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Conta
                                                        Bancária</label>
                                                    <select
                                                        class="form-select select2 select-conta-bancaria-unic input-obrigatorio-unic">
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
                                                    <select
                                                        class="form-select select2 select-forma-pagamento-unic input-obrigatorio-unic">
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
                                                    <input
                                                        class="form-control input-valor-unic input-obrigatorio-unic input-valor mascara-dinheiro input-valor-pagamento"
                                                        required name="valor" type="text" placeholder="Valor">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>
                                            </div>
                                            <div class="col-md-1 mt-5">
                                                <button title="Mais formas de pagamento" type="button"
                                                    class="btn btn-phoenix-success duplicar-pagamento">+</button>
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
                    <input type="hidden" class="id-funcionario">
                    <input type="hidden" class="id-dado-cliente">
                    <input type="hidden" class="input-id-setor">
                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                    <button class="btn btn-primary btn-form" type="button" onclick="realizarPagamento()">Pagar Conta</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal pagar várias contas de uma vez -->
    <div class="modal fade" tabindex="-1" id="modalPagarVariasContas">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
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
                                                        <input
                                                            class="form-control datetimepicker input-obrigatorio-inicio input-data-pagamento data-pagamento-inicio cursor-pointer mascara-data"
                                                            name="data_pagamento" type="text" placeholder="dd/mm/aaaa"
                                                            data-options='{"disableMobile":true,"allowInput":true,"dateFormat":"d/m/Y"}' />
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Conta
                                                            Bancária</label>
                                                        <select
                                                            class="form-select select2 input-obrigatorio-inicio select-conta-bancaria-inicio">
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
                                                        <select
                                                            class="campos form-select select2 select-forma-pagamento-inicio input-obrigatorio-inicio">
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
                                                    <select
                                                        class="campos form-select select-conta-bancaria conta-bancaria">
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
                                                        <select
                                                            class="campos form-select select-forma-pagamento forma-pagamento">
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
                                                        <input
                                                            class="campos form-control input-valor mascara-dinheiro valor-pago"
                                                            required name="valor" type="text" placeholder="Valor">
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-1 mt-5">
                                                    <button title="Mais formas de pagamento" type="button"
                                                        class="btn btn-phoenix-success"
                                                        onclick="duplicarFormaPagamentoModal(event)">+</button>
                                                </div>
                                            </div>

                                            <div class="campos-pagamentos-novos row">
                                                <!-- JS -->
                                            </div>
                                            <div class="col-lg-12 div-obs-pagamento">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Observação</label>
                                                    <textarea class="form-control obs-pagamento-varios"></textarea>
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
                        <input type="hidden" class="id-funcionario">
                        <input type="hidden" class="id-dado-cliente">
                        <input type="hidden" class="id-setor-empresa">
                        <div class="spinner-border text-primary load-form d-none" role="status"></div>
                        <button class="btn btn-primary btn-form finalizar-varios-pagamentos btn-envia d-none"
                            type="button" onclick="realizarVariosPagamentos()">Pagar Contas</button>
                        <button class="btn btn-primary proxima-etapa-pagamento" type="button">Próxima Etapa</button>
                        <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
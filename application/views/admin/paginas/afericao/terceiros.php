<div class="content">
    <div id="members">

        <div class="px-4 px-lg-6 mb-9 bg-white border-y pt-7 border-300 mt-2 position-relative top-1">
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <div class="d-flex align-items-center">
                        <h3 class="me-3 teste-btn">Aferição de Terceiros</h3>
                    </div>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="row g-2 gy-3">

                        <div class="col-auto flex-1">
                            <div class="search-box">
                                <form action="<?= base_url('afericao/terceiros/') ?>" method="POST" class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input name="search" value="<?= $cookie_filtro_afericao_terceiros['search'] ?? null ?>" class="form-control search-input " type="search" placeholder="Buscar" aria-label="Search">
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>
                        </div>

                        <div class="col-auto">

                            <button class="btn btn-sm btn-phoenix-secondary bg-white hover-bg-100 action-btn novo-lancamento" type="button" data-bs-toggle="modal" data-bs-target="#modalAfericaoTerceiros" onclick="carregaSelect2('select2', 'modalAfericaoTerceiros')">+ Lançamento</button>

                        </div>

                    </div>
                </div>
            </div>
            <div class="table-responsive scrollbar ms-n1 ps-1">
                <table class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr>
                            <th class="sort align-middle text-center" scope="col">Data da aferição</th>
                            <th class="sort align-middle text-center" scope="col">Fornecedor</th>
                            <th class="sort align-middle text-center" scope="col">Resíduo</th>
                            <th class="sort align-middle text-center" scope="col">Quantidade Paga</th>
                            <th class="sort align-middle text-center" scope="col">Quantidade Aferida</th>
                            <th class="sort align-middle text-center" scope="col">Gasto</th>
                            <th class="sort align-middle text-center" scope="col">Setor</th>
                            <th class="sort align-middle text-center" scope="col">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="list" id="members-table-body">

                        <?php foreach ($afericoes as $afericao) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                <td class="align-middle text-center white-space-nowrap">
                                    <?= date('d/m/Y', strtotime($afericao['data_afericao'])) ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    <?= $afericao['FORNECEDOR'] ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    <?= $afericao['RESIDUO'] ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    <?= $afericao['quantidade_paga'] . ' ' . strtoupper($afericao['UNIDADE_MEDIDA_PADRAO']) ?> 
                                </td>

                                <td class="align-middle text-center white-space-nowrap <?= $afericao['quantidade_paga'] > $afericao['quantidade_aferida'] ? 'text-danger' : 'text-success' ?>">
                                    <?= $afericao['quantidade_aferida'] . ' ' . strtoupper($afericao['UNIDADE_MEDIDA_PADRAO'])?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    R$ <?= number_format($afericao['gasto'], 2, ',', '.'); ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    <?= $afericao['SETOR'] ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs--2"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">

                                            <a class="dropdown-item" href="#">
                                                <span class="fas fa-eye"></span> Editar
                                            </a>

                                        </div>
                                    </div>
                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation" style="display: flex; float: right">
                        <ul class="pagination mt-5">
                            <?= $this->pagination->create_links(); ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Aferição de terceiros -->
    <div class="modal fade" tabindex="-1" id="modalAfericaoTerceiros">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Prestação de Contas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-dados-financeiros">

                    <div id="with-validation-code">
                        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
                            <div class="card-header bg-100 pt-3 pb-2 border-bottom-0">
                                <ul class="nav justify-content-between nav-wizard">

                                    <li class="nav-item">
                                        <a class="nav-link active fw-semi-bold btn-etapas btn-proximo" href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1">
                                            <div class="text-center d-inline-block">
                                                <span class="nav-item-circle-parent">
                                                    <span class="nav-item-circle">
                                                        <span class="fas fa-boxes"></span>
                                                    </span>
                                                </span>
                                                <span class="d-none d-md-block mt-1 fs--1">Coleta</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link fw-semi-bold btn-etapas btn-proximo" href="#bootstrap-wizard-tab2" data-bs-toggle="tab" data-wizard-step="2">
                                            <div class="text-center d-inline-block">
                                                <span class="nav-item-circle-parent">
                                                    <span class="nav-item-circle">
                                                        <span class="uil-clipboard-notes"></span>
                                                    </span>
                                                </span>
                                                <span class="d-none d-md-block mt-1 fs--1">Aferição</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link fw-semi-bold btn-etapas btn-proximo etapa-pagamento" href="#bootstrap-wizard-tab3" data-bs-toggle="tab" data-wizard-step="3">
                                            <div class="text-center d-inline-block">
                                                <span class="nav-item-circle-parent">
                                                    <span class="nav-item-circle">
                                                        <span class="fas fa-coins"></span>
                                                    </span>
                                                </span>
                                                <span class="d-none d-md-block mt-1 fs--1">Pagamento</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body pt-4 pb-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1">

                                        <form id="form-residuo" class="needs-validation" novalidate="novalidate" data-wizard-form="1">

                                            <div class="row">

                                                <div class="col-lg-6">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Setor da Empresa</label>
                                                        <select required class="form-select select2 select-macros-prestacao input-obrigatorio-terceiros" name="setor">
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

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Fornecedor</label>
                                                        <select required class="form-select select2 input-obrigatorio-terceiros" name="fornecedor">
                                                            <option selected disabled value="">Selecione</option>
                                                            <?php
                                                            foreach ($dadosFinanceiro as $dadoFinanceiro) { ?>
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
                                                        <label class="text-body-highlight fw-bold mb-2">Resíduo</label>
                                                        <select required class="form-select select2 select-residuo input-obrigatorio-terceiros" name="residuo">
                                                            <option selected disabled value="">Selecione</option>
                                                            <?php
                                                            foreach ($residuos as $residuo) { ?>
                                                                <option value="<?= $residuo['id'] ?>">
                                                                    <?= $residuo['nome'] ?>
                                                                </option>
                                                            <?php } ?>

                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-4">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Quantidade</label>
                                                        <input required class="form-control input-obrigatorio-terceiros" name="quantidade" type="text" placeholder="Quantidade Paga">
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Unidade de Medida</label>
                                                        <select required class="form-select select2 input-obrigatorio-terceiros" name="unidade_medida">
                                                            <option selected disabled value="">Selecione</option>
                                                            <?php foreach ($unidadesMedidas as $unidadeMedida) { ?>
                                                                <option value="<?= $unidadeMedida['id'] ?>"><?= $unidadeMedida['nome'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2">
                                        <form id="form-afericao" class="needs-validation" novalidate="novalidate" data-wizard-form="2">

                                            <div class="row">

                                                <div class="col-lg-6">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Quantidade Aferida</label>
                                                        <input required class="form-control input-obrigatorio-terceiros" name="quantidade_aferida" type="number" placeholder="Quantidade Aferida">
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Unidade de Medida</label>
                                                        <select required class="form-select select2 input-obrigatorio-terceiros" name="unidade_medida_aferida">
                                                            <option selected disabled value="">Selecione</option>
                                                            <?php foreach ($unidadesMedidas as $unidadeMedida) { ?>
                                                                <option value="<?= $unidadeMedida['id'] ?>"><?= $unidadeMedida['nome'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>

                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3">
                                        <form class="mb-2 needs-validation" novalidate="novalidate" id="form-pagamento" data-wizard-form="3">

                                            <div class="row gx-3 gy-2">

                                                <div class="col-lg-6">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Grupos Macros</label>
                                                        <select required class="form-select select2 select-macros input-obrigatorio-terceiros" name="macro">
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
                                                        <label class="text-body-highlight fw-bold mb-2 ">Grupos Micros</label>
                                                        <select required disabled class="form-select select2 select-micros inpust-obrigatorio-terceiros" name="micro">
                                                            <option selected disabled value="">Selecione</option>
                                                            <!-- JS -->
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-6 div-conta-bancaria">
                                                    <div class="mb-4 ">
                                                        <label class="text-body-highlight fw-bold mb-2 ">Conta Bancária</label>
                                                        <select required class="form-select select2 input-obrigatorio-terceiros select-conta-bancaria" name="conta_bancaria">
                                                            <option selected disabled value="">Selecione</option>
                                                            <?php foreach ($contasBancarias as $contaBancaria) { ?>
                                                                <option value="<?= $contaBancaria['ID_CONTA_BANCARIA'] ?>"><?= $contaBancaria['apelido'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 div-forma-pagamento">
                                                    <div class="mb-4 ">
                                                        <label class="text-body-highlight fw-bold mb-2 ">Forma de Pagamento</label>
                                                        <select required class="form-select select2 input-obrigatorio-terceiros select-forma-pagamento" name="forma_pagamento">
                                                            <option selected disabled value="">Selecione</option>
                                                            <?php foreach ($formasTransacoes as $formasTransacao) { ?>
                                                                <option value="<?= $formasTransacao['id'] ?>"><?= $formasTransacao['nome'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2 label-valor">Valor Pago</label>
                                                        <input required class="form-control mascara-dinheiro input-obrigatorio-terceiros" name="valor" type="text" placeholder="Valor Pago">
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                    </div>

                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2 label-data">Data da Aferição</label>
                                                        <input name="data_afericao" required autocomplete="off" class="form-control datetimepicker input-obrigatorio-terceiros" type="text" placeholder="Escolha uma Data" data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="mb-4">
                                                        <input id="check-agendar-pagamento" name="agendar_pagamento" class="form-check-input" type="checkbox" style="cursor: pointer;" />
                                                        <label class="text-body-highlight mb-2 cursor-pointer" for="check-agendar-pagamento">Agendar pagamento</label>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>

                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane d-none" role="tabpanel" aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4">
                                        <div class="row flex-center pb-8 pt-4 gx-3 gy-4">
                                            <div data-bds-toggle="tab" data-wizard-step="1">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer border-top-0" data-wizard-footer="data-wizard-footer">
                                <div class="d-flex pager wizard list-inline mb-0 div-btn-modal">
                                    <button class="d-none btn btn-link ps-0 bnt-voltar" type="button" data-wizard-prev-btn="data-wizard-prev-btn">
                                        <span class="fas fa-chevron-left me-1" data-fa-transform="shrink-3"></span>Voltar
                                    </button>
                                    <div class="flex-1 text-end">
                                        <button class="btn btn-primary px-6 px-sm-6 btn-proximo" type="submit" data-wizard-next-btn="data-wizard-next-btn">
                                            Próximo <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span>
                                        </button>
                                    </div>
                                </div>

                                <div class="spinner-border text-primary load-form d-none" role="status"></div>

                            </div>
                        </div>
                    </div>


                </div>



            </div>
        </div>
    </div>
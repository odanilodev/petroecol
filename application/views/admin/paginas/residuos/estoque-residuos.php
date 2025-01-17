<div class="content">
    <div id="members">

        <div class="row justify-content-between">
            <div class="col-auto">
                <a href="#" class="btn btn-phoenix-primary mb-3 btn-nova-venda" data-bs-toggle="modal" data-bs-target="#modalNovaVenda">
                    <span class="fas fa-dollar-sign"></span>
                    Nova Venda
                </a>
            </div>

            <div class="col-auto">
                <a href="#" class="btn btn-phoenix-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalConfiguracoesExibicoes">
                    <span class="uil-setting"></span>
                    Configurações de Exibições
                </a>
            </div>
        </div>


        <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">

            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <h3>Estoque de Resíduos</h3>
                </div>
                <div class="col-12 col-md-auto">
                    <div class="row g-2 gy-3">

                        <div class="col-auto flex-1">
                            <div class="search-box">
                                <form action="<?= base_url('estoqueResiduos') ?>" method="POST" class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input name="residuos" value="<?= $cookie_filtro_estoque_residuos['residuos'] ?? null ?>" class="form-control search-input search" type="search" placeholder="Buscar Resíduos" aria-label="Search">
                                    <span class="fas fa-search search-box-icon"></span>
                                </form>
                            </div>
                        </div>

                        <div class="col-auto">

                            <button class="btn btn-sm btn-phoenix-secondary bg-white hover-bg-100 action-btn btn-novo-lancamento"
                                type="button" data-bs-toggle="modal" data-bs-target="#modalLancamentoEstoque" onclick="carregaSelect2('select2', 'modalLancamentoEstoque')">+ Lançamento</button>

                        </div>

                    </div>
                </div>
            </div>
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table id="table-fluxo" class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr class="text-center">
                            <th class="sort align-middle text-center" scope="col" data-sort="td_recebido">Resíduo</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_transacao">Quantidade</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_setor">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">

                        <?php foreach ($estoqueResiduos as $estoqueResiduo) { ?>

                            <tr class="hover-actions-trigger btn-reveal-trigger position-static text-center">

                                <td class="align-middle text-center data white-space-nowrap td_data">
                                    <h6 class="mb-0 text-900 text-center">
                                        <?= $estoqueResiduo['residuo']; ?>
                                    </h6>
                                </td>

                                <td class="align-middle text-center td_recebido">
                                    <h6 class="mb-0 text-900">

                                        <!-- formata com 3 casas decimais caso não seja numero inteiro -->
                                        <?= floor($estoqueResiduo['quantidade']) == $estoqueResiduo['quantidade']
                                            ? $estoqueResiduo['quantidade'] . ' ' . strtoupper($estoqueResiduo['unidade_medida'])
                                            : number_format($estoqueResiduo['quantidade'], 3, ',', '') . ' ' . strtoupper($estoqueResiduo['unidade_medida']);
                                        ?>

                                    </h6>
                                </td>

                                <td class="align-middle white-space-nowrap text-center pe-0">

                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button
                                            class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
                                            type="button" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                            <span class="fas fa-ellipsis-h fs--2"></span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-start py-2">
                                            <a class="dropdown-item" href="<?= base_url('estoqueResiduos/detalhes/' . $estoqueResiduo['idResiduo']) ?>">
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

            <!-- Links de Paginação usando classes Bootstrap -->
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Page navigation" style="display: flex; float: right">
                        <ul class="pagination mt-5">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal novo Lançamento no Estoque -->
    <div class="modal fade" tabindex="-1" id="modalLancamentoEstoque">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
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
                                                    <label class="text-body-highlight fw-bold mb-2">Setor da empresa</label>
                                                    <select class="form-select input-obrigatorio select-setor-empresa select2" name="setor">
                                                        <option selected disabled>Selecione</option>
                                                        <?php foreach ($setoresEmpresa as $setorEmpresa) { ?>
                                                            <option value="<?= $setorEmpresa['id'] ?>"><?= $setorEmpresa['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Tipo</label>
                                                    <select class="form-select input-obrigatorio select-tipo-lancamento">
                                                        <option selected disabled>Selecione</option>
                                                        <option value="1">Entrada</option>
                                                        <option value="0">Saída</option>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Resíduo</label>
                                                    <select class="form-select input-obrigatorio select-residuo select2" name="residuo">
                                                        <option selected disabled>Selecione</option>
                                                        <?php foreach ($residuos as $residuo) { ?>
                                                            <option value="<?= $residuo['id'] ?>"><?= $residuo['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                </div>

                                            </div>



                                            <div class="col-lg-4">
                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Quantidade</label>
                                                    <input class="form-control input-quantidade input-obrigatorio" required name="valor" type="number" placeholder="Quantidade">
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

                    <div class="spinner-border text-primary load-form-modal d-none" role="status"></div>
                    <button class="btn btn-success btn-form-modal" type="button" onclick="inserirLancamentoEstoqueResiduos()">Salvar</button>
                    <button class="btn btn-secondary btn-form-modal" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal nova venda -->
    <div class="modal fade" tabindex="-1" id="modalNovaVenda">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nova venda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-dados-financeiros">

                    <div id="with-validation-code">
                        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
                            <div class="card-header bg-100 pt-3 pb-2 border-bottom-0">
                                <ul class="nav justify-content-between nav-wizard">

                                    <li class="nav-item">
                                        <a class="nav-link active fw-semi-bold btn-etapas" href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1">
                                            <div class="text-center d-inline-block">
                                                <span class="nav-item-circle-parent">
                                                    <span class="nav-item-circle">
                                                        <span class="fas fa-recycle"></span>
                                                    </span>
                                                </span>
                                                <span class="d-none d-md-block mt-1 fs--1">Resíduo</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link fw-semi-bold btn-etapas etapa-venda btn-proximo" href="#bootstrap-wizard-tab2" data-bs-toggle="tab" data-wizard-step="2">
                                            <div class="text-center d-inline-block">
                                                <span class="nav-item-circle-parent">
                                                    <span class="nav-item-circle">
                                                        <span class="uil-clipboard-notes"></span>
                                                    </span>
                                                </span>
                                                <span class="d-none d-md-block mt-1 fs--1">Venda</span>
                                            </div>
                                        </a>
                                    </li>


                                </ul>
                            </div>

                            <div class="card-body pt-4 pb-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1">

                                        <form id="form-venda-residuo" class="needs-validation" novalidate="novalidsate" data-wizard-form="1">

                                            <div class="row">

                                                <div class="col-lg-12">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Setor da Empresa</label>
                                                        <select required class="form-select input-obrigatorio-venda select2 select-setor-empresa-venda">
                                                            <option selected disabled>Selecione</option>
                                                            <?php foreach ($setoresEmpresa as $setorEmpresa) { ?>
                                                                <option value="<?= $setorEmpresa['id'] ?>"><?= $setorEmpresa['nome'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Resíduo</label>
                                                        <select required class="form-select input-obrigatorio-venda select-residuo-venda select2" name="residuo">
                                                            <option selected disabled>Selecione</option>

                                                            <?php foreach ($residuos as $residuo) { ?>
                                                                <option value="<?= $residuo['id'] ?>"><?= $residuo['nome'] ?></option>
                                                            <?php } ?>

                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                    </div>

                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Unidade de Medida</label>
                                                        <select required class="form-select input-obrigatorio-venda select-unidade-medida select2" name="residuo">
                                                            <option selected disabled>Selecione</option>
                                                            <?php foreach ($unidades_medidas as $unidade_medida) { ?>
                                                                <option value="<?= $unidade_medida['id'] ?>"><?= $unidade_medida['nome'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                    </div>

                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Valor por <span class="nome-unidade-medida">Unidade</span></label>
                                                        <input class="form-control input-valor-unidade-medida input-obrigatorio-venda mascara-dinheiro" required name="valor" type="text" placeholder="Valor por unidade">
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Quantidade</label>
                                                        <input class="form-control input-quantidade-venda input-obrigatorio-venda" required name="valor" type="number" placeholder="Quantidade">
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                    </div>
                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="mb-3">
                                                        <input id="check-agendar-recebimento" name="agendar_recebimento" class="form-check-input cursor-pointer" type="checkbox" />
                                                        <label class="text-body-highlight mb-2 cursor-pointer" for="check-agendar-recebimento">Agendar Venda</label>
                                                    </div>

                                                </div>


                                            </div>
                                        </form>
                                    </div>


                                    <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2">
                                        <form class="mb-2 needs-validation" novalidate="novalidate" id="form-venda-pagamento" data-wizard-form="2">

                                            <div class="row gx-3 gy-2">

                                                <div class="col-lg-12 div-select-cliente">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Cliente</label>
                                                        <select required class="form-select input-obrigatorio-venda select2 select-cliente">
                                                            <option selected disabled>Selecione</option>
                                                            <?php foreach ($clientes_finais as $cliente_final) { ?>
                                                                <option value="<?= $cliente_final['id'] ?>"><?= $cliente_final['nome'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-6 div-select-parcelas d-none">
                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Parcelas</label>
                                                        <select class="form-select select2 select-parcela dados-conta" name="parcelas">
                                                            <option selected value="1">1x</option>
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
                                                        <label class="text-body-highlight fw-bold mb-2">Grupos Macros</label>
                                                        <select required class="form-select select2 select-macros input-obrigatorio-venda" name="macro">
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
                                                        <select required disabled class="form-select select2 select-micros input-obrigatorio-venda" name="micro">
                                                            <option selected disabled value="">Selecione</option>
                                                            <!-- JS -->
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-6 div-contas-receber">
                                                    <div class="mb-4 ">
                                                        <label class="text-body-highlight fw-bold mb-2 ">Conta Bancária</label>
                                                        <select required class="form-select select2 input-obrigatorio-venda select-conta-bancaria" name="conta_bancaria">
                                                            <option selected disabled value="">Selecione</option>
                                                            <?php foreach ($contasBancarias as $contaBancaria) { ?>
                                                                <option value="<?= $contaBancaria['ID_CONTA_BANCARIA'] ?>"><?= $contaBancaria['apelido'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 div-contas-receber">
                                                    <div class="mb-4 ">
                                                        <label class="text-body-highlight fw-bold mb-2 ">Forma de Recebimento</label>
                                                        <select required class="form-select select2 input-obrigatorio-venda select-forma-recebimento" name="forma_pagamento">
                                                            <option selected disabled value="">Selecione</option>
                                                            <?php foreach ($formasTransacoes as $formasTransacao) { ?>
                                                                <option value="<?= $formasTransacao['id'] ?>"><?= $formasTransacao['nome'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                    </div>
                                                </div>

                                                <div class="text-resumo-parcelas d-none">

                                                    <p>Resumo de Parcelas</p>
                                                    <hr>
                                                </div>

                                                <div class="col-12 mb-2 text-primeira-parcela d-none">1ª Parcela </div>

                                                <div class="col-lg-4 div-input-data-vencimento div-input-primeira-data">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2 label-data">Data da Venda</label>

                                                        <input
                                                            class="form-control datetimepicker cursor-pointer input-data-destinacao input-data-vencimento input-obrigatorio-venda dados-conta mascara-data input-data-primeira-parcela"
                                                            required name="data_vencimento" type="text"
                                                            placeholder="dd/mm/aaaa"
                                                            data-options='{"disableMobile":true, "allowInput":true, "dateFormat":"d/m/Y"}' />
                                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                                    </div>
                                                </div>

                                                <div class="col-lg-4 div-input-desconto">
                                                    <label class="text-body-highlight fw-bold mb-2">Desconto</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control input-desconto-venda" placeholder="Ex.: 15">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 div-input-valor div-input-primeiro-valor">

                                                    <div class="mb-4">
                                                        <label class="text-body-highlight fw-bold mb-2">Valor</label>
                                                        <input
                                                            class="form-control input-obrigatorio-venda mascara-dinheiro dados-conta input-valor-primeira-parcela input-valor-total input-valor-venda"
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


    <!-- Modal Configurações de exibições -->
    <div class="modal fade" tabindex="-1" id="modalConfiguracoesExibicoes">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form action="<?= site_url('estoqueResiduos') ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Configurações de exibições</h5>
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
                                                        <label class="text-body-highlight fw-bold mb-2">Unidade de Medida</label>
                                                        <select class="form-select select-exibicao-unidade-medida" name="converter_unidade_medida">
                                                            <option selected disabled>Selecione</option>

                                                            <?php foreach ($unidades_medidas as $unidade_medida) { ?>
                                                                <option <?= $converter_unidade_medida == $unidade_medida['id'] ? 'selected' : '' ?> value="<?= $unidade_medida['id'] ?>">
                                                                    <?= $unidade_medida['nome'] ?>
                                                                </option>
                                                            <?php } ?>
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
                        <button class="btn btn-success btn-form" type="submit">Salvar</button>
                        <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
<div class="content">

    <div class="mx-n4 px-4 px-lg-6 bg-white pt-7 border-y border-300 mb-5">
        <div id="members" data-list='{"valueNames":["td_credor","td_micro"],"pagination":true}'>
            <div class="row align-items-end justify-content-between pb-5 g-3">
                <div class="col-auto">
                    <h3>Contas recorrentes

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

                            <button class="btn btn-sm btn-phoenix-secondary bg-white hover-bg-100 action-btn nova-conta" type="button" data-bs-toggle="modal" data-bs-target="#modalNovaContaRecorrente">Adicionar nova</button>

                        </div>

                    </div>
                </div>
            </div>
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table class="table fs--1 mb-0 border-top border-200">
                    <thead>
                        <tr>
                            <th class="sort white-space-nowrap align-middle text-center" scope="col" data-sort="td_micro">Micro</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="td_credor">Credor</th>
                            <th class="sort text-end pe-0 align-middle text-center" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="list" id="table-latest-review-body">

                        <?php foreach ($contasRecorrentes as $contaRecorrente) { ?>

                            <tr class="hover-actions-trigger btn-reveal-trigger position-static tr-pagamento">

                                <td class="align-middle customer white-space-nowrap td_data_pagamento text-center">
                                    <h6 class="mb-0 text-900">
                                        <?= $contaRecorrente['MICRO']; ?>
                                    </h6>
                                </td>

                                <td class="align-middle review td_credor text-center">
                                    <h6 class="mb-0 text-900"><?= $contaRecorrente['RECEBIDO']; ?></h6>
                                </td>

                                <td class="align-middle white-space-nowrap text-end pe-0">

                                    <div class="font-sans-serif btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item" href="#" onclick="visualizarConta(<?= $contaRecorrente['ID_CONTA']?>)" data-bs-toggle="modal" data-bs-target="#modalNovaContaRecorrente">
                                                <span class="fas fa-pencil"></span> Editar
                                            </a>
                                            <a class="dropdown-item" href="#" onclick="deletarConta(<?= $contaRecorrente['ID_CONTA']?>)">
                                                <span class="fas fa-trash"></span> Excluir
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


    <!-- Modal Adicionar conta recorrente -->
    <div class="modal fade" tabindex="-1" id="modalNovaContaRecorrente">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Lançamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body-coleta">

                    <div class="card">
                        <div class="card-body form-contas-recorrentes">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="col-sm-12 col-xxl-12 py-3">
                                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Grupos Macros</label>
                                                    <select class="form-select select2 select-macros input-obrigatorio dados-conta" name="id_macro">
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
                                                    <select disabled class="form-select select2 select-micros input-obrigatorio dados-conta" name="id_micro">
                                                        <option selected disabled value="">Selecione</option>
                                                        <!-- JS -->
                                                    </select>
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                            </div>


                                            <div class="col-lg-6">

                                                <div class="mb-4">
                                                    <label class="text-body-highlight fw-bold mb-2">Grupo de Credores</label>
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
                    <button class="btn btn-success btn-form" type="button" onclick="cadastraContasRecorrentes('form-contas-recorrentes')">Salvar</button>
                    <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>
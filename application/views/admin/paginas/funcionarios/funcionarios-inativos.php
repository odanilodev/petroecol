<div class="content">
    <div id="members-inativados" data-list='{"valueNames":["nome","data-demissao","cpf","saldo"],"page":10,"pagination":true}'>
        <div class="row align-items-center justify-content-between g-3 mb-4">
            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <a href="<?= base_url("funcionarios/") ?>" class="btn btn-secondary"><span class="fas fa-arrow-left me-2"></span>Voltar para Ativos</a>
                </div>
            </div>

            <div class="col col-auto">
                <div class="search-box">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                        <input class="form-control search-input search" type="search" placeholder="Buscar Funcionários Inativados" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>
                    </form>
                </div>
            </div>
        </div>

        <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
            <div class="table-responsive scrollbar ms-n1 ps-1">
                <table class="table table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th class="white-space-nowrap fs--1 align-middle ps-0">
                                <div class="form-check mb-0 fs-0">
                                    <input class="form-check-input" id="checkbox-bulk-members-select-inativados" type="checkbox" data-bulk-select='{"body":"members-table-body-inativados"}' />
                                </div>
                            </th>

                            <th class="sort align-middle" scope="col" data-sort="nome">Funcionário</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="data-demissao">Data Demissão</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="cpf">CPF</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="saldo">Saldo</th>
                            <th class="sort align-middle pe-3 text-center">Alterar status</th>
                        </tr>
                    </thead>

                    <tbody class="list" id="members-table-body-inativados">

                        <?php foreach ($funcionariosInativados as $funcionarioInativado) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                <td class="fs--1 align-middle ps-0 py-3 text-center">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input" type="checkbox" data-bulk-select-row='{"customer":{"avatar":"/team/32.webp","name":"Carry Anna"},"email":"annac34@gmail.com","mobile":"+912346578","city":"Budapest","lastActive":"34 min ago","joined":"Dec 12, 12:56 PM"}' />
                                    </div>
                                </td>

                                <td class="customer align-middle white-space-nowrap">
                                    <a class="d-flex align-items-center text-900" href="<?= base_url('funcionarios/detalhes/') . $funcionarioInativado['id'] . '/0' ?> ">
                                        <div class="avatar avatar-m">
                                            <img class="rounded-circle" src="<?= $funcionarioInativado['foto_perfil'] ? base_url_upload('funcionarios/perfil/' . ($funcionarioInativado['foto_perfil'])) : base_url('assets/img/icons/sem_foto.jpg') ?>">
                                        </div>
                                        <h6 class="mb-0 ms-3 fw-semi-bold nome"><?= $funcionarioInativado['nome'] ?></h6>
                                    </a>
                                </td>

                                <td class="mobile_number align-middle white-space-nowrap data-demissao text-center">
                                    <h6 class="fw-bold text-1100">
                                        <?= !empty($funcionarioInativado['data_demissao']) ? date('d/m/Y', strtotime($funcionarioInativado['data_demissao'])) : (!empty($funcionarioInativado['editado_em']) ? date('d/m/Y', strtotime($funcionarioInativado['editado_em'])) : 'Data não disponível') ?>
                                    </h6>
                                </td>

                                <td class="mobile_number align-middle white-space-nowrap cpf text-center">
                                    <h6 class="fw-bold text-1100"><?= $funcionarioInativado['cpf'] ?></h6>
                                </td>

                                <td class="mobile_number align-middle white-space-nowrap saldo text-center">
                                    <h6 class="fw-bold text-1100">
                                        <?= isset($funcionarioInativado['saldo']) ? 'R$ ' . number_format($funcionarioInativado['saldo'], 2, ',', '.') : 'R$ 0,00' ?>
                                    </h6>
                                </td>

                                <td class="align-middle white-space-nowrap text-center">
                                    <a href="#" class="btn btn-phoenix-success" onclick="reativarFuncionario(<?= $funcionarioInativado['id'] ?>)">
                                        <span class="fas fa-toggle-on ms-1"></span> Reativar
                                    </a>
                                </td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
            <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
                <div class="col-auto d-flex w-100 justify-content-end">
                    <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                </div>
            </div>
        </div>
    </div>
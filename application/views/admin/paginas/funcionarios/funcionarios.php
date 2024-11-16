<div class="content">
    <div id="members" data-list='{"valueNames":["nome","cpf","saldo"],"page":10,"pagination":true}'>
        <div class="row align-items-center justify-content-between g-3 mb-4">

            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <a href="<?= base_url("funcionarios/formulario") ?>" class="btn btn-primary me-2"><span class="fas fa-plus me-2"></span>Adicionar Funcionário</a>
                </div>
            </div>

            <div class="col col-auto">
                <div class="d-flex align-items-center">
                    <div class="search-box me-2">
                        <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                            <input class="form-control search-input search" type="search" placeholder="Buscar Funcionarios" aria-label="Search" />
                            <span class="fas fa-search search-box-icon"></span>
                        </form>
                    </div>
                    <a href="<?= base_url("funcionarios/inativados") ?>" class="btn btn-secondary"><span class="fas fa-users-slash me-2"></span>Ver Inativados</a>
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
                                    <input class="form-check-input" id="checkbox-bulk-members-select" type="checkbox" data-bulk-select='{"body":"members-table-body"}' />
                                </div>
                            </th>

                            <th class="sort align-middle" scope="col" data-sort="nome">Funcionario</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="cpf">CPF</th>
                            <th class="sort align-middle text-center" scope="col" data-sort="saldo">Saldo</th>
                            <th class="sort align-middle pe-3 text-center">Detalhes</th>
                        </tr>
                    </thead>

                    <tbody class="list" id="members-table-body">

                        <?php foreach ($funcionarios as $v) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                <td class="fs--1 align-middle ps-0 py-3 text-center">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input" type="checkbox" data-bulk-select-row='{"customer":{"avatar":"/team/32.webp","name":"Carry Anna"},"email":"annac34@gmail.com","mobile":"+912346578","city":"Budapest","lastActive":"34 min ago","joined":"Dec 12, 12:56 PM"}' />
                                    </div>
                                </td>

                                <td class="customer align-middle white-space-nowrap">
                                    <a class="d-flex align-items-center text-900" href="<?= base_url('funcionarios/detalhes/') . $v['id'] ?>">
                                        <div class="avatar avatar-m">
                                            <img class="rounded-circle" src="<?= $v['foto_perfil'] ? base_url_upload('funcionarios/perfil/' . ($v['foto_perfil'])) : base_url('assets/img/icons/sem_foto.jpg') ?>">
                                        </div>
                                        <h6 class="mb-0 ms-3 fw-semi-bold nome"><?= $v['nome'] ?></h6>
                                    </a>
                                </td>

                                <td class="mobile_number align-middle white-space-nowrap cpf text-center">
                                    <h6 class="fw-bold text-1100"><?= $v['cpf'] ?></h6>
                                </td>

                                <td class="mobile_number align-middle white-space-nowrap saldo text-center">
                                    <h6 class="fw-bold text-1100">
                                        <?= isset($v['saldo']) ? 'R$ ' . number_format($v['saldo'], 2, ',', '.') : 'R$ 0,00' ?>
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
                                        <div class="dropdown-menu dropdown-menu-end py-2">
                                            <a class="dropdown-item" href="<?= base_url('funcionarios/detalhes/' . $v['id']) ?>">
                                                <span class="fas fa-eye"></span> Visualizar
                                            </a>
                                            <a class="dropdown-item" href="<?= base_url('funcionarios/formulario/' . $v['id']) ?>">
                                                <span class="fas fa-pencil"></span> Editar
                                            </a>
                                            <a class="dropdown-item" href="#" onclick="deletarFuncionario(<?= $v['id'] ?>)">
                                                <span class="fas fa-trash"></span> Inativar
                                            </a>
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

                <div class="col-auto d-flex w-100 justify-content-end">
                    <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                </div>
            </div>
        </div>
    </div>
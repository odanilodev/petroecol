<div class="content">
    <div id="members" data-list='{"valueNames":["nome"],"page":10,"pagination":true}'>
        <div class="row align-items-center justify-content-between g-3 mb-4">

            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-900 me-4 px-0 d-none"><span class="fa-solid fa-file-export fs--1 me-2"></span>Export</button>
                    <a href="<?= base_url("finDadosFinanceiros/formulario") ?>" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Cadastrar Dados Financeiros</a>
                    <a href="#" class="btn btn-danger d-none btn-excluir-tudo mx-2" onclick="deletaDadosFinanceiros()"><span class="fas fa-trash"></span>  Excluir tudo</a>
                </div>

            </div>

            <div class="col col-auto">
                <div class="search-box">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                        <input class="form-control search-input search" type="search" placeholder="Buscar Dados Financeiros" aria-label="Search" />
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
                                <!-- Check para todos -->
                                <div class="form-check mb-0 fs-0">
                                    <input class="form-check-input check-all-element cursor-pointer" type="checkbox"/>
                                </div>
                            </th>

                            <th class="sort align-middle" scope="col" data-sort="nome">Nome</th>
                            <th class="sort align-middle pe-3">Editar</th>
                            <th class="sort align-middle pe-3">Excluir</th>
                        </tr>
                    </thead>

                    <tbody class="list" id="members-table-body">

                        <?php foreach ($dadosFinanceiros as $v) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                <!-- check para cada um -->
                                <td class="fs--1 align-middle ps-0 py-3">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input check-element cursor-pointer" type="checkbox" value="<?= $v['id'] ?>"/>
                                    </div>
                                </td>

                                <td class="nome align-middle white-space-nowrap">
                                    <?= $v['nome'] ?>
                                </td>

                                <td class="align-middle white-space-nowrap">
                                    <a href="<?= base_url('finDadosFinanceiros/formulario/' . $v['id']) ?>" class="btn btn-info">
                                        <span class="fas fa-pencil ms-1"></span>
                                    </a>
                                </td>

                                <td class="align-middle white-space-nowrap">
                                    <a href="#" class="btn btn-danger" onclick="deletaDadosFinanceiros(<?= $v['id'] ?>)">
                                        <span class="fas fa-trash ms-1"></span>
                                    </a>
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

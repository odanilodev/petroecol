<div class="content">
    <div id="members" data-list='{"valueNames":["nome-residuo", "nome-grupo", "setor-residuo"],"page":10,"pagination":true}'>
        <div class="row align-items-center justify-content-between g-3 mb-4">

            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-900 me-4 px-0 d-none"><span class="fa-solid fa-file-export fs--1 me-2"></span>Export</button>
                    <a href="<?= base_url("residuos/formulario") ?>" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Adicionar Resíduos</a>
                </div>
            </div>

            <div class="col col-auto">
                <div class="search-box">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                        <input class="form-control search-input search" type="search" placeholder="Buscar Resíduos" aria-label="Search" />
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
                                    <input class="form-check-input" id="checkbox-bulk-members-select" type="checkbox" data-bulk-select='{"body":"members-table-body"}' />
                                </div>
                            </th>

                            <th class="sort align-middle" scope="col" data-sort="nome-residuo">Resíduos</th>
                            <th class="sort align-middle" scope="col" data-sort="nome-grupo">Grupo</th>
                            <th class="sort align-middle" scope="col" data-sort="setor-residuo">Setor Resíduo</th>
                            <th class="sort align-middle pe-3">Editar</th>
                            <th class="sort align-middle pe-3">Excluir</th>
                        </tr>
                    </thead>

                    <tbody class="list" id="members-table-body align-middle">

                        <?php foreach ($residuos as $v) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                <td class="fs--1 align-middle ps-0 py-3">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input" type="checkbox" data-bulk-select-row='{"customer":{"avatar":"/team/32.webp","name":"Carry Anna"},"email":"annac34@gmail.com","mobile":"+912346578","city":"Budapest","lastActive":"34 min ago","joined":"Dec 12, 12:56 PM"}' />
                                    </div>
                                </td>

                                <td class="nome-residuo align-middle white-space-nowrap">
                                    <?= $v['nome'] ?>
                                </td>

                                <td class="nome-grupo align-middle white-space-nowrap">
                                    <?= $v['nome_grupo'] ?>
                                </td>

                                <td class="setor-residuo align-middle white-space-nowrap">
                                    <?= $v['SETOR'] ?>

                                </td>

                                <td class="align-middle white-space-nowrap">
                                    <a href="<?= base_url('residuos/formulario/' . $v['id']) ?>" class="btn btn-info">
                                        <span class="fas fa-pencil ms-1"></span>
                                    </a>
                                </td>

                                <td class="align-middle white-space-nowrap">
                                    <a href="#" class="btn btn-danger" onclick="deletarResiduo(<?= $v['id'] ?>)">
                                        <span class="fas fa-trash ms-1"></span>
                                    </a>
                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>
                </table>

            </div>

        </div>
    </div>

    <!-- Links de Paginação usando classes Bootstrap -->
    <div class="row">
        <div class="col-12">
            <nav aria-label="Page navigation" style="display: flex; float: right">
                <ul class="pagination">
                    <?= $this->pagination->create_links(); ?>
                </ul>
            </nav>
        </div>
    </div>
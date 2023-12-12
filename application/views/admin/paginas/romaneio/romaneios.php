<div class="content">
    <div id="members" data-list='{"valueNames":["customer","email","mobile_number","city","last_active","joined"],"page":10,"pagination":true}'>

        <div class="row align-items-center justify-content-between g-3 mb-4">

            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-900 me-4 px-0 d-none"><span class="fa-solid fa-file-export fs--1 me-2"></span>Export</button>
                    <a href="<?= base_url("romaneios/formulario") ?>" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Novo Romaneio</a>
                </div>
            </div>

            <div class="col col-auto">
                <div class="search-box">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                        <input class="form-control search-input search" type="search" placeholder="Buscar Romaneios" aria-label="Search" />
                        <span class="fas fa-search search-box-icon"></span>

                    </form>
                </div>
            </div>
        </div>

        <?php if (!empty($ultimosRomaneios)) { ?>

            <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
                <div class="table-responsive scrollbar ms-n1 ps-1">

                    <table class="table table-lg mb-0 table-hover text-center">
                        <thead>
                            <tr>
                                <th class="white-space-nowrap fs--1 align-middle ps-0">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input" id="checkbox-bulk-members-select" type="checkbox" data-bulk-select='{"body":"members-table-body"}' />
                                    </div>
                                </th>

                                <th class="sort align-middle">Código</th>
                                <th class="sort align-middle">Motorista</th>
                                <th class="sort align-middle">Data Romaneio</th>
                                <th class="sort align-middle">Gerado em</th>
                                <th class="sort align-middle p-3">Gerar</th>
                                <th class="sort align-middle p-3">Concluir Romaneio</th>
                            </tr>
                        </thead>

                        <tbody class="list" id="members-table-body">

                            <?php foreach ($ultimosRomaneios as $v) { ?>

                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                    <td class="fs--1 align-middle ps-0 py-3">
                                        <div class="form-check mb-0 fs-0">
                                            <input class="form-check-input" type="checkbox" data-bulk-select-row='{"customer":{"avatar":"/team/32.webp","name":"Carry Anna"},"email":"annac34@gmail.com","mobile":"+912346578","city":"Budapest","lastActive":"34 min ago","joined":"Dec 12, 12:56 PM"}' />
                                        </div>
                                    </td>

                                    <td class="email align-middle white-space-nowrap">
                                        <?= $v['codigo']; ?>
                                    </td>

                                    <td class="mobile_number align-middle white-space-nowrap">
                                        <?= $v['MOTORISTA']; ?>
                                    </td>

                                    <td class="mobile_number align-middle white-space-nowrap">
                                        <?= date('d/m/Y', strtotime($v['data_romaneio'])) ?>
                                    </td>

                                    <td class="mobile_number align-middle white-space-nowrap">
                                        <?= date('d/m/Y H:i:s', strtotime($v['criado_em'])) ?>
                                    </td>

                                    <td class="align-middle white-space-nowrap">
                                        <a target="_blank" href="<?= base_url('romaneios/gerarromaneio/' . $v['codigo']) ?>" class="btn btn-info">
                                            <span class="fas fa-download ms-1"></span>
                                        </a>
                                    </td>

                                    <td class="align-middle white-space-nowrap">
                                        <button <?= $v['status'] == 1 ? 'disabled' : '' ?> type="button" onclick='concluirRomaneio(<?= $v["codigo"] ?>, <?= $v["ID_MOTORISTA"] ?>)' class="btn <?= $v['status'] != 1 ? 'btn-secondary' : 'btn-success' ?>">
                                            <span class="ms-1" data-feather="check-circle"></span>
                                        </button>
                                    </td>

                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>

        <?php } ?>
    </div>

    <!-- Modal Romaneio-->
    <div class="modal fade" id="modalConcluirRomaneio" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollabe">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Concluir Romaneio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <div class="row">

                        <div class="accordion dados-clientes-div" id="accordionExample">

                            <!-- Manipulado JS -->
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <div class="spinner-border text-primary load-form d-none load-form-modal-romaneio" role="status"></div>
                    <button type="button" class="btn btn-primary btn-finaliza-romaneio" onclick="finalizarRomaneio()">Gerar Romaneio</button>
                    <input type="hidden" class="id_motorista">
                    <input type="hidden" class="code_romaneio">
                </div>
            </div>
        </div>
    </div>
<div class="content">
    <div id="members">
        <div class="row align-items-center justify-content-between g-3 mb-4">

            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <a href="<?= base_url("trajetos/formulario") ?>" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Adicionar Trajeto</a>
                    <a href="#" class="btn btn-danger d-none btn-excluir-tudo mx-2" onclick="deletarEtiqueta()"><span class="fas fa-trash"></span> Excluir tudo</a>
                </div>

            </div>

            <div class="col col-auto">
                <div class="search-box">
                    <form action="<?= base_url('trajetos') ?>" method="POST" class="position-relative" data-bs-toggle="search" data-bs-display="static">
                        <input name="nome" value="<?= $cookie_filtro_trajetos['nome'] ?? null ?>" class="form-control search-input search" type="search" placeholder="Buscar Trajetos" aria-label="Search">
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

                            <th class="sort align-middle text-center" scope="col" data-sort="nome-trajeto">Trajeto</th>
                            <th class="sort align-middle text-center pe-3">Editar</th>
                            <th class="sort align-middle text-center pe-3">Excluir</th>
                        </tr>
                    </thead>

                    <tbody class="list" id="members-table-body">

                        <?php foreach ($trajetos as $trajeto) { ?>
                            <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                <td class="nome-trajeto align-middle text-center white-space-nowrap">
                                    <?= $trajeto['nome'] ?>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    <a href="<?= base_url('trajetos/formulario/' . $trajeto['id']) ?>" class="btn btn-info">
                                        <span class="fas fa-pencil ms-1"></span>
                                    </a>
                                </td>

                                <td class="align-middle text-center white-space-nowrap">
                                    <a href="#" class="btn btn-danger" onclick="deletarTrajeto(<?= $trajeto['id'] ?>)">
                                        <span class="fas fa-trash ms-1"></span>
                                    </a>
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
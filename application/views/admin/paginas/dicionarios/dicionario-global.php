<div class="content">
    <div id="members" data-list='{"valueNames":["Chave", "Valor PT-BR", "Valor EN"],"page":10,"pagination":true}'>
        <div class="row align-items-center justify-content-between g-3 mb-4">

            <div class="col-auto">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-900 me-4 px-0 d-none"><span class="fa-solid fa-file-export fs--1 me-2"></span>Export</button>
                    <a href="<?= base_url("dicionario/formulario") ?>" class="btn btn-primary"><span class="fas fa-plus me-2"></span>Cadastrar Dicionario</a>
                </div>
            </div>

            <div class="col col-auto">
                <div class="d-flex mb-3">
                    <div class="search-box me-2">
                        <form method="POST" action="<?=base_url('dicionario/chavesGlobais')?>" class="position-relative" data-bs-toggle="search" data-bs-display="static">
                            <input name="chave" value="<?= $cookie_filtro_dicionario['chave'] ?? null ?>" class="form-control search-input search" type="search" placeholder="Buscar Chave" aria-label="Search">
                            <span class="fas fa-search search-box-icon"></span>
                        </form>
                    </div>
                </div>
            </div>
            <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
                <div class="table-responsive scrollbar ms-n1 ps-1">
                    <table class="table table-sm fs--1 mb-0 text-center">
                        <thead>
                            <tr>
                                <th class="white-space-nowrap fs--1 align-middle ps-0">
                                    <div class="form-check mb-0 fs-0">
                                        <input class="form-check-input" id="checkbox-bulk-members-select" type="checkbox" data-bulk-select='{"body":"members-table-body"}' />
                                    </div>
                                </th>

                                <th class="sort align-middle" scope="col" data-sort="Chave">Chave</th>
                                <th class="sort align-middle" scope="col" data-sort="Valor PT-BR">Valor PT-BR</th>
                                <th class="sort align-middle" scope="col" data-sort="Valor EN">Valor EN</th>
                                <th class="sort align-middle pe-3">Editar</th>
                                <th class="sort align-middle pe-3">Excluir</th>
                            </tr>
                        </thead>

                        <tbody class="list text-center" id="members-table-body">

                            <?php foreach ($dicionarioGlobal as $v) { ?>
                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                    <td class="fs--1 align-middle ps-0 py-3">
                                        <div class="form-check mb-0 fs-0">
                                            <input class="form-check-input" type="checkbox" data-bulk-select-row='' />
                                        </div>
                                    </td>

                                    <td class="Chave align-middle white-space-nowrap">
                                        <?= $v['chave'] ?>
                                    </td>

                                    <td class="Valor PT-BR align-middle white-space-nowrap">
                                        <?= $v['valor_ptbr'] ?>
                                    </td>

                                    <td class="Valor EN align-middle white-space-nowrap">
                                        <?= $v['valor_en'] ?>
                                    </td>

                                    <td class="align-middle white-space-nowrap">
                                        <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalDicionario" onclick="editarDicionarioGlobal(<?= $v['id'] ?>)">
                                            <span class="fas fa-pencil ms-1"></span>
                                        </a>
                                    </td>

                                    <td class="align-middle white-space-nowrap">
                                        <a href="#" class="btn btn-danger" onclick="deletarDicionarioGlobal(<?= $v['id'] ?>)">
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

        <!-- Modal de Dicionarios(edição) -->

        <div class="modal fade" id="modalDicionario" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Dicionário</h5>
                        <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-dicionario">
                            <input type="hidden" class="input-id" value="">

                            <div class="row campos-dicionario campos-formulario">
                                <div class="col-md-4 mb-3 duplica-dicionario">
                                    <label class="form-label">Chave</label>
                                    <input required class="form-control input-chave input-obrigatorio" required name="chave[]" type="text" placeholder="Chave de pesquisa" value="">
                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                                </div>

                                <div class="col-md-4 mb-3 duplica-dicionario">
                                    <label class="form-label">Valor PT-BR</label>
                                    <input required class="form-control input-valor-ptbr input-obrigatorio" name="valor-ptbr[]" type="text" placeholder="Texto em Português" value="">
                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                </div>

                                <div class="col-md-4 mb-3 duplica-dicionario" style="position: relative;">
                                    <label class="form-label">Valor EN</label>
                                    <div class="input-group">
                                        <input required class="form-control input-valor-en input-obrigatorio" name="valor-en[]" type="text" placeholder="Texto em Inglês" value="">
                                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>

                    <div class="modal-footer">

                        <div class="spinner-border text-primary load-form d-none" role="status"></div>

                        <button class="btn btn-success btn-salva-residuo btn-envia" type="button" onclick="cadastraDicionarioGlobal()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
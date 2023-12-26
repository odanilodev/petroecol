<div class="content">
    <div class="row mb-9">
        <div class="col-12">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0">
                                <?= $this->uri->segment(3) ? "Editar Dicionário" : "Adicionar novo Dicionário" ?>
                            </h4>

                        </div>
                    </div>
                </div>

                <div class="card-body p-0">

                    <div class="p-4 code-to-copy">
                        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

                            <div class="card-body pt-4 pb-0">
                                <form id="form-categoria" class="row" method="post">

                                    <input type="hidden" class="input-id" value="<?= $dicionarioGlobal['id'] ?? ''; ?>">

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Chave</label>
                                        <input required class="form-control input-chave input-obrigatorio" required name="chave" type="text" placeholder="Chave de pesquisa" value="<?= $dicionarioGlobal['chave'] ?? "" ?>">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Valor PT-BR</label>
                                        <input required class="form-control input-valor-ptbr input-obrigatorio" name="valor-ptbr" type="text" placeholder="Texto em Português" value="<?= $dicionarioGlobal['valor_ptbr'] ?? "" ?>">
                                    </div>

                                    <div class="col-md-4 mb-3" style="position: relative;">
                                        <label class="form-label">Valor EN</label>
                                        <div class="input-group">
                                            <input required class="form-control input-valor-en input-obrigatorio" name="valor-en" type="text" placeholder="Texto em Inglês" value="<?= $dicionarioGlobal['valor_en'] ?? "" ?>">
                                            <button type="button" class="btn btn-sm btn-primary btn-adicionar-campo" style="margin-left: 8px;">
                                                <span class="fas fa-plus"></span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex-1 text-end my-5">
                                        <button type="button" class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraDicionarioGlobal()"><?= $this->uri->segment(3) ? 'Editar ' : 'Cadastrar'; ?>
                                            <span class="fas fa-chevron-right" data-fa-transform="shrink-3"> </span>
                                        </button>
                                        <div class="spinner-border text-primary load-form d-none" role="status"></div>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
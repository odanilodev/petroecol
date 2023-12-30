<div class="content">
    <div class="row mb-9">
        <div class="col-12">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0">
                                Adicionar novo Dicionário
                            </h4>

                        </div>
                    </div>
                </div>

                <div class="card-body p-0">

                    <div class="p-4 code-to-copy">
                        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

                            <div class="card-body pt-4 pb-0">
                                <form id="form-dicionario" class="" method="post">
                                    <div class="row campos-dicionario campos-formulario">
                                        
                                        <div class="col-md-4 mb-3 duplica-dicionario">
                                            <label class="form-label">Chave</label>
                                            <input required class="form-control input-chave input-obrigatorio" required name="chave[]" type="text" placeholder="Chave de pesquisa" value="<?= $dicionarioGlobal['chave'] ?? "" ?>">
                                        </div>

                                        <div class="col-md-3 mb-3 duplica-dicionario">
                                            <label class="form-label">Valor PT-BR</label>
                                            <input required class="form-control input-valor-ptbr input-obrigatorio" name="valor-ptbr[]" type="text" placeholder="Texto em Português" value="<?= $dicionarioGlobal['valor_ptbr'] ?? "" ?>">
                                        </div>

                                        <div class="col-md-3 mb-3 duplica-dicionario">
                                            <label class="form-label">Valor EN</label>
                                            <input required class="form-control input-valor-en input-obrigatorio" name="valor-en[]" type="text" placeholder="Texto em Inglês" value="<?= $dicionarioGlobal['valor_en'] ?? "" ?>">
                                        </div>

                                        <div class="col-md-2 mt-4">
                                            <button type="button" class="btn btn-sm btn-primary btn-adicionar-campo" onclick="duplicarDicionario()">
                                                <span class="fas fa-plus"></span>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="campos-duplicados row campos-formulario">
                                        <!-- tratamento js -->
                                    </div>

                                    <div class="flex-1 text-end my-5">
                                        <button type="button" class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraDicionarioGlobal()">Cadastrar
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
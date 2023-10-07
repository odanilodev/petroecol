<div class="content">
    <div class="row mb-9">

        <div class="col-12">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0">Adicionar novo resíduo</h4>

                        </div>
                    </div>
                </div>

                <div class="card-body p-0">

                    <div class="accordion" id="accordionExample">

                        <div class="accordion-item" style="border: none !important;">

                            <div class="accordion-collapse collapse show" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body pt-0">
                                    <div class="p-4 code-to-copy">
                                        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

                                            <div class="card-body pt-4 pb-0 row">
                                                <input type="hidden" class="input-id" value="<?= $residuo['id'] ?? ''; ?>">

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Nome</label>
                                                    <input class="form-control input-nome" type="text" placeholder="Digite o nome do resíduo" value="<?= $residuo['nome'] ?? ''; ?>">
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="mb-2">
                                                        <label class="form-label text-900">Grupo</label>
                                                        <select class="form-select input-grupo">
                                                            <option value="" selected disabled>Selecione</option>
                                                            <option value="1">Resíduos de Óleos</option>
                                                            <option value="2">Resíduos Perigosos</option>
                                                            <option value="3">Resíduos Eletrônicos (e-lixo)</option>
                                                            <option value="4">Resíduos Orgânicos</option>
                                                            <option value="5">Resíduos de Construção e Demolição (RCD)</option>
                                                            <option value="6">Resíduos Industriais</option>
                                                            <option value="7">Resíduos Agrícolas</option>
                                                            <option value="8">Resíduos de Serviços de Saúde</option>
                                                            <option value="9">Resíduos de Mineração</option>
                                                            <option value="10">Resíduos Sólidos de Construção Naval</option>
                                                            <option value="11">Resíduos Plásticos</option>
                                                            <option value="12">Resíduos Alimentares</option>
                                                            <option value="13">Resíduos de Papel e Papelão</option>
                                                            <option value="14">Resíduos de Metais</option>
                                                            <option value="15">Resíduos de Vidro</option>
                                                            <option value="16">Resíduos Radioativos</option>
                                                            <option value="17">Resíduos Sólidos Urbanos (RSU)</option>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="flex-1 text-end my-4">
                                                    <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraResiduos()">Cadastrar
                                                        <span class="fas fa-chevron-right" data-fa-transform="shrink-3"> </span>
                                                    </button>
                                                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>

    </div>
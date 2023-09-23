<div class="content">
    <div class="row mb-9">

        <div class="col-12">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0">Adicionar novo menu</h4>

                            <div class="row mt-4">
                                <div class="col--1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <span class="uil-plus-circle ms-1" data-fa-transform="shrink-3"> Categoria</span>
                                    </button>
                                </div>

                                <div class="col--1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        <span class="uil-plus-circle ms-1" data-fa-transform="shrink-3"> Categoria Pai</span>
                                    </button>
                                </div>

                                <div class="col--1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                        <span class="uil-plus-circle ms-1" data-fa-transform="shrink-3"> Sub Categoria</span>
                                    </button>
                                </div>
                            </div>

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

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="inputAddress">Nome</label>
                                                    <input class="form-control" id="inputAddress" type="text" placeholder="Nome">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="inputAddress2">Ícone</label>
                                                    <input class="form-control" id="inputAddress2" type="text" placeholder="Icone">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="inputAddress2">Link</label>
                                                    <input class="form-control" id="inputAddress2" type="text" placeholder="Link">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="inputAddress2">Ordem</label>
                                                    <input class="form-control" id="inputAddress2" type="text" placeholder="Ordem">
                                                </div>


                                                <div class="flex-1 text-end my-5">
                                                    <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraUsuario()">Cadastrar
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

                        <div class="accordion-item" style="border: none !important;">

                            <div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body pt-0">
                                    <div class="p-4 code-to-copy">
                                        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

                                            <div class="card-body pt-4 pb-0 row">

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label" for="inputAddress">Nome</label>
                                                    <input class="form-control" id="inputAddress" type="text" placeholder="Nome">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label" for="inputAddress2">Ícone</label>
                                                    <input class="form-control" id="inputAddress2" type="text" placeholder="Icone">
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label" for="inputAddress2">Ordem</label>
                                                    <input class="form-control" id="inputAddress2" type="text" placeholder="Ordem">
                                                </div>


                                                <div class="flex-1 text-end my-5">
                                                    <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraUsuario()">Cadastrar
                                                        <span class="fas fa-chevron-right ms-5" data-fa-transform="shrink-3"> </span>
                                                    </button>
                                                    <div class="spinner-border text-primary load-form d-none" role="status"></div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" style="border: none !important;">

                            <div class="accordion-collapse collapse" id="collapseThree" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body pt-0">
                                    <div class="p-4 code-to-copy">
                                        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

                                            <div class="card-body pt-4 pb-0 row">

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="inputAddress">Nome</label>
                                                    <input class="form-control" id="inputAddress" type="text" placeholder="Nome">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="inputAddress2">Subcategoria</label>
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected="">Selecione</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="inputAddress2">Link</label>
                                                    <input class="form-control" id="inputAddress2" type="text" placeholder="Ordem">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="inputAddress2">Ordem</label>
                                                    <input class="form-control" id="inputAddress2" type="text" placeholder="Ordem">
                                                </div>


                                                <div class="flex-1 text-end my-5">
                                                    <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraUsuario()">Cadastrar
                                                        <span class="fas fa-chevron-right ms-5" data-fa-transform="shrink-3"> </span>
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
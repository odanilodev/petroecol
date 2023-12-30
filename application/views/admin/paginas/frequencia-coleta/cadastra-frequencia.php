<div class="content">
    <div class="row mb-9">

        <div class="col-12">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0"><?=$this->uri->segment(3) ? 'Editar Frequência' : 'Cadastrar Nova Frequência';?></h4>

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
                                                <input type="hidden" class="input-id" value="<?= $frequencia['id'] ?? ''; ?>">

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Frequência:</label>
                                                    <input class="form-control input-frequencia input-obrigatorio" type="text" placeholder="Escolha o nome para a frequência" value="<?= $frequencia['frequencia'] ?? ''; ?>">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Dias:</label>
                                                    <input class="form-control input-dias input-obrigatorio" type="number" placeholder="Escolha de quanto em quanto tempo" value="<?= $frequencia['dia'] ?? ''; ?>">
                                                    <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                                                </div>

                                                <div class="flex-1 text-end my-5">
                                                    <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraFrequenciaColeta()"><?=$this->uri->segment(3) ? 'Editar' : 'Cadastrar';?>
                                                        <span class="fas fa-chevron-right" data-fa-transform="shrink-3" > </span>
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
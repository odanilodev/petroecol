<div class="content">
    <div class="row mb-9">

        <div class="col-12">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0">
                                <?= $this->uri->segment(3) ? 'Editar Dados Financeiros' : 'Cadastrar Dados Financeiros'; ?></h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">

                    <div class="p-4 code-to-copy">
                        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

                            <div class="card-body pt-4 pb-0">
                                <div class="tab-pane row" role="tabpanel" aria-labelledby="bootstrap-wizard-validation-tab2" id="bootstrap-wizard-validation-tab2">
                                    <form method="post" class="needs-validation" novalidate="novalidate" data-wizard-form="1">

                                        <input type="hidden" class="input-id" value="<?= isset($dadoFinanceiro['id']) ? $dadoFinanceiro['id'] : "" ?>">

                                        <div class="row">
                                            <div class="mb-2 col-md-4">
                                                <label class="form-label text-900 " for="bootstrap-wizard-validation-wizard-name">Nome*</label>
                                                <input required value="<?= isset($dadoFinanceiro['nome']) ? $dadoFinanceiro['nome'] : "" ?>" class="form-control input-obrigatorio input-nome" type="text" name="nome" placeholder="Nome do Dado Financeiro" id="bootstrap-wizard-validation-wizard-name" />
                                                <div class="invalid-feedback">Preencha este campo.</div>
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label text-900">Razão Social*</label>
                                                <input required value="<?= isset($dadoFinanceiro['razao_social']) ? $dadoFinanceiro['razao_social'] : "" ?>" class="form-control input-obrigatorio input-razao-social " type="text" name="razao_social" placeholder="Digite a Razão Social" />
                                                <div class="d-none aviso-obrigatorio">Preencha este campo.</div>
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label" for="basic-form-dob">Tipo de cadastro</label>
                                                <input class="form-control input-tipo-cadastro" value="<?= isset($dadoFinanceiro['tipo_cadastro']) ? $dadoFinanceiro['tipo_cadastro'] : "" ?>" placeholder="dd/mm/yyyy" id="basic-form-dob" type="date">
                                            </div>

                                            <div class="mb-5 col-md-4">
                                                <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-name">Conta Bancária</label>
                                                <input value="<?= isset($dadoFinanceiro['conta_bancaria']) ? $dadoFinanceiro['conta_bancaria'] : "" ?>" class="form-control input-conta-bancaria" type="text" name="conta_bancaria" placeholder="Digite a conta bancaria" id="bootstrap-wizard-validation-wizard-name" />
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label text-900 " for="bootstrap-wizard-validation-wizard-cpf">CPF*</label>
                                                <input required value="<?= isset($dadoFinanceiro['cpf']) ? $dadoFinanceiro['cpf'] : "" ?>" class="form-control input-obrigatorio input-cpf mascara-cpf" type="text" name="nome" placeholder="Digite o CPF" />
                                                <div class="d-none aviso-obrigatorio">Preencha este campo.</div>
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-phone">Telefone</label>
                                                <input value="<?= isset($dadoFinanceiro['telefone']) ? $dadoFinanceiro['telefone'] : "" ?>" class="form-control input-telefone mascara-tel" type="text" name="telefone" placeholder="Digite o telefone" />
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <div class="mb-2">
                                                    <label class="form-label text-900">Cargo</label>
                                                    <select required name="id_cargo" class="form-select input-cargo input-obrigatorio select2">
                                                        <option value="" selected disabled>Selecione</option>
                                                        <?php foreach ($cargos as $c) { ?>
                                                            <option <?= isset($dadoFinanceiro['id_cargo']) && $dadoFinanceiro['id_cargo'] == $c['id'] ? "selected" : "" ?> value="<?= $c['id'] ?>"><?= $c['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">Preencha este campo.</div>
                                                </div>
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-name">Salario Base</label>
                                                <input value="<?= isset($dadoFinanceiro['salario_base']) ? $dadoFinanceiro['salario_base'] : "" ?>" class="form-control input-salario mascara-dinheiro" type="text" name="salario_base" placeholder="Digite o salário do funcionário" id="bootstrap-wizard-validation-wizard-name" />
                                                <div class="invalid-feedback">Preencha este campo.</div>
                                            </div>

                                            <div class="mb-5 col-md-4">
                                                <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-name">Residência</label>
                                                <input value="<?= isset($dadoFinanceiro['residencia']) ? $dadoFinanceiro['residencia'] : "" ?>" class="form-control input-residencia" type="text" name="residencia" placeholder="Digite o endereço" id="bootstrap-wizard-validation-wizard-name" />
                                                <div class="invalid-feedback">Preencha este campo.</div>
                                            </div>


                                            <div class="flex-1 pt-8 text-end my-5">
                                                <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraDadosFinanceiros()"><?= $this->uri->segment(3) ? 'Editar Dados Financeiros' : 'Cadastrar Dado Financeiros'; ?>
                                                    <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span>
                                                </button>
                                                <div class="spinner-border text-primary load-form d-none" role="status">
                                                </div>
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
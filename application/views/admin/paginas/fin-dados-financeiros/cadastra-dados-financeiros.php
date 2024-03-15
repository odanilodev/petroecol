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

                                        <input type="hidden" class="input-id" value="<?= $dadoFinanceiro['id'] ?? '' ?>">

                                        <div class="row">

                                            <label for="divisao-dados">Info. Transação</label><br>
                                            <hr>

                                            <div class="mb-2 col-md-3">
                                                <label class="form-label text-900">Nome*</label>
                                                <input required value="<?= $dadoFinanceiro['nome']?? "" ?>" class="form-control input-obrigatorio input-nome" type="text" name="nome" placeholder="Identificação do Dado Financeiro" />
                                                <div class="invalid-feedback">Preencha este campo.</div>
                                            </div>

                                            <div class="mb-2 col-md-3">
                                                <label class="form-label text-900">Grupo</label>
                                                <select name="id_grupo" class="form-select select-grupo select2">
                                                    <option value="" selected>Selecione o Grupo</option>

                                                    <?php foreach ($grupos as $v) { ?>
                                                        <option value="<?= $v['id'] ?>" <?= (isset($v['id_grupo']) && $v['id_grupo'] == $v['id']) ? 'selected' : ''; ?>><?= $v['nome']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>


                                            <div class="mb-2 col-md-3">
                                                <label class="form-label text-900">CNPJ*</label>
                                                <input required value="<?= $dadoFinanceiro['cnpj'] ?? '' ?>" class="form-control  input-cnpj mascara-cnpj" type="text" name="nome" placeholder="Digite o CNPJ" />

                                            </div>

                                            <div class="mb-2 col-md-3">
                                                <label class="form-label text-900">Razão Social*</label>
                                                <input required value="<?= $dadoFinanceiro['razao_social'] ?? "" ?>" class="form-control input-razao-social " type="text" name="razao_social" placeholder="Digite a Razão Social" />

                                            </div>

                                            <div class="mb-2 col-md-3">
                                                <label class="form-label" for="bootstrap-wizard-validation-wizard-phone">Telefone</label>
                                                <input value="<?= $dadoFinanceiro['telefone'] ?? "" ?>" class="form-control input-telefone mascara-tel" type="text" name="telefone" placeholder="Digite o telefone" />
                                            </div>

                                            <div class="mb-2 col-md-3">
                                                <label class="form-label" for="basic-form-dob">Tipo de cadastro</label>
                                                <select name="" class="form-select input-tipo-cadastro select2" id="">
                                                    <option disabled value="">Selecione o tipo</option>
                                                    <option value="1" >Pessoa Fisica</option>
                                                    <option value="2" >Pessoa Juridica</option>
                                                </select>
                                            </div>

                                            <div class="mb-2 col-md-3">
                                                <label class="form-label text-900">Conta Bancária</label>
                                                <input value="<?= $dadoFinanceiro['conta_bancaria'] ?? "" ?>" class="mascara-conta-bancaria form-control input-conta-bancaria" type="text" name="conta_bancaria" placeholder="Digite a conta bancaria"/>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="divisao-localizacao" class="mt-3">Info. Localização</label><br>
                                            <hr>

                                            <div class="mb-2 col-md-2">
                                                <label class="form-label">CEP</label>
                                                <input class="form-control campo input-cep mascara-cep" type="text" name="cep" value="<?= $dadoFinanceiro['cep'] ?? ''; ?>" placeholder="Insira o CEP">
                                            </div>

                                            <div class="col-md-10"></div>

                                            <div class="mb-2 col-md-3">
                                                <label class="form-label">Rua </label>
                                                <input disabled id="rua" required class="form-control campo" type="text" name="rua" value="<?= $dadoFinanceiro['rua'] ?? ''; ?>" placeholder="Nome da rua">
                                                <div class="invalid-feedback">Preencha este campo</div>
                                            </div>

                                            <div class="mb-2 col-md-1">
                                                <label class="form-label">N°</label>
                                                <input required class="form-control campo" type="text" name="numero" value="<?= $dadoFinanceiro['numero'] ?? ''; ?>" placeholder="Número">
                                                <div class="invalid-feedback">Preencha este campo</div>
                                            </div>

                                            <div class="mb-2 col-md-3">
                                                <label class="form-label">Bairro </label>
                                                <input disabled id="bairro" required class="form-control campo" type="text" name="bairro" value="<?= $dadoFinanceiro['bairro'] ?? ''; ?>" placeholder="Bairro">
                                                <div class="invalid-feedback">Preencha este campo</div>
                                            </div>

                                            <div class="mb-2 col-md-3">
                                                <label class="form-label">Cidade </label>
                                                <input disabled id="cidade" required class="form-control campo" type="text" name="cidade" value="<?= $dadoFinanceiro['cidade'] ?? ''; ?>" placeholder="Cidade">
                                                <div class="invalid-feedback">Preencha este campo</div>
                                            </div>

                                            <div class="mb-2 col-md-2">
                                                <label class="form-label">Estado </label>
                                                <input disabled id="estado" required class="form-control campo" type="text" name="estado" value="<?= $dadoFinanceiro['estado'] ?? ''; ?>" placeholder="Estado">
                                                <div class="invalid-feedback">Preencha este campo</div>
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label text-900">Complemento</label>
                                                <textarea value="<?= isset($dadoFinanceiro['complemento']) ? $dadoFinanceiro['complemento'] : "" ?>" rows="1" class="form-control input-residencia" type="text" name="residencia" placeholder="Digite o complemento"/></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="divisao-intermedio" class="mt-3">Info. Intermédio</label><br>
                                            <hr>

                                            <div class="mb-2 col-md-3">
                                                <label class="form-label text-900">Nome Intermédio</label>
                                                <input value="<?= $dadoFinanceiro['nome_contato'] ?? "" ?>" class="form-control input-nome-contato" type="text" name="residencia" placeholder="Nome Contato"/>
                                            </div>


                                            <div class="mb-2 col-md-3">
                                                <label class="form-label text-900" for="input-telefone">Telefone Intermédio</label>
                                                <input value="<?= $dadoFinanceiro['telefone_contato'] ?? "" ?>" class="form-control input-telefone mascara-tel" type="text" id="input-telefone" name="telefone" placeholder="Digite o telefone" />
                                            </div>

                                            <div class="mb-2 col-md-3">
                                                <label class="form-label text-900" for="bootstrap-wizard-validation-wizard-cpf">CPF Intermédio</label>
                                                <input required value="<?= $dadoFinanceiro['cpf'] ?? "" ?>" class="form-control input-cpf mascara-cpf" type="text" name="cpf" placeholder="Digite o CPF" />

                                            </div>

                                            <div class="flex-1 pt-8 text-end my-5">
                                                <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraDadosFinanceiros()"><?= $this->uri->segment(3) ? 'Editar Dados Financeiros' : 'Cadastrar Dado Financeiros'; ?>
                                                    <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span>
                                                </button>
                                                <div class="spinner-border text-primary load-form d-none" role="status">
                                                </div>
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
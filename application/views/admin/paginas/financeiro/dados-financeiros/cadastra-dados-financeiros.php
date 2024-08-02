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

                                    <input type="hidden" class="input-id" value="<?= $dadoFinanceiro['id'] ?? '' ?>">

                                    <div class="row">

                                        <label for="divisao-dados">Info. Transação</label><br>
                                        <hr>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label text-900" for="input-nome">Nome*</label>
                                            <input required value="<?= $dadoFinanceiro['nome'] ?? "" ?>" class="form-control input-obrigatorio input-obrigatorio" id="input-nome" type="text" name="nome" placeholder="Identificação do Dado Financeiro" />
                                            <div class="invalid-feedback">Preencha este campo.</div>
                                        </div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label text-900" for="input-id-grupo">Grupo*</label>
                                            <select required name="id_grupo" id="input-id-grupo" class="form-select select2 input-obrigatorio">
                                                <option value="" disabled selected>Selecione o Grupo</option>   
                                                <?php foreach ($grupos as $v) { ?>
                                                    <option <?= (isset($dadoFinanceiro['id_grupo']) && $dadoFinanceiro['id_grupo'] == $v['id']) ? 'selected' : ''; ?> value="<?= $v['id'] ?>"><?= $v['nome'];?></option>
                                                <?php } ?> 
                                            </select>
                                            <div class="invalid-feedback">Preencha este campo.</div>
                                        </div>


                                        <div class="mb-2 col-md-3">
                                            <label class="form-label text-900" for="input-cnpj">CNPJ</label>
                                            <input id="input-cnpj" value="<?= $dadoFinanceiro['cnpj'] ?? '' ?>" class="form-control mascara-cnpj" type="text" name="cnpj" placeholder="Digite o CNPJ" />

                                        </div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label text-900" for="input-razao-social">Razão Social</label>
                                            <input value="<?= $dadoFinanceiro['razao_social'] ?? "" ?>" id="input-razao-social" class="form-control" type="text" name="razao_social" placeholder="Digite a Razão Social" />

                                        </div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label" for="input-telefone">Telefone *</label>
                                            <input value="<?= $dadoFinanceiro['telefone'] ?? "" ?>" id="input-telefone" class="form-control input-obrigatorio mascara-tel" type="text" name="telefone" placeholder="Digite o telefone" />
                                        </div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label" for="input-tipo-cadastro ">Tipo de cadastro *</label>
                                            <select name="select-tipo-cadastro" class="form-select select2" id="input-tipo-cadastro">
                                                <option disabled value="">Selecione o tipo</option>
                                                <option value="1">Pessoa Fisica</option>
                                                <option value="2">Pessoa Juridica</option>
                                            </select>
                                        </div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label text-900" for="input-conta-bancaria">Conta Bancária *</label>
                                            <input value="<?= $dadoFinanceiro['conta_bancaria'] ?? "" ?>" class="mascara-conta-bancaria form-control input-obrigatorio" id="input-conta-bancaria" type="text" name="conta-bancaria" placeholder="Digite a conta bancaria" />
                                        </div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label text-900" for="input-email">Email *</label>
                                            <input value="<?= $dadoFinanceiro['email'] ?? "" ?>" class="form-control input-obrigatorio" id="input-email" type="text" name="email" placeholder="Email" />
                                        </div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label text-900" for="dia-faturamento">Dia de faturamento *</label>
                                            <input value="<?= $dadoFinanceiro['dia_faturamento'] ?? "" ?>" id="dia-faturamento" class="form-control input-obrigatorio dia-faturamento" type="number" name="dia_faturamento" placeholder="Digite o dia de faturamento" />

                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="divisao-localizacao" class="mt-3">Info. Localização</label><br>
                                        <hr>

                                        <div class="mb-2 col-md-2">
                                            <label class="form-label" for="input-cep">CEP *</label>
                                            <input class="form-control input-obrigatorio campo mascara-cep" id="input-cep" type="text" name="cep" value="<?= $dadoFinanceiro['cep'] ?? ''; ?>" placeholder="Insira o CEP">
                                        </div>

                                        <div class="col-md-10"></div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label" for="input-rua">Rua *</label>
                                            <input id="input-rua" class="form-control input-obrigatorio campo" type="text" name="rua" value="<?= $dadoFinanceiro['rua'] ?? ''; ?>" placeholder="Nome da rua">
                                        </div>

                                        <div class="mb-2 col-md-1">
                                            <label class="form-label" for="input-numero">N° *</label>
                                            <input class="form-control input-obrigatorio " type="text" name="numero" id="input-numero" value="<?= $dadoFinanceiro['numero'] ?? ''; ?>" placeholder="Número">
                                        </div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label" for="input-bairro">Bairro *</label>
                                            <input id="input-bairro" class="form-control input-obrigatorio campo" type="text" name="bairro" value="<?= $dadoFinanceiro['bairro'] ?? ''; ?>" placeholder="Bairro">
                                        </div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label" for="input-cidade">Cidade *</label>
                                            <input id="input-cidade" class="form-control input-obrigatorio campo" type="text" name="cidade" value="<?= $dadoFinanceiro['cidade'] ?? ''; ?>" placeholder="Cidade">
                                        </div>

                                        <div class="mb-2 col-md-2">
                                            <label class="form-label" for="input-estado">Estado *</label>
                                            <input disabled id="input-estado" class="form-control input-obrigatorio campo" type="text" name="estado" value="<?= $dadoFinanceiro['estado'] ?? ''; ?>" placeholder="Estado">
                                        </div>

                                        <div class="mb-2 col-md-4">
                                            <label class="form-label text-900" for="input-complemento">Complemento </label>
                                            <textarea value="<?= isset($dadoFinanceiro['complemento']) ? $dadoFinanceiro['complemento'] : "" ?>" rows="1" class="form-control input-residencia" id="input-complemento" type="text" name="complemento" placeholder="Digite o complemento" /></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="divisao-intermedio" class="mt-3">Info. Intermédio</label><br>
                                        <hr>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label text-900" for="input-nome-intermedio">Nome Intermédio</label>
                                            <input value="<?= $dadoFinanceiro['nome_intermedio'] ?? "" ?>" id="input-nome-intermedio" class="form-control" type="text" name="nome-intermedio" placeholder="Nome Intermédio" />
                                        </div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label text-900" for="input-telefone-intermedio">Telefone Intermédio</label>
                                            <input value="<?= $dadoFinanceiro['telefone_intermedio'] ?? "" ?>" class="form-control mascara-tel" type="text" id="input-telefone-intermedio" name="telefone-intermedio" placeholder="Digite o telefone do Intermédio" />
                                        </div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label text-900" for="input-email-intermedio">Email Intermédio</label>
                                            <input value="<?= $dadoFinanceiro['email_intermedio'] ?? "" ?>" class="form-control" id="input-email-intermedio" type="text" name="email-intermedio" placeholder="Email Intermédio" />
                                        </div>

                                        <div class="mb-2 col-md-3">
                                            <label class="form-label text-900" for="input-cpf-intermedio">CPF Intermédio</label>
                                            <input value="<?= $dadoFinanceiro['cpf_intermedio'] ?? "" ?>" id="input-cpf-intermedio" class="form-control mascara-cpf" type="text" name="cpf-intermedio" placeholder="Digite o CPF" />
                                        </div>

                                        <div class="flex-1 pt-2 text-end my-5">
                                            <button type="button" class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraDadosFinanceiros()"><?= $this->uri->segment(3) ? 'Editar Dados Financeiros' : 'Cadastrar Dados Financeiros'; ?>
                                                <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span>
                                            </button>
                                            <div class="spinner-border text-primary load-form d-none" role="status">
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

<div class="content">
    <div class="row mb-9">

        <div class="col-12">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0">
                                <?=$this->uri->segment(3) ? 'Editar Funcionario' : 'Cadastrar Novo Funcionário';?></h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">

                    <div class="p-4 code-to-copy">
                        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

                            <div class="card-body pt-4 pb-0">
                                <div class="tab-pane row" role="tabpanel"
                                    aria-labelledby="bootstrap-wizard-validation-tab2"
                                    id="bootstrap-wizard-validation-tab2">
                                    <form method="post" class="needs-validation" novalidate="novalidate"
                                        data-wizard-form="1">

                                        <input type="hidden" class="input-id"
                                            value="<?= isset($funcionario['id']) ? $funcionario['id'] : "" ?>">
                                        <div class="row mb-4">

                                            <div
                                                class="dz-preview-cover d-flex align-items-center justify-content-center mb-2 mb-md-0 col-md-auto">
                                                <div class="icon-box div-preview avatar avatar-4xl">
                                                    <img class=" image-preview rounded-circle avatar-placeholder"
                                                        src="<?= base_url((isset($funcionario['foto_perfil']) ? 'uploads/funcionarios/perfil/'.$funcionario['foto_perfil'] : 'assets/img/icons/sem_foto.jpg')) ?>"
                                                        data-dz-thumbnail="data-dz-thumbnail">
                                                </div>
                                            </div>

                                            <div class="form-group col-md">
                                                <div class="image-input">
                                                    <input type="file" accept="image/*" class="inputFoto"
                                                        id="imageInput" name="capa">
                                                    <label for="imageInput" class="image-button">
                                                        <h5 class="mb-2"><span
                                                                class="fa-solid fa-upload me-2"></span>Carregar foto de
                                                            perfil</h5>
                                                    </label>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="mb-2 col-md-4">
                                                <label class="form-label text-900"
                                                    for="bootstrap-wizard-validation-wizard-name">Nome*</label>
                                                <input required
                                                    value="<?= isset($funcionario['nome']) ? $funcionario['nome'] : "" ?>"
                                                    class="form-control input-nome" type="text" name="nome"
                                                    placeholder="Nome do funcionario"
                                                    id="bootstrap-wizard-validation-wizard-name" />
                                                <div class="invalid-feedback">Preencha este campo.</div>
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label text-900"
                                                    for="bootstrap-wizard-validation-wizard-cpf">CPF</label>
                                                <input
                                                    value="<?= isset($funcionario['cpf']) ? $funcionario['cpf'] : "" ?>"
                                                    class="form-control input-cpf mascara-cpf" type="text" name="nome"
                                                    placeholder="Digite o CPF" />
                                            </div>


                                            <div class="mb-2 col-md-4">
                                                <label class="form-label" for="basic-form-dob">Data de
                                                    nascimento</label>
                                                <input class="form-control input-data-nascimento"
                                                    value="<?= isset($funcionario['data_nascimento']) ? $funcionario['data_nascimento'] : "" ?>"
                                                    placeholder="dd/mm/yyyy" id="basic-form-dob" type="date">
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label"
                                                    for="bootstrap-wizard-validation-wizard-phone">Telefone</label>
                                                <input
                                                    value="<?= isset($funcionario['telefone']) ? $funcionario['telefone'] : "" ?>"
                                                    class="form-control input-telefone mascara-tel" type="text"
                                                    name="telefone" placeholder="Digite o telefone" />
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <div class="mb-2">
                                                    <label class="form-label text-900">Função</label>
                                                    <select name="id_cargo" class="form-select input-cargo">
                                                        <option value="" selected disabled>Selecione</option>
                                                        <?php foreach($cargos as $c){ ?>
                                                        <option value="<?= $c['id'] ?>"><?= $c['nome'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">Preencha este campo</div>
                                                </div>
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label text-900"
                                                    for="bootstrap-wizard-validation-wizard-name">Salario Base</label>
                                                <input
                                                    value="<?= isset($funcionario['salario_base']) ? $funcionario['salario_base'] : "" ?>"
                                                    class="form-control input-salario mascara-dinheiro" type="text"
                                                    name="salario_base" placeholder="Digite o salário do funcionário"
                                                    id="bootstrap-wizard-validation-wizard-name" />
                                                <div class="invalid-feedback">Preencha este campo.</div>
                                            </div>

                                            <div class="mb-5 col-md-4">
                                                <label class="form-label text-900"
                                                    for="bootstrap-wizard-validation-wizard-name">Residência</label>
                                                <input
                                                    value="<?= isset($funcionario['residencia']) ? $funcionario['residencia'] : "" ?>"
                                                    class="form-control input-residencia" type="text" name="residencia"
                                                    placeholder="Digite o endereço do funcionário"
                                                    id="bootstrap-wizard-validation-wizard-name" />
                                                <div class="invalid-feedback">Preencha este campo.</div>
                                            </div>


                                            <!-- Cadastro de documentos -->



                                            <div class="mb-2 col-md-12">
                                                <h5> Cadastro de documentos</h5>
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label">Upload CNH</label>
                                                <input accept="image/*" id="" class="form-control inputCnh" type="file">
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label" for="basic-form-dob">Data de validade
                                                    (CNH)</label>
                                                <input class="form-control input-data"
                                                    value="<?= isset($funcionario['data_cnh']) ? $funcionario['data_cnh'] : "" ?>"
                                                    placeholder="dd/mm/yyyy" id="basic-form-dob" type="date">
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label">CPF</label>
                                                <input accept="image/*" id="" class="form-control inputCpf" type="file">
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label">ASO</label>
                                                <input accept="image/*" id="" class="form-control inputAso" type="file">
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label">Ficha EPI</label>
                                                <input accept="image/*" id="" class="form-control inputEpi" type="file">
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label">Ficha Registro</label>
                                                <input accept="image/*" id="" class="form-control inputRegistro"
                                                    type="file">
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label">Carteira de Trabalho</label>
                                                <input accept="image/*" id="" class="form-control inputCarteira"
                                                    type="file">
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label">Carteira de Vacinação</label>
                                                <input accept="image/*" id="" class="form-control inputVacinacao"
                                                    type="file">
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label">Certificados</label>
                                                <input accept="image/*" id="" class="form-control inputCertificados"
                                                    type="file">
                                            </div>

                                            <div class="mb-2 col-md-4">
                                                <label class="form-label">Ordem de Serviço</label>
                                                <input accept="image/*" id="" class="form-control inputOrdem"
                                                    type="file">
                                            </div>

                                            <div class="flex-1 text-end my-5">
                                                <button class="btn btn-primary px-6 px-sm-6 btn-envia"
                                                    onclick="cadastraFuncionario()"><?=$this->uri->segment(3) ? 'Editar Funcionario' : 'Cadastrar Funcionario';?>
                                                    <span class="fas fa-chevron-right ms-1"
                                                        data-fa-transform="shrink-3"> </span>
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
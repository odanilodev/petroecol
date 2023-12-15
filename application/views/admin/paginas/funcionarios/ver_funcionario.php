<div class="content">

    <div class="pb-9">
        <div class="row g-0 g-md-4 g-xl-6">
            <div class="col-md-5 col-lg-5 col-xl-4">
                <div class="sticky-leads-sidebar">
                    <div class="lead-details-offcanvas bg-soft scrollbar phoenix-offcanvas phoenix-offcanvas-fixed" id="productFilterColumn">
                        <div class="d-flex justify-content-between align-items-center mb-2 d-md-none">
                            <h3 class="mb-0">Lead Details</h3><button class="btn p-0" data-phoenix-dismiss="offcanvas"><span class="uil uil-times fs-1"></span></button>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center g-3 text-center text-xxl-start">
                                    <div class="col-12 col-xxl-auto">
                                        <div class="avatar avatar-5xl"><img class="rounded-circle" src="<?= $funcionario['foto_perfil'] ? base_url_upload('funcionarios/perfil/' . ($funcionario['foto_perfil'])) : base_url('assets/img/icons/sem_foto.jpg') ?>" alt=""></div>
                                    </div>
                                    <div class="col-12 col-sm-auto flex-1">
                                        <h3 class="fw-bolder mb-2"><?= $funcionario['nome'] ?></h3>
                                        <p class="mb-0">
                                            <?= empty($funcionario['funcao_nome']) ? 'Não Cadastrado' : $funcionario['funcao_nome'] ?>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-5">
                                    <h3>Sobre o funcionário</h3>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="me-2 uil uil-house-user"></span>

                                        <h5 class="text-1000 mb-0">Residência</h5>
                                    </div>
                                    <p class="mb-0 text-800">
                                        <?= empty($funcionario['residencia']) ? 'Não Cadastrado' : $funcionario['residencia'] ?>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-hourglass">
                                        </span>
                                        <h5 class="text-1000 mb-0">Validade da CNH</h5>
                                    </div>
                                    <p class="mb-0 text-800">
                                        <?php
                                        if ($funcionario['data_cnh'] && $funcionario['data_cnh'] != '0000-00-00') {
                                            echo date('d/m/Y', strtotime($funcionario['data_cnh']));
                                        } else {
                                            echo 'Não cadastrado';
                                        }
                                        ?>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-phone">
                                        </span>
                                        <h5 class="text-1000 mb-0">Telefone</h5>
                                    </div>
                                    <p class="mb-0 text-800">
                                        <?= empty($funcionario['telefone']) ? 'Não Cadastrado' : $funcionario['telefone'] ?>
                                    </p>

                                </div>

                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-postcard"></span>
                                        <h5 class="text-1000 mb-0">CPF</h5>
                                    </div>
                                    <p class="mb-0 text-800">
                                        <?= empty($funcionario['cpf']) ? 'Não Cadastrado' : $funcionario['cpf'] ?>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-building"></span>
                                        <h5 class="text-1000 mb-0">Salario Base</h5>
                                    </div>
                                    <p class="mb-0 text-800">
                                        <?= empty($funcionario['salario_base']) ? 'Não Cadastrado' : 'R$' . $funcionario['salario_base'] ?>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-calendar-alt"></span>
                                        <h5 class="text-1000 mb-0">Data de nascimento</h5>
                                    </div>

                                    <p class="mb-0 text-800">
                                        <?php
                                        if ($funcionario['data_nascimento'] && $funcionario['data_nascimento'] != '0000-00-00') {
                                            echo date('d/m/Y', strtotime($funcionario['data_nascimento']));
                                        } else {
                                            echo 'Não cadastrado';
                                        }
                                        ?>
                                    </p>

                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="phoenix-offcanvas-backdrop d-lg-none top-0" data-phoenix-backdrop="data-phoenix-backdrop"></div>
                </div>
            </div>
            <div class="col-md-7 col-lg-7 col-xl-8">
                <div class="lead-details-container">

                    <div class="mb-8">
                        <div class="d-flex justify-content-between align-items-center mb-4" id="scrollspyDeals">
                            <h3>Documentos</h3>
                            <a href="<?= base_url('funcionarios/formulario/' . $this->uri->segment(3)) ?>" class="btn btn-phoenix-secondary px-3 px-sm-5 me-2">
                                <span class="fa-solid fa-edit me-sm-2"></span>
                                <span class="d-none d-sm-inline">Editar </span>
                            </a>

                        </div>

                        <div class="border-top border-bottom border-200" id="leadDetailsTable">
                            <div class="table-responsive scrollbar mx-n1 px-1">
                                <table class="table fs--1 mb-0">
                                    <tbody class="list" id="lead-details-table-body">

                                        <?php
                                        $col_arquivos = [];
                                        $btn_excluir_todos = false;
                                        foreach ($documentos as $v) {
                                            $coluna = "foto_$v";
                                            if ($funcionario[$coluna]) {
                                                $col_arquivos[] = trim($coluna);
                                                $btn_excluir_todos = true;
                                        ?>
                                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                                    <td>
                                                        <h5><?= strtoupper($v) ?></h5>
                                                    </td>
                                                    <td class="type align-right fw-semi-bold py-2 text-end">
                                                        <a download title="Download do documento" href="<?= base_url_upload('funcionarios/') . $v . '/' . $funcionario[$coluna] ?>"><span class="me-5 uil uil-file-download h2 text-dark"></span></a>
                                                        <a href="#" class="" title="Excluir documento" onclick="deletaDocumentoFuncionario(<?= $funcionario['id'] ?>, '<?= htmlspecialchars(json_encode($col_arquivos), ENT_QUOTES, 'UTF-8') ?>')"><span class="me-5 uil uil-ban h2 text-danger"></span></a>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>

                                    </tbody>
                                </table>
                                <?php if ($btn_excluir_todos) { ?>
                                    <a class="my-2" style="margin-right:15px; display:flex; float:right" onclick="deletaDocumentoFuncionario(<?= $funcionario['id'] ?>, '<?= htmlspecialchars(json_encode($col_arquivos), ENT_QUOTES, 'UTF-8') ?>')"><span class="btn btn-danger">Excluir todos</span></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
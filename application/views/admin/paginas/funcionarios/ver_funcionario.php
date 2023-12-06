<div class="content">

    <div class="pb-9">

        <div class="row g-0 g-md-4 g-xl-6">
            <div class="col-md-5 col-lg-5 col-xl-4">
                <div class="sticky-leads-sidebar">
                    <div class="lead-details-offcanvas bg-soft scrollbar phoenix-offcanvas phoenix-offcanvas-fixed"
                        id="productFilterColumn">
                        <div class="d-flex justify-content-between align-items-center mb-2 d-md-none">
                            <h3 class="mb-0">Lead Details</h3><button class="btn p-0"
                                data-phoenix-dismiss="offcanvas"><span class="uil uil-times fs-1"></span></button>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center g-3 text-center text-xxl-start">
                                    <div class="col-12 col-xxl-auto">
                                        <div class="avatar avatar-5xl"><img class="rounded-circle"
                                                src="<?= $funcionario['foto_perfil'] ? base_url('uploads/funcionarios/perfil/' . ($funcionario['foto_perfil'])) : base_url('assets/img/icons/sem_foto.jpg') ?>"
                                                alt=""></div>
                                    </div>
                                    <div class="col-12 col-sm-auto flex-1">
                                        <h3 class="fw-bolder mb-2"><?= $funcionario['nome'] ?></h3>
                                        <p class="mb-0">
                                            <?= empty($funcionario['funcao_nome']) ? 'Não Cadastrado' : $funcionario['funcao_nome']?>
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
                                        <?= empty($funcionario['residencia']) ? 'Não Cadastrado' : $funcionario['residencia']?>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-hourglass">
                                        </span>
                                        <h5 class="text-1000 mb-0">Validade da CNH</h5>
                                    </div>
                                    <p class="mb-0 text-800">
                                        <?php
                                        $data_cnh = $funcionario['data_cnh'];

                                        if (strtotime($data_cnh) !== false) {
                                            echo date('d/m/Y', strtotime($data_cnh));
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
                                        <?= empty($funcionario['telefone']) ? 'Não Cadastrado' : $funcionario['telefone']?>
                                    </p>

                                </div>

                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-1"><span
                                            class="me-2 uil uil-postcard"></span>
                                        <h5 class="text-1000 mb-0">CPF</h5>
                                    </div>
                                    <p class="mb-0 text-800">
                                        <?= empty($funcionario['cpf']) ? 'Não Cadastrado' : $funcionario['cpf']?>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-1"><span
                                            class="me-2 uil uil-building"></span>
                                        <h5 class="text-1000 mb-0">Salario Base</h5>
                                    </div>
                                    <p class="mb-0 text-800">
                                        <?= empty($funcionario['salario_base']) ? 'Não Cadastrado' : 'R$'.$funcionario['salario_base']?>
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-1"><span
                                            class="me-2 uil uil-calendar-alt"></span>
                                        <h5 class="text-1000 mb-0">Data de nascimento</h5>
                                    </div>

                                    <p class="mb-0 text-800">
                                        <?php
                                        $data_nascimento = $funcionario['data_nascimento'];

                                        if (empty($data_nascimento) && strtotime($data_nascimento) !== false) {
                                            echo date('d/m/Y', strtotime($data_nascimento));
                                        } else {
                                            echo 'Não cadastrado';
                                        }
                                        ?>

                                    </p>

                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="phoenix-offcanvas-backdrop d-lg-none top-0"
                        data-phoenix-backdrop="data-phoenix-backdrop"></div>
                </div>
            </div>
            <div class="col-md-7 col-lg-7 col-xl-8">
                <div class="lead-details-container">

                    <div class="mb-8">
                        <div class="d-flex justify-content-between align-items-center mb-4" id="scrollspyDeals">
                            <h2 class="mb-0">Documentos</h2>
                        </div>
                        <div class="border-top border-bottom border-200" id="leadDetailsTable">
                            <div class="table-responsive scrollbar mx-n1 px-1">
                                <table class="table fs--1 mb-0">
                                    <thead>
                                        <tr>
                                            <th class="sort white-space-nowrap align-middle pe-3 ps-0 text-uppercase"
                                                scope="col" data-sort="dealName" style="width:15%; min-width:200px">
                                                Documento</th>

                                            <th class="sort align-middle text-end text-uppercase" scope="col"
                                                data-sort="type" style="width:15%; min-width:140px">Download</th>

                                        </tr>
                                    </thead>
                                    <tbody class="list" id="lead-details-table-body">
                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                            <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a
                                                    class="fw-semi-bold text-primary">CPF</a>
                                            </td>

                                            <!-- Exemplo para o botão de download do CPF -->
                                            <td class="type align-middle fw-semi-bold py-2 text-end">
                                                <a href="<?= base_url('funcionarios/downloadCpf/'). $funcionario['id'] ?>"
                                                    class="badge badge-phoenix fs--2 badge-phoenix-info">Download</a>
                                            </td>

                                        </tr>

                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                            <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a
                                                    class="fw-semi-bold text-primary" href="#!">ASO</a>
                                            </td>

                                            <td class="type align-middle fw-semi-bold py-2 text-end">
                                                <a href="<?= base_url('funcionarios/downloadAso/'). $funcionario['id'] ?>"
                                                    class="badge badge-phoenix fs--2 badge-phoenix-info">Download</a>
                                            </td>

                                        </tr>

                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                            <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a
                                                    class="fw-semi-bold text-primary" href="#!">EPI</a>
                                            </td>

                                            <td class="type align-middle fw-semi-bold py-2 text-end">
                                                <a href="<?= base_url('funcionarios/downloadEpi/'). $funcionario['id'] ?>"
                                                    class="badge badge-phoenix fs--2 badge-phoenix-info">Download</a>
                                            </td>

                                        </tr>


                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                            <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a
                                                    class="fw-semi-bold text-primary" href="#!">Registro</a>
                                            </td>

                                            <td class="type align-middle fw-semi-bold py-2 text-end">
                                                <a href="<?= base_url('funcionarios/downloadRegistro/') . $funcionario['id'] ?>"
                                                    class="badge badge-phoenix fs--2 badge-phoenix-info">Download</a>
                                            </td>

                                        </tr>

                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                            <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a
                                                    class="fw-semi-bold text-primary" href="#!">Carteira de trabalho</a>
                                            </td>

                                            <td class="type align-middle fw-semi-bold py-2 text-end">
                                                <a href="<?= base_url('funcionarios/downloadCarteiraTrabalho/'). $funcionario['id'] ?>"
                                                    class="badge badge-phoenix fs--2 badge-phoenix-info">Download</a>
                                            </td>

                                        </tr>


                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                            <td class="dealName align-middle white-space-nowrap py-2 ps-0">
                                                <a class="fw-semi-bold text-primary" href="">Carteira de
                                                    vacinação</a>
                                            </td>

                                            <td class="type align-middle fw-semi-bold py-2 text-end">
                                                <a href="<?= base_url('funcionarios/downloadCarteiraVacinacao/'). $funcionario['id'] ?>"
                                                    class="badge badge-phoenix fs--2 badge-phoenix-info">Download</a>
                                            </td>

                                        </tr>

                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                            <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a
                                                    class="fw-semi-bold text-primary" href="#!">Certificado</a>
                                            </td>

                                            <td class="type align-middle fw-semi-bold py-2 text-end">
                                                <a href="<?= base_url('funcionarios/downloadCertificado/') . $funcionario['id'] ?>"
                                                    class="badge badge-phoenix fs--2 badge-phoenix-info">Download</a>
                                            </td>

                                        </tr>

                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                                            <td class="dealName align-middle white-space-nowrap py-2 ps-0"><a
                                                    class="fw-semi-bold text-primary" href="#!">Ordem de serviço</a>
                                            </td>

                                            <td class="type align-middle fw-semi-bold py-2 text-end">
                                                <a href="<?= base_url('funcionarios/downloadOrdem/'). $funcionario['id'] ?>"
                                                    class="badge badge-phoenix fs--2 badge-phoenix-info">Download</a>
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
<div class="content">

  <div class="pb-9">
    <div class="row align-items-center justify-content-between g-3 mb-4">
      <div class="col-12 col-md-auto">
        <h2 class="mb-0">Detalhes do Cliente</h2>
      </div>
      <div class="col-12 col-md-auto d-flex">

        <a href="<?= base_url('clientes/formulario/' . $cliente['id'] ?? "") ?>" class="btn btn-phoenix-secondary px-3 px-sm-5 me-2">
          <span class="fa-solid fa-edit me-sm-2"></span>
          <span class="d-none d-sm-inline">Editar </span>
        </a>

        <button class="btn btn-phoenix-danger me-2" onclick="deletaCliente(<?= $cliente['id'] ?>)">
          <span class="fa-solid fa-trash me-2"></span>
          <span>Deletar</span>
        </button>

        <div>

          <button class="btn px-3 btn-phoenix-secondary" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
            <span class="fa-solid fa-ellipsis"></span>
          </button>

          <ul class="dropdown-menu dropdown-menu-end p-0" style="z-index: 9999;">

            <li>
              <a class="dropdown-item" href="<?= base_url('clientes/detalhes/' . $cliente['id']); ?>">
                <span class="text-900 uil uil-eye"></span>
                <span class="text-900"> Visualizar</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="#" onclick="exibirEtiquetasCliente(<?= $cliente['id'] ?>)" data-bs-toggle="modal" data-bs-target="#modalEtiqueta">
                <span class="text-900 uil-pricetag-alt"></span>
                <span class="text-900"> Etiquetas</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="#" onclick="exibirResiduoCliente(<?= $cliente['id'] ?>)" data-bs-toggle="modal" data-bs-target="#modalResiduo">
                <span class="text-900 uil-pricetag-alt"></span>
                <span class="text-900"> Resíduos</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item text-danger" href="<?= base_url('clientes/formulario/' . $cliente['id']) ?>">
                <span class="text-900 uil uil-pen"></span>
                <span class="text-900"> Editar</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item text-danger" href="#" onclick="deletaCliente(<?= $cliente['id'] ?>)">
                <span class="text-900 uil uil-trash"></span>
                <span class="text-900"> Excluir</span>
              </a>
            </li>

          </ul>
        </div>
      </div>
    </div>

    <div class="row g-4 g-xl-6">
      <div class="col-xl-5 col-xxl-4">
        <div class="sticky-leads-sidebar">
          <div class="card mb-3">
            <div class="card-body">
              <div class="row align-items-center g-3">
                <div class="col-12 col-sm-auto flex-1">
                  <h3 class="fw-bolder mb-2 line-clamp-1"><?= ucfirst($cliente['nome']) ?? ""; ?></h3>
                  <p class="fs--1 fw-semi-bold text-900 text mb-4 w-50">
                    <?php echo "{$cliente['rua']}, {$cliente['numero']} {$cliente['bairro']} - {$cliente['cidade']} / {$cliente['estado']}"; ?>
                  </p>

                  <div class="d-md-flex d-xl-block align-items-center justify-content-between mb-5">

                    <div>

                      <?php foreach ($etiquetas as $v) { ?>

                        <span class="badge badge-phoenix badge-phoenix-secondary me-2"><?= $v['nome']; ?></span>

                      <?php } ?>
                    </div>

                  </div>

                  <div class="d-flex align-items-center justify-content-between">
                    <p class="mb-0"> Próxima Coleta</p>
                    <div>

                      <span class="d-inline-block lh-sm me-1" data-feather="clock" style="height:16px;width:16px;"></span>
                      <span class="d-inline-block lh-sm"> 25/10/2023</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h4 class="mb-3">Outras informações</h4>
              <div class="row g-3">
                <div class="col-12">

                  <div class="mb-7">
                    <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                      <div class="col-sm-12 col-xxl-12 border-bottom py-3">
                        <table class="w-100 table-stats">
                          <tr>
                            <td class="py-2">
                              <div class="d-inline-flex align-items-center">
                                <div class="d-flex bg-primary-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                  <span class="text-primary-600 dark__text-primary-300" data-feather="phone" style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Telefone</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <a class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-900" href="tel:<?= $cliente['telefone'] ?>">
                                <?= $cliente['telefone'] ?>
                              </a>
                            </td>
                          </tr>

                          <tr>
                            <td class="py-2">
                              <div class="d-flex align-items-center">
                                <div class="d-flex bg-warning-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                  <span class="text-warning-600 dark__text-warning-300" data-feather="mail" style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Email</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <a class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-900 w-100" href="mailto:<?= $cliente['email'] ?>"><?= $cliente['email'] ?></a>
                            </td>
                          </tr>

                          <?php if ($cliente['cnpj']) { ?>
                            <tr>
                              <td class="py-2">
                                <div class="d-flex align-items-center">
                                  <div class="d-flex bg-primary-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                    <span class="text-primary-600 dark__text-primary-300 far fa-address-card" style="width:16px; height:16px"></span>
                                  </div>
                                  <p class="fw-bold mb-0">CNPJ</p>
                                </div>
                              </td>
                              <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                              <td class="py-2">
                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-sm-0"><?= $cliente['cnpj']; ?></div>
                              </td>
                            </tr>
                          <?php } ?>

                          <tr>
                            <td class="py-2">
                              <div class="d-flex align-items-center">
                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                  <span class="text-info-600 dark__text-info-300 fa-solid fa-clipboard" style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Tipo</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-sm-0"><?= ucfirst($cliente['tipo_negocio']); ?></div>
                            </td>
                          </tr>

                          <tr>
                            <td class="py-2">
                              <div class="d-flex align-items-center">
                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                  <span class="text-info-600 dark__text-success-300 uil-money-stack" style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Pagamento</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-sm-0">Dia <?= $cliente['dia_pagamento']; ?></div>
                            </td>
                          </tr>

                        </table>
                      </div>

                      <div class="col-sm-12 col-xxl-12 border-bottom py-3">
                        <table class="w-100 table-stats">
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                          <tr>
                            <td class="py-2">
                              <div class="d-inline-flex align-items-center">
                                <div class="d-flex bg-success-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                  <span class="text-success-600 dark__text-success-300" data-feather="users" style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Responsável</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0"><?= ucfirst($cliente['nome_responsavel']); ?></div>
                            </td>
                          </tr>
                          <tr>
                            <td class="py-2">
                              <div class="d-flex align-items-center">
                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                  <span class="text-info-600 dark__text-info-300" data-feather="edit" style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Função</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0"><?= ucfirst($cliente['funcao_responsavel']); ?></div>
                            </td>
                          </tr>

                          <tr>
                            <td class="py-2">
                              <div class="d-inline-flex align-items-center">
                                <div class="d-flex bg-primary-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                  <span class="text-primary-600 dark__text-primary-300" data-feather="phone" style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Telefone</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <a class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-900" href="tel:<?= $cliente['telefone_responsavel'] ?>">
                                <?= $cliente['telefone_responsavel'] ?>
                              </a>
                            </td>
                          </tr>
                        </table>
                      </div>

                      <div class="col-sm-12 col-xxl-12 border-bottom py-3 d-none">
                        <table class="w-100 table-stats">
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                          <tr>
                            <td class="py-2">
                              <div class="d-inline-flex align-items-center">
                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                  <span class="text-info-600 dark__text-info-300" data-feather="clock" style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Recipientes</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0"></div>
                            </td>
                          </tr>
                        </table>
                      </div>

                      <div class="col-sm-12 col-xxl-12 border-bottom py-3">
                        <table class="w-100 table-stats">
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                          <tr>
                            <td class="py-2">
                              <div class="d-flex align-items-center">
                                <div class="d-flex bg-warning-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                  <span class="text-warning-600 dark__text-warning-300" data-feather="clock" style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Última coleta</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0"> 12/10/2023</div>
                            </td>
                          </tr>
                        </table>
                      </div>

                      <div class="col-sm-12 col-xxl-12 border-bottom py-3">
                        <table class="w-100 table-stats">
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                          <tr>

                          <td class="py-2">
                              <div class="d-flex align-items-center">
                                  <div class="d-flex bg-success-100 rounded-circle flex-center me-3" style="width:24px; height:24px">
                                      <span class="text-success-600 dark__text-success-300" data-feather="inbox" style="width:16px; height:16px"></span>
                                  </div>
                                  <p class="fw-bold mb-0">Comodato</p>
                                  <input type='hidden' class='alerta-comodato' value="<?= $this->session->flashdata('aviso-comodato') ?>">
                                  <input type='hidden' class='alerta-comodato-deletado' value="<?= $this->session->flashdata('aviso-comodato-deletado') ?>">
                              </div>
                          </td>

                          <?php if (!empty($cliente['comodato'])) : ?>
                              <td class="py-2">
                                  <!-- Botão de Download -->
                                  <a href="<?= base_url_upload('clientes/comodato/'.$cliente['comodato']) ?>" download class="btn btn-phoenix-secondary px-3 px-sm-5 me-2">
                                      <span class="fa-solid fa-download me-sm-2"></span>
                                      <span class="d-none d-sm-inline">Download</span>
                                  </a>
                              </td>
                          <?php endif; ?>

                          <td class="py-2">
                              <!-- Botão de Upload/Modificar -->
                              <?php if (!empty($cliente['comodato'])) : ?>
                                  <a data-bs-toggle="modal" data-bs-target=".modal-comodato" href="#" class="btn btn-phoenix-secondary px-3 px-sm-5 me-2">
                                      <span class="fa-solid fa-upload me-sm-2"></span>
                                      <span class="d-none d-sm-inline">Modificar</span>
                                  </a>
                              <?php else : ?>
                                  <a data-bs-toggle="modal" data-bs-target=".modal-comodato" href="#" class="btn btn-phoenix-secondary px-3 px-sm-5 me-2">
                                      <span class="fa-solid fa-upload me-sm-2"></span>
                                      <span class="d-none d-sm-inline">Cadastrar</span>
                                  </a>
                              <?php endif; ?>
                          </td>

                          </tr>
                        </table>
                      </div>

                      <?php if ($cliente['observacao']) { ?>
                        <div class="col-sm-12 col-xxl-12 py-3">
                          <table class="w-100 table-stats">
                            <tr>
                              <th>
                                <div class="d-flex align-items-center">

                                  <p class="fw-bold mb-0">Observações:
                                    <span class="fw-semi-bold mb-0"><?= $cliente['observacao'] ?></span>
                                  </p>

                                </div>
                              </th>

                            </tr>
                          </table>
                        </div>

                      <?php } ?>

                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-7 col-xxl-8">
        <div class="card mb-5">
          <div class="card-body">
            <div class="row g-4 g-xl-1 g-xxl-3 justify-content-between">

              <div class="col-sm-auto">
                <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-end-sm pe-sm-5">
                  <div class="d-flex bg-info-100 rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px"><span class="text-info-600 dark__text-info-300" data-feather="bar-chart-2" style="width:24px; height:24px"></span></div>
                  <div>
                    <p class="fw-bold mb-1">Frequência de Coleta</p>
                    <h4 class="fw-bolder text-nowrap">
                      <?php
                      if ($cliente['frequencia'] == "Fixo") {
                        echo $cliente['frequencia'] . " <small>(" . $cliente['dia_coleta_fixo'] . ")</small>";
                      } else {
                        echo $cliente['frequencia'];
                      }
                      ?>
                    </h4>
                  </div>
                </div>
              </div>

              <div class="col-sm-auto">
                <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                  <div class="d-flex bg-success-100 rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px">
                    <span class="text-success-600 dark__text-success-300 uil-calendar-alt"></span>
                  </div>
                  <div>
                    <p class="fw-bold mb-1">Agendados</p>
                    <h4 class="fw-bolder text-nowrap"><?= $cliente['atendimentos_agendados'] ?? "0"; ?></h4>
                  </div>
                </div>
              </div>

              <div class="col-sm-auto">
                <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-start-sm ps-sm-5">
                  <div class="d-flex bg-danger-100 rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px">
                    <span class="text-danger-600 dark__text-danger-300" data-feather="alert-triangle" style="width:24px; height:24px"></span>
                  </div>
                  <div>
                    <p class="fw-bold mb-1">Atrasados</p>
                    <h4 class="fw-bolder text-nowrap"><?= $cliente['atendimentos_atrasados'] ?? "0"; ?></h4>
                  </div>
                </div>
              </div>

              <div class="col-sm-auto">
                <div class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-start-sm ps-sm-5">
                  <div class="d-flex bg-success-100 rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0" style="width:32px; height:32px">
                    <span class="text-success-600 dark__text-success-300" data-feather="check-circle" style="width:24px; height:24px"></span>
                  </div>
                  <div>
                    <p class="fw-bold mb-1">Finalizados</p>
                    <h4 class="fw-bolder text-nowrap"><?= $cliente['atendimentos_finalizados'] ?? "0"; ?></h4>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <ul class="nav nav-underline deal-details scrollbar flex-nowrap w-100 pb-1 mb-6 d-none" id="myTab" role="tablist" style="overflow-y: hidden;">
          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link active" id="activity-tab" data-bs-toggle="tab" href="#tab-activity" role="tab" aria-controls="tab-activity" aria-selected="false" tabindex="-1">
              <span class="fa-solid fa-chart-line me-2 tab-icon-color"></span>Activity
            </a>
          </li>

          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link" id="notes-tab" data-bs-toggle="tab" href="#tab-notes" role="tab" aria-controls="tab-notes" aria-selected="false" tabindex="-1">
              <span class="fa-solid fa-clipboard me-2 tab-icon-color"></span>Notes
            </a>
          </li>

          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link" id="meeting-tab" data-bs-toggle="tab" href="#tab-meeting" role="tab" aria-controls="tab-meeting" aria-selected="true">
              <span class="fa-solid fa-video me-2 tab-icon-color"></span>Meeting
            </a>
          </li>

          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link" id="task-tab" data-bs-toggle="tab" href="#tab-task" role="tab" aria-controls="tab-task" aria-selected="true">
              <span class="fa-solid fa-square-check me-2 tab-icon-color"></span>Task
            </a>
          </li>

          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link" id="call-tab" data-bs-toggle="tab" href="#tab-call" role="tab" aria-controls="tab-call" aria-selected="true">
              <span class="fa-solid fa-phone me-2 tab-icon-color"></span>Call
            </a>
          </li>

          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link" id="emails-tab" data-bs-toggle="tab" href="#tab-emails" role="tab" aria-controls="tab-emails" aria-selected="true">
              <span class="fa-solid fa-envelope me-2 tab-icon-color"></span>Emails
            </a>
          </li>

          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link" id="attachments-tab" data-bs-toggle="tab" href="#tab-attachments" role="tab" aria-controls="tab-attachments" aria-selected="true">
              <span class="fa-solid fa-paperclip me-2 tab-icon-color"></span>Attachments
            </a>
          </li>

        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade active show" id="tab-activity" role="tabpanel" aria-labelledby="activity-tab">
            <h2 class="mb-4">Histórico de Coleta</h2>
            <div class="row align-items-center g-3 justify-content-between justify-content-start">
              <div class="col-12 col-sm-auto">
                <div class="search-box mb-2 mb-sm-0">
                  <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                    <input class="form-control search-input search" type="search" placeholder="Buscar" aria-label="Search" />
                    <span class="fas fa-search search-box-icon"></span>

                  </form>
                </div>
              </div>

              <div class="col-auto">
                <button class="btn btn-phoenix-primary px-6">Add Activity</button>
              </div>

            </div>

            <?php foreach ($coletas as $coleta) { ?>

              <div class="border-bottom py-4">

                <div class="d-flex">
                  <div class="d-flex bg-primary-100 rounded-circle flex-center me-3 bg-primary-100" style="width:25px; height:25px">
                    <span class="fa-solid <?= $coleta['coletado'] == 1 ? "dark__text-primary-300 text-primary-600" : "dark__text-danger-300 text-danger-600" ?>  fs--1 fa-clipboard text-primary-600"></span>
                  </div>

                  <div class="flex-1">

                    <div class="d-flex justify-content-between flex-column flex-xl-row mb-2 mb-sm-0">

                      <div class="flex-1 me-2">
                        <h5 class="text-1000 lh-sm"><?= $coleta['coletado'] == 1 ? "Coleta realizada" : "Coleta não realizada" ?>
                          | <span class="fw-semi-bold fs--1"><?= date('d/m/Y', strtotime($coleta['data_coleta'])) ?></span>
                        </h5>

                        <p class="fs--1 mb-0">Por<a class="ms-1" href="#!"><?= $coleta['nome_responsavel'] ?></a></p>
                      </div>

                      <div class="cursor-pointer">
                        <a target="_blank" class="btn btn-phoenix-primary" href="<?= base_url('coletas/certificadoColeta/' . $cliente['id'])?>" title="Baixar Certificado">
                          <span class="fas fa-file-download text-primary"></span>
                        </a>
                      </div>

                    </div>
                    
                    <p class="fs--1 mb-0"><?= $coleta['observacao'] ?></p>
                  </div>

                </div>

              </div>

            <?php } ?>

          </div>


        </div>
      </div>
    </div>
  </div>

  <!-- Modal cadastro comodato -->
  <div class="modal fade modal-comodato" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Anexar arquivo de comodato</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <p>Caso já contenha um arquivo cadastrado, ele será substituído.</p>
                  <form action="<?= base_url('clientes/cadastraComodato'); ?>" method="post" enctype="multipart/form-data" id="comodatoForm">
                      <div class="mb-3">
                          <label for="fileInput" class="form-label">Escolha um arquivo:</label>
                          <input type="file" class="form-control" id="fileInput" name="comodato">
                          <input type="hidden" class="form-control" value='<?= $cliente['id'] ?>' name="id">
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                          <?php if (!empty($cliente['comodato'])) : ?>
                              <!-- Botão de Deletar -->
                              <a href="<?= base_url('clientes/deletaComodato/'.$cliente['id'].'/'.urlencode($cliente['comodato'])) ?>" class="btn btn-danger">Deletar</a>
                          <?php endif; ?>
                          <button type="submit" class="btn btn-primary">Enviar</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

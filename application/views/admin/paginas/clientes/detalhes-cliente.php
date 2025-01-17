<div class="content">

  <div class="pb-9">
    <div class="row align-items-center justify-content-between g-3 mb-4">
      <div class="col-12 col-md-auto">
        <h2 class="mb-0">Detalhes do Cliente</h2>
      </div>
      <div class="col-12 col-md-auto d-flex">

        <a href="<?= base_url('clientes/formulario/' . $cliente['id'] ?? "") ?>"
          class="btn btn-phoenix-secondary px-3 px-sm-5 me-2">
          <span class="fa-solid fa-edit me-sm-2"></span>
          <span class="d-none d-sm-inline">Editar </span>
        </a>

        <button class="btn btn-phoenix-danger me-2" onclick="deletaCliente(<?= $cliente['id'] ?>)">
          <span class="fa-solid fa-trash me-2"></span>
          <span>Excluir Cliente</span>
        </button>

        <div>

          <button class="btn px-3 btn-phoenix-secondary" type="button" data-bs-toggle="dropdown" data-boundary="window"
            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
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
              <a class="dropdown-item text-danger" href="<?= base_url('clientes/formulario/' . $cliente['id']) ?>">
                <span class="text-900 uil uil-pen"></span>
                <span class="text-900"> Editar</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="#" onclick="exibirEtiquetasCliente(<?= $cliente['id'] ?>)"
                data-bs-toggle="modal" data-bs-target="#modalEtiqueta">
                <span class="text-900 uil-pricetag-alt"></span>
                <span class="text-900"> Etiquetas</span>
              </a>
            </li>

            <a class="dropdown-item" href="#" onclick="exibirEmailsCliente(<?= $cliente['id'] ?>)"
              data-bs-toggle="modal" data-bs-target="#modalEmail">
              <span class="text-900 uil-fast-mail"></span>
              <span class="text-900"> Emails</span>
            </a>

            <li>
              <a class="dropdown-item" href="#" onclick="exibirResiduoCliente(<?= $cliente['id'] ?>)"
                data-bs-toggle="modal" data-bs-target="#modalResiduo">
                <span class="text-900 fas fa-recycle"></span>
                <span class="text-900"> Resíduos</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="#" onclick="exibirRecipientesCliente(<?= $cliente['id'] ?>)"
                data-bs-toggle="modal" data-bs-target="#modalRecipiente">
                <span class="text-900 fas fa-boxes"></span>
                <span class="text-900"> Recipientes</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="#" data-bs-toggle="modal"
                onclick="exibirAlertasClientes(<?= $cliente['id'] ?>)" data-bs-target="#modalAlertas">
                <span class="text-900 uil-message"></span>
                <span class="text-900"> Alertas</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="#" onclick="exibirGruposCliente(<?= $cliente['id'] ?>)"
                data-bs-toggle="modal" data-bs-target="#modalGrupoCliente">
                <span class="text-900 uil-users-alt"></span>
                <span class="text-900"> Grupos</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="#" onclick="exibirSetorEmpresaCliente(<?= $cliente['id'] ?>)"
                data-bs-toggle="modal" data-bs-target="#modalSetoresEmpresaCliente">
                <span class="text-900 uil-create-dashboard"></span>
                <span class="text-900"> Setores</span>
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
                  <h3 class="fw-bolder mb-2">
                    <?php if (isset($cliente['cor'])) { ?>
                      <span class="fas fa-certificate pb-1"
                        style="width:16px; height:16px; color: <?= $cliente['cor'] ?>"></span>
                    <?php } ?>
                    <?= ucfirst($cliente['nome']) ?? ""; ?>
                  </h3>
                  <p class="fs--1 fw-semi-bold text-900 text mb-4 w-50">
                    <?php echo "{$cliente['rua']}, {$cliente['numero']} {$cliente['bairro']} - {$cliente['cidade']} / {$cliente['estado']}"; ?>
                  </p>
                  <div class="d-md-flex d-xl-block align-items-center justify-content-between mb-5">


                    <?php if (permissaoComponentes('select-status-clientes')) { ?>
                      <div class="col-md-3 float-end">
                        <select id=""
                          class="form-select select-status me-2 <?= $cliente['status'] == 1 ? 'select-status-ativo' : 'select-status-inativo'; ?>"
                          onchange="alteraStatusCliente(<?= $cliente['id'] ?>)" style="width: 100%; height: 35px;">
                          <option value="1" <?= $cliente['status'] == 1 ? 'selected' : ''; ?>>Ativo</option>
                          <option value="3" <?= $cliente['status'] == 3 ? 'selected' : ''; ?>>Inativo</option>
                        </select>
                      </div>

                    <?php } ?>

                    <div>
                      <?php foreach ($etiquetas_cliente as $v) { ?>
                        <span class="badge badge-phoenix badge-phoenix-secondary me-2"><?= $v['nome']; ?></span>
                      <?php } ?>
                    </div>

                  </div>

                  <p class="mb-0 me-2"></p>

                  <div class="d-flex align-items-center">
                    <span class="d-inline-block lh-sm me-1" data-feather="calendar"
                      style="height:16px;width:16px;"></span>

                    <a href="#" data-bs-toggle="modal" data-bs-target=".modal-proxima-coleta"
                      class="d-inline-block lh-sm">
                      Observação para próxima Coleta
                    </a>
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
                                <div class="d-flex bg-success-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-success-600 dark__text-success-300" data-feather="calendar"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Data de abertura</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-sm-0 text-break">
                                <?= date('d/m/Y', strtotime($cliente['criado_em'])) ?>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td class="py-2">
                              <div class="d-inline-flex align-items-center">
                                <div class="d-flex bg-primary-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-primary-600 dark__text-primary-300" data-feather="phone"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Telefone</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <a class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-900 text-break"
                                href="tel:<?= $cliente['telefone'] ?>">
                                <?= $cliente['telefone'] ?>
                              </a>
                            </td>
                          </tr>

                          <tr>
                            <td class="py-2">
                              <div class="d-flex align-items-center">
                                <div class="d-flex bg-warning-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-warning-600 dark__text-warning-300" data-feather="mail"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Email Principal</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <a class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-900 w-100 text-break"
                                href="mailto:<?= $cliente['email'] ?>"><?= !empty($cliente['email']) ? $cliente['email'] : 'Não cadastrado' ?></a>
                            </td>
                          </tr>

                          <?php if ($cliente['cnpj']) { ?>
                            <tr>
                              <td class="py-2">
                                <div class="d-flex align-items-center">
                                  <div class="d-flex bg-primary-100 rounded-circle flex-center me-3"
                                    style="width:24px; height:24px">
                                    <span class="text-primary-600 dark__text-primary-300 far fa-address-card"
                                      style="width:16px; height:16px"></span>
                                  </div>
                                  <p class="fw-bold mb-0">CNPJ</p>
                                </div>
                              </td>
                              <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                              <td class="py-2">
                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-sm-0 text-break"><?= $cliente['cnpj']; ?>
                                </div>
                              </td>
                            </tr>
                          <?php } ?>

                          <tr>
                            <td class="py-2">
                              <div class="d-flex align-items-center">
                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-info-600 dark__text-info-300 fa-solid fa-clipboard"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Tipo</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-sm-0">
                                <?= ucfirst($cliente['tipo_negocio']); ?>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td class="py-0">
                              <div class="d-flex align-items-center">
                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-info-600 dark__text-info-300 fa-solid fas fa-recycle"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Resíduo | Pagamento</p>
                              </div>
                            </td>
                            <td class="">:</td>
                            <td class="py-0">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-sm-0">
                                <?= $residuosComPagamento ?>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td class="py-2">
                              <div class="d-flex align-items-center">
                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-info-600 dark__text-success-300 uil-chat"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Observação</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-sm-0 "> - </div>
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
                                <div class="d-flex bg-success-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-success-600 dark__text-success-300" data-feather="users"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Responsável</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break">
                                <?= ucfirst($cliente['nome_responsavel']); ?>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="py-2">
                              <div class="d-flex align-items-center">
                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-info-600 dark__text-info-300" data-feather="edit"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Função</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break">
                                <?= ucfirst($cliente['funcao_responsavel']); ?>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td class="py-2">
                              <div class="d-inline-flex align-items-center">
                                <div class="d-flex bg-primary-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-primary-600 dark__text-primary-300" data-feather="phone"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Telefone</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <a class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-900 text-break"
                                href="tel:<?= $cliente['telefone_responsavel'] ?>">
                                <?= $cliente['telefone_responsavel'] ?>
                              </a>
                            </td>
                          </tr>

                          <tr>
                            <td class="py-2">
                              <div class="d-inline-flex align-items-center">
                                <div class="d-flex bg-primary-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-primary-600 dark__text-primary-300 uil-create-dashboard"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Setores</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <a class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-900 text-break">
                                <?= $nomesSetores ?>
                              </a>
                            </td>
                          </tr>

                        </table>
                      </div>

                      <div class="col-sm-12 col-xxl-12 border-bottom py-3 d-none">
                        <table class="w-100 table-stats">

                          <tr>
                            <td class="py-2">
                              <div class="d-inline-flex align-items-center">
                                <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-info-600 dark__text-info-300" data-feather="clock"
                                    style="width:16px; height:16px"></span>
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
                                <div class="d-flex bg-warning-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-warning-600 dark__text-warning-300" data-feather="clock"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Última coleta</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0"><?= $ultima_coleta; ?></div>
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
                                <div class="d-flex bg-success-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-success-600 dark__text-success-300" data-feather="inbox"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Comodato</p>
                                <input type='hidden' class='alerta-comodato'
                                  value="<?= $this->session->flashdata('aviso-comodato') ?>">
                                <input type='hidden' class='alerta-comodato-deletado'
                                  value="<?= $this->session->flashdata('aviso-comodato-deletado') ?>">
                              </div>
                            </td>


                            <td class="py-2">
                              <a data-bs-toggle="modal" data-bs-target=".modal-comodato" href="#"
                                class="btn btn-phoenix-secondary px-3 px-sm-5 me-2">
                                <span class="fa-solid fa-eye me-sm-2"></span>
                                <span class="d-none d-sm-inline">Visualizar</span>
                              </a>
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
                                <div class="d-flex bg-warning-100 rounded-circle flex-center me-3"
                                  style="width:24px; height:24px">
                                  <span class="text-warning-600 dark__text-warning-300 far fa-address-book"
                                    style="width:16px; height:16px"></span>
                                </div>
                                <p class="fw-bold mb-0">Origem de Cadastro</p>
                              </div>
                            </td>
                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                            <td class="py-2">
                              <div class="ps-6 ps-sm-0 fw-semi-bold mb-0">
                                <?= $origemCadastroCliente['NOME_ORIGEM_CADASTRO']; ?>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </div>

                      <?php if ($cliente['observacao'] != ''): ?>
                        <div class="col-sm-12 col-xxl-12 py-3">
                          <table class="w-100 table-stats">
                            <tr>
                              <th>
                                <div class="d-flex align-items-center">
                                  <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                    style="width:24px; height:24px">
                                    <span class="text-info-600 dark__text-success-300 uil-chat"
                                      style="width:16px; height:16px"></span>
                                  </div>
                                  <p class="fw-bold mb-0">Observações:
                                    <span class="justificado fw-semi-bold mb-0 text-break"
                                      style="text-justify"><?= $cliente['observacao'] ?></span>
                                  </p>
                                </div>
                              </th>
                            </tr>
                          </table>
                        </div>
                      <?php endif ?>

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
                <div
                  class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-end-sm pe-sm-5">
                  <div class="d-flex bg-info-100 rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                    style="width:32px; height:32px"><span class="text-info-600 dark__text-info-300"
                      data-feather="bar-chart-2" style="width:24px; height:24px"></span></div>
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
                <div
                  class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                  <div class="d-flex bg-success-100 rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                    style="width:32px; height:32px">
                    <span class="text-success-600 dark__text-success-300 uil-calendar-alt"></span>
                  </div>
                  <div>
                    <p class="fw-bold mb-1">Agendados</p>
                    <h4 class="fw-bolder text-nowrap"><?= $quantidade_agendado; ?></h4>
                  </div>
                </div>
              </div>

              <div class="col-sm-auto">
                <div
                  class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-start-sm ps-sm-5">
                  <div class="d-flex bg-danger-100 rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                    style="width:32px; height:32px">
                    <span class="text-danger-600 dark__text-danger-300" data-feather="alert-triangle"
                      style="width:24px; height:24px"></span>
                  </div>
                  <div>
                    <p class="fw-bold mb-1">Atrasados</p>
                    <h4 class="fw-bolder text-nowrap"><?= $quantidade_atrasado; ?></h4>
                  </div>
                </div>
              </div>

              <div class="col-sm-auto">
                <div
                  class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-start-sm ps-sm-5">
                  <div class="d-flex bg-success-100 rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                    style="width:32px; height:32px">
                    <span class="text-success-600 dark__text-success-300" data-feather="check-circle"
                      style="width:24px; height:24px"></span>
                  </div>
                  <div>
                    <p class="fw-bold mb-1">Finalizados</p>
                    <h4 class="fw-bolder text-nowrap"><?= $quantidade_finalizado; ?></h4>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <ul class="nav nav-underline deal-details scrollbar flex-nowrap w-100 pb-1 mb-6 d-none" id="myTab"
          role="tablist" style="overflow-y: hidden;">
          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link active" id="activity-tab" data-bs-toggle="tab" href="#tab-activity" role="tab"
              aria-controls="tab-activity" aria-selected="false" tabindex="-1">
              <span class="fa-solid fa-chart-line me-2 tab-icon-color"></span>Activity
            </a>
          </li>

          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link" id="notes-tab" data-bs-toggle="tab" href="#tab-notes" role="tab"
              aria-controls="tab-notes" aria-selected="false" tabindex="-1">
              <span class="fa-solid fa-clipboard me-2 tab-icon-color"></span>Notes
            </a>
          </li>

          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link" id="meeting-tab" data-bs-toggle="tab" href="#tab-meeting" role="tab"
              aria-controls="tab-meeting" aria-selected="true">
              <span class="fa-solid fa-video me-2 tab-icon-color"></span>Meeting
            </a>
          </li>

          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link" id="task-tab" data-bs-toggle="tab" href="#tab-task" role="tab" aria-controls="tab-task"
              aria-selected="true">
              <span class="fa-solid fa-square-check me-2 tab-icon-color"></span>Task
            </a>
          </li>

          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link" id="call-tab" data-bs-toggle="tab" href="#tab-call" role="tab" aria-controls="tab-call"
              aria-selected="true">
              <span class="fa-solid fa-phone me-2 tab-icon-color"></span>Call
            </a>
          </li>

          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link" id="emails-tab" data-bs-toggle="tab" href="#tab-emails" role="tab"
              aria-controls="tab-emails" aria-selected="true">
              <span class="fa-solid fa-envelope me-2 tab-icon-color"></span>Emails
            </a>
          </li>

          <li class="nav-item text-nowrap me-2" role="presentation">
            <a class="nav-link" id="attachments-tab" data-bs-toggle="tab" href="#tab-attachments" role="tab"
              aria-controls="tab-attachments" aria-selected="true">
              <span class="fa-solid fa-paperclip me-2 tab-icon-color"></span>Attachments
            </a>
          </li>

        </ul>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade active show" id="tab-activity" role="tabpanel" aria-labelledby="activity-tab">

            <h2 class="mb-6">Histórico de Coleta
              <a href="#" class="btn btn-phoenix-success px-3 px-sm-5 me-2 btn-nova-coleta-cliente"
                style="float: right;" data-bs-toggle="modal" data-bs-target=".modal-cadastrar-coleta">
                <span class="fa-solid fas fa-recycle me-sm-2"></span>
                <span class="d-none d-sm-inline">Nova Coleta </span>
              </a>
            </h2>
            <div class="row align-items-center g-3 justify-content-between justify-content-start">

              <div class="row">

                <div class="col-md-3">
                  <input autocomplete="off" class="form-control datetimepicker data-inicio-coleta" required
                    name="data_coleta_inicio" type="text" placeholder="Data Inicio"
                    data-options='{"disableMobile":true,"allowInput":true}' style="cursor: pointer;" />

                </div>

                <div class="col-md-3">

                  <input autocomplete="off" class="form-control datetimepicker data-fim-coleta" required
                    name="data_coleta_fim" type="text" placeholder="Data Fim"
                    data-options='{"disableMobile":true,"allowInput":true}' style="cursor: pointer;" />

                </div>

                <div class="col-md-3">

                  <select class="form-select w-100 select2 id-residuo-coleta" name="residuos">

                    <option disabled selected value="">Residuos</option>
                    <option value="">Todos</option>
                    <?php foreach ($residuos as $v) { ?>
                      <option value="<?= $v['id'] ?>"><?= $v['nome']; ?></option>
                    <?php } ?>

                  </select>
                </div>

                <div class="col-2">

                  <button onclick="detalhesHistoricoColetaMassa(<?= $cliente['id'] ?>)"
                    class="btn btn-phoenix-primary px-6">Filtrar</button>

                </div>

              </div>

              <?php foreach ($coletas as $coleta) { ?>

                <div class="border-bottom py-4">

                  <div class="d-flex">
                    <div class="d-flex bg-primary-100 rounded-circle flex-center me-3 bg-primary-100"
                      style="width:25px; height:25px">
                      <span
                        class="fa-solid <?= $coleta['coletado'] == 1 ? "dark__text-primary-300 text-primary-600" : "dark__text-danger-300 text-danger-600" ?>  fs--1 fa-clipboard text-primary-600"></span>
                    </div>

                    <div class="flex-1">

                      <div class="d-flex justify-content-between flex-column flex-xl-row mb-2 mb-sm-0">

                        <div class="flex-1 me-2">
                          <h5 class="text-1000 lh-sm">
                            <?php
                            if ($coleta['coletado'] == 1) {
                              $setor = $coleta['SETOR_COLETA'] ? $coleta['SETOR_COLETA'] : $coleta['SETOR_NOVA_COLETA'];
                              echo "Coleta realizada" . ($setor ? " ($setor)" : "");
                            } else {
                              echo "Coleta não realizada";
                            }
                            ?>


                            | <span
                              class="fw-semi-bold fs--1"><?= date('d/m/Y', strtotime($coleta['data_coleta'])) ?></span>
                          </h5>

                          <p class="fs--1 mb-0">Por<a class="ms-1" href="#!"><?= $coleta['nome_responsavel'] ?></a></p>
                        </div>

                        <button class="btn px-3 btn-phoenix-secondary" type="button" data-bs-toggle="dropdown"
                          data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                          <span class="fa-solid fa-ellipsis"></span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end p-0" style="z-index: 9999;">

                          <li>
                            <a href="#" class="dropdown-item cursor-pointer"
                              onclick="emailsCertificadoColeta(<?= $coleta['ID_COLETA'] ?>, <?= $this->uri->segment(3) ?>)"
                              title="Enviar Certificado" data-bs-toggle="modal"
                              data-bs-target=".modal-certificado-coleta">
                              <span class="text-900 ui uil-message"></span>
                              <span class="text-900"> Enviar Certificado</span>
                            </a>
                          </li>

                          <li>
                            <a class="dropdown-item cursor-pointer"
                              onclick="detalhesHistoricoColeta(<?= $coleta['ID_COLETA'] ?>)" title="Ver Detalhes"
                              data-bs-toggle="modal" data-bs-target=".modal-historico-coleta">
                              <span class="text-900 fas fa-eye"></span>
                              <span class="text-900"> Ver Detalhes</span>
                            </a>
                          </li>

                          <li>
                            <a class="dropdown-item cursor-pointer"
                              onclick="recebeDadosColeta(<?= $coleta['ID_COLETA'] ?>, <?= $this->uri->segment(3) ?>)"
                              title="Editar Coleta" data-bs-toggle="modal" data-bs-target=".modal-editar-coleta">
                              <span class="text-900 fas fa-pencil"></span>
                              <span class="text-900"> Editar Coleta</span>
                            </a>
                          </li>

                          <li>
                            <a class="dropdown-item cursor-pointer"
                              onclick="deletaColeta(<?= $coleta['ID_COLETA'] ?>, <?= $this->uri->segment(3) ?>)"
                              title="Deletar Coleta">
                              <span class="text-900 fas fa-trash-alt"></span>
                              <span class="text-900"> Deletar Coleta</span>
                            </a>
                          </li>

                      </div>

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
            <h5 class="modal-title">Arquivos de Comodato</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Cadastre aqui novos comodatos.</p>
            <form action="<?= base_url('ComodatoCliente/cadastraComodato'); ?>" method="post"
              enctype="multipart/form-data" id="comodatoForm">
              <div class="mb-3">
                <label for="fileInput" class="form-label">Escolha um arquivo:</label>
                <input type="file" class="form-control" id="fileInput" name="comodato">
                <input type="hidden" class="form-control" value='<?= $cliente['id'] ?>' name="id">
              </div>
              <div class="mb-3">
                <label class="form-label">Arquivos existentes:</label>
                <?php if (!empty($comodatos)): ?>
                  <ul class="list-group">
                    <?php foreach ($comodatos as $comodato): ?>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= strlen($comodato['comodato']) > 20 ? substr($comodato['comodato'], 0, 20) . '...' : $comodato['comodato'] ?>
                        <div class="btn-group">
                          <a href="<?= base_url('ComodatoCliente/deletaComodato/' . $comodato['id'] . '/' . urlencode($comodato['comodato']) . '/' . $cliente['id']) ?>"
                            class="btn btn-danger">Deletar</a>
                          <a href="<?= base_url_upload('clientes/comodato/' . $comodato['comodato']) ?>"
                            class="btn btn-primary" download>Baixar</a>
                        </div>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php else: ?>
                  <p>Nenhum arquivo cadastrado.</p>
                <?php endif; ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Enviar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal próxima coleta -->
    <div class="modal fade modal-proxima-coleta" tabindex="-1" id="modalProximaColeta">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Adicionar observação</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="observacao" class="form-label">Observação:</label>
              <textarea class="form-control input-obrigatorio-obs" id="observacao" name="observacao" rows="3"
                required><?= $cliente['observacao_coleta'] ?? "" ?></textarea>
              <div class="aviso-obrigatorio d-none">Preencha este campo.</div>
            </div>
            <div class="modal-footer">
              <input type="hidden" class="id-cliente" value="<?= $this->uri->segment(3) ?>">
              <div class="spinner-border text-primary load-form d-none" role="status"></div>
              <button type="button" class="btn btn-secondary btn-form" data-bs-dismiss="modal">Fechar</button>
              <button type="button" class="btn btn-primary btn-form" onclick="salvarObsProximaColeta()">Enviar</button>
            </div>
          </div>
        </div>
      </div>
    </div>




    <!-- Modal detalhes da coleta -->
    <div class="modal fade modal-historico-coleta" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Histórico de Coleta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body body-coleta">

            <div class="card">
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-12">
                    <div class="mb-3">
                      <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">
                        <div class="col-sm-12 col-xxl-12 border-bottom py-3">
                          <table class="w-100 table-stats">

                            <tr class="div-cod-romaneio d-none">
                              <td class="py-2">
                                <div class="d-inline-flex align-items-center">
                                  <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                    style="width:24px; height:24px">
                                    <span class="text-info-600 dark__text-info-300 fas fa-barcode"
                                      style="width:16px; height:16px"></span>
                                  </div>
                                  <p class="fw-bold mb-0">Código do Romaneio</p>
                                </div>
                              </td>
                              <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                              <td class="py-2">
                                <div
                                  class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break codigo-romaneio html-clean">
                                  <!-- JS -->
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td class="py-2">
                                <div class="d-inline-flex align-items-center">
                                  <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                    style="width:24px; height:24px">
                                    <span class="text-info-600 dark__text-info-300" data-feather="calendar"
                                      style="width:16px; height:16px"></span>
                                  </div>
                                  <p class="fw-bold mb-0">Data da coleta</p>
                                </div>
                              </td>
                              <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                              <td class="py-2">
                                <div
                                  class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break data-coleta html-clean">
                                  <!-- JS -->
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td class="py-2">
                                <div class="d-inline-flex align-items-center">
                                  <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                    style="width:24px; height:24px">
                                    <span class="text-info-600 dark__text-info-300" data-feather="users"
                                      style="width:16px; height:16px"></span>
                                  </div>
                                  <p class="fw-bold mb-0">Responsável</p>
                                </div>
                              </td>
                              <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                              <td class="py-2">
                                <div
                                  class="ps-6 ps-sm-0 fw-semi-bold mb-0 pb-3 pb-sm-0 text-break responsavel-coleta html-clean">
                                  <!-- JS -->
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td class="py-2">
                                <div class="d-inline-flex align-items-center">
                                  <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                    style="width:24px; height:24px">
                                    <span class="fas fa-recycle text-info-600 dark__text-info-300"
                                      style="width:16px; height:16px"></span>
                                  </div>
                                  <p class="fw-bold mb-0">Resíduos Coletados</p>
                                </div>
                              </td>
                              <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                              <td class="py-2">

                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break residuos-coletados html-clean">
                                  <!-- JS -->
                                </div>

                              </td>
                            </tr>

                            <tr>
                              <td class="py-2">
                                <div class="d-inline-flex align-items-center">
                                  <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                    style="width:24px; height:24px">
                                    <span class="text-info-600 dark__text-info-300 fas fa-money-check-alt"
                                      style="width:16px; height:16px"></span>
                                  </div>
                                  <p class="fw-bold mb-0">Total Pago</p>
                                </div>
                              </td>
                              <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                              <td class="py-2">

                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break total-pago html-clean">
                                  <!-- JS -->
                                </div>

                              </td>
                            </tr>

                            <tr class="tr-observacao-coleta d-none">
                              <td class="py-2">
                                <div class="d-inline-flex align-items-center">
                                  <div class="d-flex bg-info-100 rounded-circle flex-center me-3"
                                    style="width:24px; height:24px">
                                    <span class="text-info-600 dark__text-info-300 fas fa-message"
                                      style="width:16px; height:16px"></span>
                                  </div>
                                  <p class="fw-bold mb-0">Observação</p>
                                </div>
                              </td>
                              <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                              <td class="py-2">

                                <div class="ps-6 ps-sm-0 fw-semi-bold mb-0 text-break observacao-coleta html-clean">
                                  <!-- JS -->
                                </div>

                              </td>
                            </tr>

                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">

            <div class="col-sm-12 col-xxl-12 border-bottom py-3">
              <div class="mb-2">
                <label class="form-label text-900">Modelo do Certificado</label>
                <select name="modelo-certificado" class="form-select select-modelo-certificado">
                  <option value="" selected disabled>Selecione</option>

                  <?php foreach ($modelos_certificado as $modelo) { ?>
                    <option data-personalizado="<?= $modelo['personalizado'] ?>" value="<?= $modelo['id'] ?>">
                      <?= $modelo['modelo'] ?>
                    </option>
                  <?php } ?>
                </select>
                <div class="invalid-feedback">Preencha este campo</div>
              </div>
            </div>

            <input type="hidden" class="input-id-coleta">
            <input type="hidden" class="input-id-cliente">
            <button class="btn btn-primary btn-salva-etiqueta btn-form btn-gerar-certificado" type="button">
              <i class="uil-eye"></i>
              Baixar Certificado
            </button>
            <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

          </div>
        </div>
      </div>
    </div>

    <!-- Modal detalhes da coleta -->
    <div class="modal fade modal-certificado-coleta" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Certificado de Coleta - <span class="data-coleta-certificado"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body body-coleta">

            <div class="card">
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-12">
                    <div class="mb-3">
                      <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">
                        <div class="col-sm-12 col-xxl-12 border-bottom py-3">
                          <div class="table-responsive scrollbar ms-n1 ps-1">
                            <h5 class="mb-3">Selecione algum email para enviar o certificado de coleta.</h5>
                            <table class="table table-sm fs--1 mb-0">

                              <thead>
                                <tr>
                                  <th class="align-left" scope="col" data-sort="nome-etiqueta">
                                    <input
                                      class="form-check-input check-clientes-modal cursor-pointer check-all-element"
                                      type="checkbox" style="margin-right:8px;">
                                    Emails
                                  </th>
                                  <th class="align-middle pe-3"> Grupos</th>
                                </tr>
                              </thead>
                              <tbody class="list emails-cliente">

                                <!-- JS -->

                              </tbody>

                            </table>



                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <form action="<?= base_url('coletas/certificadoColeta/') ?>" method="post">

            <div class="modal-footer">

              <div class="col-sm-12 col-xxl-12 border-bottom py-3">
                <div class="mb-2">
                  <label class="form-label text-900">Modelo do Certificado</label>
                  <select required name="modelo" class="form-select select-modelo-certificado">
                    <option value="" selected disabled>Selecione</option>

                    <?php foreach ($modelos_certificado as $modelo) { ?>
                      <option data-personalizado="<?= $modelo['personalizado'] ?>" value="<?= $modelo['id'] ?>">
                        <?= $modelo['modelo'] ?>
                      </option>
                    <?php } ?>
                  </select>
                  <div class="invalid-feedback">Preencha este campo</div>
                  <label class="form-label text-900 mt-3">Número de MTR</label>
                  <input type="text" name="numero_mtr" class="form-control input-mtr"
                    placeholder="Digite o número de MTR" />
                  <div class="invalid-feedback">Preencha este campo</div>

                </div>
              </div>

              <input type="hidden" class="input-id-coleta" name="coleta">
              <input type="hidden" value="<?= $this->uri->segment(3) ?>" name="cliente">
              <input type="hidden" required class="emails-clientes-selecionados" name="emails">
              <input type="hidden" required name="envia-certificado" value="email">

              <button class="btn btn-info btn-salva-etiqueta btn-form btn-gerar-certificado" type="button">
                <i class="uil-eye"></i> Baixar Certificado
              </button>

              <button class="btn btn-success btn-form btn-envia-certificado" type="submit">
                <i class="uil-message"></i> Enviar Certificado
              </button>

              <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>
              <div class="spinner-border text-primary load-form d-none" role="status"></div>

            </div>

          </form>

        </div>
      </div>
    </div>

    <!-- Modal Editar coleta -->
    <div class="modal fade modal-editar-coleta" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Editar Coleta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body body-coleta">

            <div class="card">
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-12">
                    <div class="mb-3">
                      <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                        <div class="mb-4 col-12">
                          <label class="text-body-highlight fw-bold mb-2">Data Coleta</label>
                          <input class="form-control datetimepicker data-coleta-editar cursor-pointer"
                            name="data_coleta" type="text" placeholder="dd/mm/aaaa"
                            data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                          <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                        </div>

                        <div class="mb-4 col-12">
                          <label class="text-body-highlight fw-bold mb-2">Responsável</label>
                          <select class="form-select select2 select-responsavel-editar">
                            <option value="" selected disabled>Selecione</option>
                            <?php foreach ($responsaveis as $responsavel) { ?>
                              <option value="<?= $responsavel['IDFUNCIONARIO'] ?>">
                                <?= $responsavel['nome'] ?>
                              </option>
                            <?php } ?>
                          </select>
                          <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                        </div>
                        <hr>


                        <!-- Residuos e quantidades -->
                        <div class="residuos-coletados-editar">
                          <!-- JS -->
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <input type="hidden" class="input-id-coleta">
            <div class="spinner-border text-primary load-form d-none" role="status"></div>
            <button class="btn btn-info btn-form btn-editar-certificado" onclick="salvarColetaEdit()"
              type="button">Salvar</button>
            <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

          </div>
        </div>
      </div>
    </div>

    <!-- Modal Adicionar nova coleta por cliente -->
    <div class="modal fade modal-cadastrar-coleta" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Nova Coleta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body body-coleta">

            <div class="card">
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-12">
                    <div class="mb-3">
                      <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">

                        <div class="mb-4 col-md-12">
                          <label class="text-body-highlight fw-bold mb-2">Setor Empresa</label>
                          <select class="form-select select2 select-setor-empresa obrigatorio-coleta">
                            <option value="" selected disabled>Selecione</option>
                            <?php foreach ($setoresEmpresa as $setorEmpresa) { ?>
                              <option value="<?= $setorEmpresa['id'] ?>">
                                <?= $setorEmpresa['nome'] ?>
                              </option>
                            <?php } ?>
                          </select>
                          <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                        </div>

                        <div class="mb-4 col-12">
                          <label class="text-body-highlight fw-bold mb-2">Data Coleta</label>
                          <input
                            class="form-control datetimepicker data-coleta-cadastrar cursor-pointer obrigatorio-coleta"
                            name="data_coleta" type="text" placeholder="dd/mm/aaaa"
                            data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' />
                          <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                        </div>

                        <div class="mb-4 col-md-12">
                          <label class="text-body-highlight fw-bold mb-2">Responsável</label>
                          <select class="form-select select2 select-responsavel obrigatorio-coleta">
                            <option value="" selected disabled>Selecione</option>
                            <?php foreach ($responsaveis as $responsavel) { ?>
                              <option value="<?= $responsavel['IDFUNCIONARIO'] ?>">
                                <?= $responsavel['nome'] ?>
                              </option>
                            <?php } ?>
                          </select>
                          <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                        </div>

                        <div class="col-md-5 mb-2 div-pagamento">

                          <label class="form-label">Forma de Pagamento</label>
                          <select class="form-select select-pagamento w-100 select2">

                            <option disabled selected value="">Selecione</option>

                            <?php foreach ($formasPagamento as $v) { ?>
                              <option data-id-tipo-pagamento="<?= $v['TIPO_PAGAMENTO'] ?>" value="<?= $v['id'] ?>">
                                <?= $v['forma_pagamento']; ?>
                              </option>
                            <?php } ?>

                          </select>
                        </div>

                        <div class="col-md-5 mb-2 div-pagamento">

                          <label class="form-label">Valor Pago</label>
                          <input class="form-control input-pagamento" type="text" placeholder="Digite valor pago"
                            value="">
                        </div>

                        <div class="col-md-2 mb-2 mt-4 row">

                          <button class="btn btn-phoenix-success duplicar-pagamento w-25">+</button>

                        </div>

                        <div class="pagamentos-duplicados"></div>
                        <hr class="my-4">

                        <div class="col-md-5 mb-2 div-residuo">

                          <label class="form-label">Resíduo Coletado</label>

                          <select class="form-select select-residuo w-100 select2 obrigatorio-coleta">

                            <option disabled selected value="">Selecione</option>

                            <?php foreach ($residuosSetor as $residuoSetor) { ?>
                              <option value="<?= $residuoSetor['id'] ?>"><?= $residuoSetor['nome']; ?></option>
                            <?php } ?>
                          </select>

                        </div>

                        <div class="col-md-5 mb-2">

                          <label class="form-label">Quantidade Coletada</label>
                          <input class="form-control input-residuo obrigatorio-coleta" data-collapse="0" type="text"
                            placeholder="Digite quantidade coletada" value="">
                        </div>

                        <div class="col-md-2 mb-2 mt-4 row">

                          <button class="btn btn-phoenix-success duplicar-residuo w-25">+</button>

                        </div>

                        <div class="residuos-duplicados"></div>

                        <div class="col-12 mt-4">
                          <label class="form-label">Observação</label>
                          <textarea class="form-control input-obs" id="exampleTextarea" rows="3"></textarea>
                          <div class="text-danger d-none aviso-msg">Preencha este campo.</div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <div class="spinner-border text-primary load-form d-none" role="status"></div>
            <button class="btn btn-info btn-form btn-editar-certificado"
              onclick="cadastraColetaCliente(<?= $this->uri->segment(3); ?>)" type="button">Salvar</button>
            <button class="btn btn-secondary btn-form" type="button" data-bs-dismiss="modal">Fechar</button>

          </div>
        </div>
      </div>
    </div>
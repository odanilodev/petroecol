<div class="content">
  <div class="row mb-9">

    <div class="col-12">
      <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
          <div class="row g-3 justify-content-between align-items-center">
            <div class="col-12 col-md">
              <h4 class="text-900 mb-0">Cadastrar Novo Micro</h4>

            </div>
          </div>
        </div>

        <div class="card-body p-0">
          <div class="accordion" id="accordionExample">
            <div class="accordion-item" style="border: none !important;">
              <div class="accordion-collapse collapse show" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body pt-0">
                  <div class="p-6 code-to-copy">
                    <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">

                      <div class="card-body pt-4 pb-0 row">
                        <input type="hidden" class="input-id" value="<?= $this->uri->segment(3); ?>">

                        <div class="col-md-10 mb-3">
                          <label class="form-label">Nome</label>
                          <input class="form-control input-nome-micro input-obrigatorio" type="text" placeholder="Nome do Micro" value="<?= $micro['nome'] ?? ''; ?>">
                          <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                        </div>

                        <div class="flex-1 text-end my-4">
                          <button class="btn btn-primary px-6 px-sm-6 btn-envia" onclick="cadastraMicro('.input-nome-micro')">Cadastrar
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
          </div>


        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <a href="#" class="btn btn-danger d-none btn-excluir-tudo mx-2" onclick="deletaMicro()"><span class="fas fa-trash"></span> Excluir tudo</a>

      <div class="accordion" id="accordionExample">
        <div class="accordion-item" style="border: none !important;">
          <div class="accordion-collapse collapse show" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body pt-0">
              <div class="p-2 code-to-copy">
                <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
                  <table class="table table-sm fs--1 mb-0">
                    <thead>
                      <tr>
                        <th class="white-space-nowrap fs--1 align-middle ps-0">
                          <!-- Check para todos -->
                          <div class="form-check mb-0 fs-0">
                            <input class="form-check-input check-all-element cursor-pointer" type="checkbox" style="margin-left:0.5em;" />
                          </div>
                        </th>

                        <th class="sort align-middle" scope="col" data-sort="nome-macro">Micro</th>
                        <th class="sort align-middle pe-3">Editar</th>
                        <th class="sort align-middle pe-3">Excluir</th>
                      </tr>
                    </thead>

                    <tbody class="list" id="members-table-body">

                      <?php foreach ($micros as $v) { ?>

                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                          <!-- check para cada um -->
                          <td class="fs--1 align-middle ps-0 py-3">
                            <div class="form-check mb-0 fs-0">
                              <input class="form-check-input check-element cursor-pointer" type="checkbox" value="<?= $v['id'] ?>" style="margin-left:0.5em;" />
                            </div>
                          </td>

                          <td class="nome-macro align-middle white-space-nowrap col-md-6">
                            <?= $v['nome'] ?>
                          </td>

                          <td class="align-middle white-space-nowrap">
                            <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalMicro" onclick="editarMicro(<?= $v['id'] ?>)">
                              <span class="fas fa-pencil ms-1"></span>
                            </a>
                          </td>

                          <td class="align-middle white-space-nowrap">
                            <a href="#" class="btn btn-danger" onclick="deletaMicro(<?= $v['id'] ?>, <?= $this->uri->segment(3) ?>)">
                              <span class="fas fa-trash ms-1"></span>
                            </a>
                          </td>

                        </tr>

                      <?php } ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal de Micros(edição) -->

    <div class="modal fade" id="modalMicro" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Dicionário</h5>
            <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
          </div>
          <div class="modal-body">
            <form method="post" id="form-micro">
              <input type="hidden" class="input-id-micro" value="">

              <div class="row">
                <div class="col-md-12 mb-3">
                  <label class="form-label">Nome Micro</label>
                  <input required class="form-control input-nome-micro-modal input-obrigatorio" required type="text" placeholder="Nome do Micro" value="">
                  <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                </div>
              </div>

            </form>

          </div>

          <div class="modal-footer">

            <div class="spinner-border text-primary load-form d-none" role="status"></div>

            <button class="btn btn-success btn-salva-residuo btn-envia" type="button" onclick="cadastraMicro('.input-nome-micro-modal')">Salvar</button>
          </div>
        </div>
      </div>
    </div>


  </div>
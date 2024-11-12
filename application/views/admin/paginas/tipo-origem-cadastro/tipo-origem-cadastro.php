<div class="content">
  <div id="members" data-list='{"valueNames":["tipo_origem_cadastro"],"page":10,"pagination":true}'>
    <div class="row align-items-center justify-content-between g-3 mb-4">

      <div class="col-auto">
        <div class="d-flex align-items-center">
          <button class="btn btn-link text-900 me-4 px-0 d-none">
            <span class="fa-solid fa-file-export fs--1 me-2"></span>Export
          </button>
          <a href="<?= base_url("tipoOrigemCadastro/formulario/") ?>" class="btn btn-phoenix-primary">
            <span class="fas fa-plus me-2"></span>Cadastrar Tipo Origem Cadastro
          </a>
        </div>
      </div>

      <div class="col col-auto">
        <div class="search-box">
          <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
            <input class="form-control search-input search" type="search" placeholder="Buscar Tipos de Origem de Cadastro" aria-label="Search" />
            <span class="fas fa-search search-box-icon"></span>
          </form>
        </div>
      </div>
    </div>

    <div class="text-center px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
      <div class="table-responsive scrollbar ms-n1 ps-1">
        <table class="table table-sm fs--1 mb-0">
          <thead>
            <tr>
              <th class="white-space-nowrap fs--1 align-middle ps-0">
                <div class="form-check mb-0 fs-0">
                  <input class="form-check-input" id="checkbox-bulk-members-select" type="checkbox" data-bulk-select='{"body":"members-table-body"}' />
                </div>
              </th>
              <th class="sort align-middle" scope="col" data-sort="tipo_origem_cadastro">Tipo Origem Cadastro</th>
              <th class="sort align-middle pe-3">Ações</th>

            </tr>
          </thead>
          <tbody class="list" id="members-table-body">
            <?php foreach ($tiposOrigemCadastros as $tipoOrigemCadastro) { ?>
              <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                <td class="fs--1 align-middle ps-0 py-3">
                  <div class="form-check mb-0 fs-0">
                    <input class="form-check-input" type="checkbox" />
                  </div>
                </td>
                <td class="tipo_origem_cadastro align-middle white-space-nowrap">
                  <?= $tipoOrigemCadastro['nome'] ?>
                </td>
                <td class="align-middle white-space-nowrap text-center pe-0 ">
                  <div class="font-sans-serif btn-reveal-trigger position-static">
                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                      <span class="fas fa-ellipsis-h fs--2"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end py-2">
                      <a href="<?= base_url('tipoOrigemCadastro/formulario/' . $tipoOrigemCadastro['id']) ?>" class="dropdown-item editar-lancamento">
                        <span class="fas fa-pencil"></span> Editar
                      </a>
                      <a class="dropdown-item editar-lancamento" href="#" onclick="deletaTipoOrigemCadastro(<?= $tipoOrigemCadastro['id'] ?>)">
                        <span class="fas fa-trash"></span> Excluir
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
        <div class="col-auto d-none">
          <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p>
          <a class="fw-semi-bold" href="#!" data-list-view="*">Ver todos
            <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
          </a>
          <a class="fw-semi-bold d-none" href="#!" data-list-view="less">Ver menos
            <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
          </a>
        </div>
        <div class="col-auto d-flex w-100 justify-content-end">
          <button class="page-link" data-list-pagination="prev">
            <span class="fas fa-chevron-left"></span>
          </button>
          <ul class="mb-0 pagination"></ul>
          <button class="page-link pe-0" data-list-pagination="next">
            <span class="fas fa-chevron-right"></span>
          </button>
        </div>
      </div>
    </div>
  </div>

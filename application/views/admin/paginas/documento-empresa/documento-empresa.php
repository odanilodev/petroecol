<div class="content">
  <div id="members" data-list='{"valueNames":["nome","validade"],"page":10,"pagination":true}'>
    <div class="row align-items-center justify-content-between g-3 mb-4">

      <div class="col-auto">
        <div class="d-flex align-items-center">
          <button class="btn btn-link text-900 me-4 px-0 d-none"><span class="fa-solid fa-file-export fs--1 me-2"></span>Export</button>
          <a href="<?= base_url("documentoEmpresa/formulario") ?>" class="btn btn-phoenix-primary"><span class="fas fa-plus me-2"></span> Cadastrar Documento</a>
          <a href="#" class="btn btn-danger d-none btn-excluir-tudo mx-2" onclick="deletaDocumentoEmpresa()"><span class="fas fa-trash"></span> Excluir</a>
        </div>

      </div>

      <div class="col col-auto">
        <div class="search-box">
          <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
            <input class="form-control search-input search" type="search" placeholder="Buscar Documento" aria-label="Search" />
            <span class="fas fa-search search-box-icon"></span>
          </form>
        </div>
      </div>
    </div>
    <div class="px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
      <div class="table-responsive scrollbar ms-n1 ps-1">
        <table class="table table-sm fs--1 mb-0" style="padding-left:0;">
          <thead>
            <tr>
              <th class="sort align-middle pe-3 text-center" scope="col" data-sort="nome">Nome</th>
              <th class="sort align-middle pe-3 text-center" scope="col" data-sort="validade">Validade</th>
              <th class="sort align-middle p-0 text-center" scope="col">Visualizar</th>
              <th class="sort align-middle p-0 text-center" scope="col">Download</th>
              <th class="sort align-middle pe-3 text-center" scope="col">Ações</th>
            </tr>
          </thead>

          <tbody class="list" id="members-table-body">

            <?php foreach ($documentos as $documento) {
              $dataAtual = new DateTime(); 
              $dataAtual->setTime(0, 0, 0); // hora como 00:00:00

              $dataLimite = (clone $dataAtual)->modify('+30 days'); // data limite para 30 dias após a data atual

              $etiqueta = '';
              if ($documento['validade'] < $dataAtual->format('Y-m-d')) { //anterior a hoje
                $etiqueta = "text-danger"; 
              } elseif ($documento['validade'] == $dataAtual->format('Y-m-d') || ($documento['validade'] >= $dataAtual->format('Y-m-d') && $documento['validade'] <= $dataLimite->format('Y-m-d'))) { // vence hoje ou dentro de 30 dias
                $etiqueta = "text-warning";
              }
            ?>
              <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                <td class="text-center nome align-middle white-space-nowrap">
                  <h6><?= $documento['nome'] ?></h6>
                </td>

                <td class="text-center validade align-middle white-space-nowrap">
                  <h6 class="<?= $etiqueta ?>"><?= date('d/m/Y', strtotime($documento['validade'])) ?></h6>
                </td>

                <td class="text-center align-middle white-space-nowrap">
                  <button class="btn btn-sm btn-phoenix-secondary bg-white hover-bg-100 action-btn" onclick="visualizarDocumento(<?= $documento['id'] ?>)" data-bs-toggle="modal" data-bs-target="#modalVisualizarDocumento">
                    <span class="fas fa-eye"></span>
                  </button>
                </td>

                <td class="text-center align-middle white-space-nowrap">
                  <button class="btn btn-sm btn-phoenix-success bg-white hover-bg-100 action-btn" onclick="downloadDocumento(<?= $documento['id'] ?>)">
                    <span class="fas fa-download"></span>
                  </button>
                </td>

                <td class="align-middle white-space-nowrap text-end pe-0 text-center">
                  <div class="font-sans-serif btn-reveal-trigger position-static">
                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                      <span class="fas fa-ellipsis-h fs--2"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item" href="<?= base_url('documentoEmpresa/formulario/' . $documento['id']) ?>">
                        <span class="fas fa-pencil"></span> Editar
                      </a>
                      <a class="dropdown-item" href="#" onclick="deletaDocumentoEmpresa(<?= $documento['id'] ?>)">
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
          <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">Ver todos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">Ver menos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
        </div>

        <div class="col-auto d-flex w-100 justify-content-end">
          <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
          <ul class="mb-0 pagination"></ul>
          <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Visualizar Documento -->
  <div class="modal fade" id="modalVisualizarDocumento" tabindex="-1" aria-labelledby="modalVisualizarDocumentoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalVisualizarDocumentoLabel">Visualizar Documento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex flex-column align-items-center">
          <img id="imagemDocumento" src="" class="img-fluid mb-3 d-none" alt="Imagem do Documento" style="width: 100%; height: 700px; object-fit:contain; border-radius: 1em;">
          <div id="avisoDocumento" class="border border-500 p-5 d-none rounded-2" role="alert"></div>
          <a id="downloadDocumento" href="#" class="btn btn-primary mt-3 d-none"><span class="fas fa-download me-2"></span>Download</a>
        </div>
      </div>
    </div>
  </div>
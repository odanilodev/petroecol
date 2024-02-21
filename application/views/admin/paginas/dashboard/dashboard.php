<div class="content">
  <div class="pb-5">
    <div class="row g-4">
      <div class="col-12 col-xxl-6">
        <div class="mb-8">
          <h2 class="mb-2">Dashboard Petroecol</h2>
          <h5 class="text-700 fw-semi-bold">O que está acontecendo neste momento</h5>
        </div>
        <div class="row align-items-center g-4">
        <h3 class="mb-2">Clientes</h2>

          <div class="col-12 col-md-auto">
            <div class="d-flex align-items-center"><span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span class="fa-solid fa-square fa-stack-2x text-success-300" data-fa-transform="down-4 rotate--10 left-4"></span><span class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100" data-fa-transform="up-4 right-3 grow-2"></span><span class="fa-stack-1x fa-solid fa-star text-success " data-fa-transform="shrink-2 up-8 right-6"></span></span>
              <div class="ms-3">
                <h4 class="mb-0"><?= $clientesAtivos ?> - Ativos</h4>
                <p class="text-800 fs--1 mb-0"></p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-auto">
            <div class="d-flex align-items-center"><span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span class="fa-solid fa-square fa-stack-2x text-warning-300" data-fa-transform="down-4 rotate--10 left-4"></span><span class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100" data-fa-transform="up-4 right-3 grow-2"></span><span class="fa-stack-1x fa-solid fa-pause text-warning " data-fa-transform="shrink-2 up-8 right-6"></span></span>
              <div class="ms-3">
                <h4 class="mb-0"><?= $clientesInativados ?> - Inativados este mês</h4>
                <p class="text-800 fs--1 mb-0"></p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-auto">
            <div class="d-flex align-items-center"><span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span class="fa-solid fa-square fa-stack-2x text-danger-300" data-fa-transform="down-4 rotate--10 left-4"></span><span class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100" data-fa-transform="up-4 right-3 grow-2"></span><span class="fa-stack-1x fa-solid fa-xmark text-danger " data-fa-transform="shrink-2 up-8 right-6"></span></span>
              <div class="ms-3">
                <h4 class="mb-0"><?= $clientesInativos ?> - Inativos</h4>
                <p class="text-800 fs--1 mb-0"></p>
              </div>
            </div>
          </div>
        </div>
        <hr class="bg-200 mb-6 mt-4" />
        <div class="row flex-between-center mb-4 g-3">
          <div class="col-auto">
            <h3>Agendamentos</h3>
            <p class="text-700 lh-sm mb-0">Realizados neste mês e no anterior </p>
          </div>
          <div class="col-8 col-sm-4">
            <div class="d-flex align-items-center">
              <select class="form-select form-select-sm ms-2" id="select-gross-revenue-month">
                <option value="" selected disable>Selecione o mês</option>
                <option value="">Janeiro</option>
                <option value="">Fevereiro</option>
                <option value="">Março</option>
                <option value="">Abril</option>
                <option value="">Maio</option>
                <option value="">Junho</option>
                <option value="">Julho</option>
                <option value="">Agosto</option>
                <option value="">Setembro</option>
                <option value="">Outubro</option>
                <option value="">Novembro</option>
                <option value="">Dezembro</option>
              </select>
            </div>
          </div>
        </div>
        <div class="echart-total-sales-chart" style="min-height:320px;width:100%"></div>
      </div>
      <div class="col-12 col-xxl-6">
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <div class="card h-100">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <h5 class="mb-1">Coletas realizadas<span class="badge badge-phoenix badge-phoenix-warning rounded-pill fs--1 ms-2"><span class="badge-label">-6.8%</span></span></h5>
                    <h6 class="text-700">Últimos 7 dias</h6>
                  </div>
                  <h4>247</h4>
                </div>
                <div class="d-flex justify-content-center px-4 py-6">
                  <div class="echart-total-orders" style="height:85px;width:115px"></div>
                </div>
                <div class="mt-2">
                  <div class="d-flex align-items-center mb-2">
                    <div class="bullet-item bg-primary me-2"></div>
                    <h6 class="text-900 fw-semi-bold flex-1 mb-0">Concluídas</h6>
                    <h6 class="text-900 fw-semi-bold mb-0">52%</h6>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="bullet-item bg-primary-100 me-2"></div>
                    <h6 class="text-900 fw-semi-bold flex-1 mb-0">Aguardando pagamento</h6>
                    <h6 class="text-900 fw-semi-bold mb-0">48%</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="card h-100">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <h5 class="mb-1">Novos Clientes<span class="badge badge-phoenix badge-phoenix-warning rounded-pill fs--1 ms-2"> <span class="badge-label">+26.5%</span></span></h5>
                    <h6 class="text-700">Últimos 7 dias</h6>
                  </div>
                  <h4>356</h4>
                </div>
                <div class="pb-0 pt-4">
                  <div class="echarts-new-customers" style="height:180px;width:100%;"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="card h-100">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <h5 class="mb-2">Resíduos Coletados</h5>
                    <h6 class="text-700">Últimos 7 dias</h6>
                  </div>
                </div>
                <div class="pb-4 pt-3">
                  <div class="echart-top-coupons" style="height:115px;width:100%;"></div>
                </div>
                <div>
                  <div class="d-flex align-items-center mb-2">
                    <div class="bullet-item bg-primary me-2"></div>
                    <h6 class="text-900 fw-semi-bold flex-1 mb-0">Óleo</h6>
                    <h6 class="text-900 fw-semi-bold mb-0">72%</h6>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <div class="bullet-item bg-primary-200 me-2"></div>
                    <h6 class="text-900 fw-semi-bold flex-1 mb-0">Papelão</h6>
                    <h6 class="text-900 fw-semi-bold mb-0">18%</h6>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="bullet-item bg-info-500 me-2"></div>
                    <h6 class="text-900 fw-semi-bold flex-1 mb-0">Outros</h6>
                    <h6 class="text-900 fw-semi-bold mb-0">10%</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="card h-100">
              <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between">
                  <div>
                    <h5 class="mb-2">Meta de coletas</h5>
                    <h6 class="text-700">Últimos 7 Dias</h6>
                  </div>
                </div>
                <div class="d-flex justify-content-center pt-3 flex-1">
                  <div class="echarts-paying-customer-chart" style="height:100%;width:100%;"></div>
                </div>
                <div class="mt-3">
                  <div class="d-flex align-items-center mb-2">
                    <div class="bullet-item bg-primary me-2"></div>
                    <h6 class="text-900 fw-semi-bold flex-1 mb-0">Óleo Coletado</h6>
                    <h6 class="text-900 fw-semi-bold mb-0">30%</h6>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="bullet-item bg-primary-100 me-2"></div>
                    <h6 class="text-900 fw-semi-bold flex-1 mb-0">Reciclagem</h6>
                    <h6 class="text-900 fw-semi-bold mb-0">70%</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
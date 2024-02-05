<div class="content">
  <div class="pb-5">
    <div class="row g-4">
      <div class="col-12 col-xxl-6">
        <div class="mb-8">
          <h2 class="mb-2">Petroecol Dashboard</h2>
          <h5 class="text-700 fw-semi-bold">O que esta acontecendo neste momento?</h5>
        </div>
        <div class="row align-items-center g-4">
          <div class="col-12 col-md-4">
            <div class="d-flex align-items-center"><span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span class="fa-solid fa-square fa-stack-2x text-success-300" data-fa-transform="down-4 rotate--10 left-4"></span><span class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100" data-fa-transform="up-4 right-3 grow-2"></span><span class="fa-stack-1x fa-solid fa-star text-success " data-fa-transform="shrink-2 up-8 right-6"></span></span>
              <div class="ms-3">
                <h4 class="mb-0"><?= $agendamentosFinalizados ?> Agendamentos Finalizados</h4>
                <p class="text-800 fs--1 mb-0">-</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="d-flex align-items-center"><span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span class="fa-solid fa-square fa-stack-2x text-warning-300" data-fa-transform="down-4 rotate--10 left-4"></span><span class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100" data-fa-transform="up-4 right-3 grow-2"></span><span class="fa-stack-1x fa-solid fa-pause text-warning " data-fa-transform="shrink-2 up-8 right-6"></span></span>
              <div class="ms-3">
                <h4 class="mb-0"><?= $agendamentosRestantes ?> Agendamentos Restantes</h4>
                <p class="text-800 fs--1 mb-0">-</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="d-flex align-items-center"><span class="fa-stack" style="min-height: 46px;min-width: 46px;"><span class="fa-solid fa-square fa-stack-2x text-danger-300" data-fa-transform="down-4 rotate--10 left-4"></span><span class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100" data-fa-transform="up-4 right-3 grow-2"></span><span class="fa-stack-1x fa-solid fa-xmark text-danger " data-fa-transform="shrink-2 up-8 right-6"></span></span>
              <div class="ms-3">
                <h4 class="mb-0"><?= $agendamentosAtrasados ?> Agendamentos Atrasados</h4>
                <p class="text-800 fs--1 mb-0">-</p>
              </div>
            </div>
          </div>
        </div>
        <hr class="bg-200 mb-6 mt-4" />
        <div class="row flex-between-center mb-4 g-3">
          <div class="col-auto">
            <h3>Agendamentos Mensais do ano de <?= DATE('Y') ?></h3>
            <p class="text-700 lh-sm mb-0">Fluxo de agendamentos do mês</p>
          </div>

        </div>

        <!-- Find the JS file for the following chart at: src/js/charts/echarts/examples/basic-line-chart.js-->
        <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/echarts-example.js-->
        <div class="echart-line-chart-example" style="min-height: 300px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;" _echarts_instance_="ec_1706710728243">
          <div style="position: relative; width: 723px; height: 300px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas data-zr-dom-id="zr_0" width="723" height="300" style="position: absolute; left: 0px; top: 0px; width: 723px; height: 300px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div>
          <div class="" style="position: absolute; display: block; border-style: solid; white-space: nowrap; z-index: 9999999; box-shadow: rgba(0, 0, 0, 0.2) 1px 2px 10px; background-color: rgb(34, 40, 52); border-width: 1px; border-radius: 4px; color: rgb(239, 242, 246); font: 14px / 21px &quot;Microsoft YaHei&quot;; padding: 7px 10px; top: 0px; left: 0px; transform: translate3d(462px, 38px, 0px); border-color: rgb(55, 62, 83); pointer-events: none; visibility: hidden; opacity: 0;">
            <div>
              <h6 class="fs--1 text-700 mb-0">
                <svg class="svg-inline--fa fa-circle me-1" style="color: #85a9ff;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                  <path fill="currentColor" d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z"></path>
                </svg><!-- <span class="fas fa-circle me-1" style="color:#85a9ff"></span> Font Awesome fontawesome.com -->
                October : 1200
              </h6>
            </div>
          </div>
        </div>

      </div>
      <div class="col-12 col-xxl-6">
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <div class="card h-100">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <h5 class="mb-1">Total orders<span class="badge badge-phoenix badge-phoenix-warning rounded-pill fs--1 ms-2"><span class="badge-label">-6.8%</span></span></h5>
                    <h6 class="text-700">Last 7 days</h6>
                  </div>
                  <h4>16,247</h4>
                </div>
                <div class="d-flex justify-content-center px-4 py-6">
                  <div class="echart-total-orders" style="height:85px;width:115px"></div>
                </div>
                <div class="mt-2">
                  <div class="d-flex align-items-center mb-2">
                    <div class="bullet-item bg-primary me-2"></div>
                    <h6 class="text-900 fw-semi-bold flex-1 mb-0">Completed</h6>
                    <h6 class="text-900 fw-semi-bold mb-0">52%</h6>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="bullet-item bg-primary-100 me-2"></div>
                    <h6 class="text-900 fw-semi-bold flex-1 mb-0">Pending payment</h6>
                    <h6 class="text-900 fw-semi-bold mb-0">48%</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-12">
            <div class="card h-100">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <select class="form-select form-select-sm" id="select-gross-revenue-month">
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
                    <h5 class="mb-1">New customers<span class="badge badge-phoenix badge-phoenix-warning rounded-pill fs--1 ms-2"> <span class="badge-label">+26.5%</span></span></h5>


                  </div>
                  <h4>356</h4>
                </div>
                <div class="pb-0 pt-4">
                  <div class="echarts-new-customers" style="height:180px;width:100%;"></div>
                </div>
              </div>
            </div>
          </div>



          <!-- Find the JS file for the following chart at: src/js/charts/echarts/examples/line-log-chart.js-->
          <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/echarts-example.js-->
          <div class="echart-line-log-chart-example" style="min-height: 300px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;" _echarts_instance_="ec_1706895296261">
            <div style="position: relative; width: 723px; height: 300px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas data-zr-dom-id="zr_0" width="723" height="300" style="position: absolute; left: 0px; top: 0px; width: 723px; height: 300px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div>
            <div class="" style="position: absolute; display: block; border-style: solid; white-space: nowrap; z-index: 9999999; box-shadow: rgba(0, 0, 0, 0.2) 1px 2px 10px; background-color: rgb(34, 40, 52); border-width: 1px; border-radius: 4px; color: rgb(102, 102, 102); font: 14px / 21px &quot;Microsoft YaHei&quot;; padding: 7px 10px; top: 0px; left: 0px; transform: translate3d(395px, 85px, 0px); border-color: rgb(55, 62, 83); pointer-events: none; visibility: hidden; opacity: 0;">
              <div>
                <p class="mb-2 text-600">
                  Sep 01
                </p>
                <div class="ms-1">
                  <h6 class="text-700"><svg class="svg-inline--fa fa-circle me-1 fs--2" style="color: #f48270;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                      <path fill="currentColor" d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z"></path>
                    </svg><!-- <span class="fas fa-circle me-1 fs--2" style="color:#f48270"></span> Font Awesome fontawesome.com -->
                    Index Of 3 : 6669
                  </h6>
                </div>
                <div class="ms-1">
                  <h6 class="text-700"><svg class="svg-inline--fa fa-circle me-1 fs--2" style="color: #90d67f;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                      <path fill="currentColor" d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z"></path>
                    </svg><!-- <span class="fas fa-circle me-1 fs--2" style="color:#90d67f"></span> Font Awesome fontawesome.com -->
                    Index of 2 : 256
                  </h6>
                </div>
                <div class="ms-1">
                  <h6 class="text-700"><svg class="svg-inline--fa fa-circle me-1 fs--2" style="color: #60c6ff;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                      <path fill="currentColor" d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z"></path>
                    </svg><!-- <span class="fas fa-circle me-1 fs--2" style="color:#60c6ff"></span> Font Awesome fontawesome.com -->
                    Index of 1/2 : 0.001953125
                  </h6>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
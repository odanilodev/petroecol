$(document).on('click', '.btn-gerar-romaneio-cliente', function () {

  $('.select2').select2({
    dropdownParent: "#modalRomaneiosAtrasados",
    theme: "bootstrap-5",
  });
})

let checkElementsAgendamento = localStorage.getItem('paginacao') ? JSON.parse(localStorage.getItem('paginacao')) : [];

// Atualiza o localStorage e exibe o botão
function atualizarLocalStorage() {
  localStorage.setItem('paginacao', JSON.stringify(checkElementsAgendamento));
  $('.btn-gerar-romaneio-cliente').toggleClass('d-none', checkElementsAgendamento.length === 0);
  $('.contador-gerar-romaneio-cliente').html(`(${checkElementsAgendamento.length})`)

}

// Marcar ou desmarcar checkboxes conforme o localStorage
function sincronizarCheckboxes() {
  $('.check-element-agendamentos').each(function () {
    $(this).prop('checked', checkElementsAgendamento.includes($(this).val()));
  });
}

// Função para resetar tudo (localStorage e checkboxes)
function resetarAgendamentos() {
  localStorage.removeItem('paginacao');
  checkElementsAgendamento = [];
  $('.check-element-agendamentos').prop('checked', false);
  $('.btn-gerar-romaneio-cliente').addClass('d-none'); // Esconde o botão
}

// Verifica se o último parâmetro da URL é "/all"
function verificarResetUrl() {
  var url = window.location.href;
  if (url.endsWith('/all')) {
    resetarAgendamentos();
  }
}

// Manter checkboxes marcados quando carregar a página
$(window).on('load', function () {
  verificarResetUrl();
  sincronizarCheckboxes();
  atualizarLocalStorage();
});

// checkbox para selecionar todos
$(document).on('change', '.check-all-element-agendamentos', function () {
  let marcado = $(this).prop('checked');

  $('.check-element-agendamentos').each(function () {
    let valor = $(this).val();
    $(this).prop('checked', marcado);

    if (marcado) {
      if (!checkElementsAgendamento.includes(valor)) {

        checkElementsAgendamento.push(valor);

      } 
    } else {
      checkElementsAgendamento = checkElementsAgendamento.filter(item => item !== valor);
    }
  });

  atualizarLocalStorage();
});

// checkbox individual
$(document).on('change', '.check-element-agendamentos', function () {
  let valor = $(this).val();
  $(this).prop('checked')
    ? !checkElementsAgendamento.includes(valor) && checkElementsAgendamento.push(valor)
    : checkElementsAgendamento = checkElementsAgendamento.filter(item => item !== valor);

  atualizarLocalStorage();
});


const agruparIdsCheckboxAgendamentos = () => {
  let idsArray = checkElementsAgendamento;

  return idsArray;
}

// Evento para desmarcar checkbox de "check-all" ao mudar de página
$(document).on('click', '[data-list-pagination="next"], [data-list-pagination="prev"], .page', function () {
  $('.check-all-element-agendamentos').prop('checked', false);
});


function gerarRomaneioClientesSemAtividades() {

  let permissao = verificaCamposObrigatorios('input-obrigatorio');
  let idsAgrupados = agruparIdsCheckboxAgendamentos();


  let dataColeta = $('.input-data-agendamento').val();

  let partesData = dataColeta.split('/');

  dataColeta = `${partesData[2]}-${partesData[1]}-${partesData[0]}`;

  let responsavel = $('#select-responsavel').val();
  let setorEmpresa = $('#select-setor').val();
  let veiculo = $('#select-veiculo').val();


  if (permissao) {
    $.ajax({
      type: "POST",
      url: `${baseUrl}romaneios/gerarRomaneio`,
      data: {
        clientes: idsAgrupados,
        responsavel: responsavel,
        veiculo: veiculo,
        setorEmpresa: setorEmpresa,
        data_coleta: dataColeta
      },
      beforeSend: function () {
        $('.load-form').removeClass('d-none');
        $('.btn-form').addClass('d-none');
      },
      success: function (data) {
        $('.load-form').addClass('d-none');
        $('.btn-form').removeClass('d-none');

        if (data.success) {
          Swal.fire({
            title: 'Sucesso!',
            text: data.message,
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Ir para Romaneios',
            cancelButtonText: 'Continuar nesta página'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = `${baseUrl}romaneios/`;
            } else {
              window.location.href = `${baseUrl}clientesSemAtividade/index/`;
            }
          });
        } else {
          avisoRetorno('Erro!', data.message, 'error', '#');
        }
      }, error: function (xhr, status, error) {

        if (xhr.status === 403) {
          avisoRetorno('Algo deu errado!', `Não foi possivel finalizar a operação.`, 'error', '#');
        }
      }
    });
  }
}

$(function () {
  $('.select2').select2({
    theme: "bootstrap-5",
  });
})
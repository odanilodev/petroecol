$(document).on('click', '.btn-gerar-romaneio-cliente', function () {

  $('.select2').select2({
    dropdownParent: "#modalRomaneiosAtrasados",
    theme: "bootstrap-5",
  });
})

let checkElementsAgendamento = [];

// Evento para checkbox de "check-all"
$(document).on('change', '.check-all-element-agendamentos', function () {
  if ($(this).prop('checked')) {
    $('.check-element-agendamentos').prop('checked', true);

    $('.check-element-agendamentos').each(function () {
      if (!checkElementsAgendamento.includes($(this).val())) {
        checkElementsAgendamento.push($(this).val());
      }
    });

    if ($('.check-element-agendamentos:checked').length >= 1) {
      $('.btn-gerar-romaneio-cliente').removeClass('d-none');
    }
  } else {
    $('.check-element-agendamentos').prop('checked', false);
    checkElementsAgendamento = [];
    $('.btn-gerar-romaneio-cliente').addClass('d-none');
  }

});

// Evento para checkbox individual
$(document).on('change', '.check-element-agendamentos', function () {
  let valor = $(this).val();

  if ($(this).prop('checked')) {
    if (!checkElementsAgendamento.includes(valor)) {
      checkElementsAgendamento.push(valor);
    }
  } else {
    checkElementsAgendamento = checkElementsAgendamento.filter(item => item !== valor);
  }

  verificaTodosCheckbox();

  if ($('.check-element-agendamentos:checked').length >= 1) {
    $('.btn-gerar-romaneio-cliente').removeClass('d-none');
  } else {
    $('.btn-gerar-romaneio-cliente').addClass('d-none');
  }
});

// Verifica todos os checkboxes ao carregar a página
$(window).on('load', function () {
  verificaTodosCheckbox();
});

// Verifica se todos os checkboxes individuais estão marcados
function verificaTodosCheckbox() {
  if ($('.check-element-agendamentos:checked').length == $('.check-element-agendamentos').length && $('.check-element-agendamentos').length > 1) {
    $('.check-all-element-agendamentos').prop('checked', true);
    $('.btn-gerar-romaneio-cliente').removeClass('d-none');
  } else {
    $('.check-all-element-agendamentos').prop('checked', false);
  }
}

// Função para capturar todos os ids selecionados
function todosIdsSelecionados(ids) {
  $('.ids-selecionados').val(ids);
}

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
$(document).on('click', '.btn-finalizar-afericao', function () {

    let codRomaneio = $('.codigo-romaneio').val();
    let dadosResiduos = [];
    $('.input-aferido').each(function () {

        if ($(this).val()) {
            dadosResiduos.push({
                idResiduo: $(this).data('id-residuo'),
                qtdColetada: $(this).data('qtd-coletada'),
                setorEmpresa: $(this).data('id-setor-empresa'),
                aferido: $(this).val()
            });
        }

    });
   
    $.ajax({
        type: "post",
        url: `${baseUrl}afericao/salvarAfericao`,
        data: {
            dadosResiduos: dadosResiduos,
            codRomaneio: codRomaneio
        }, beforeSend: function () {
            
        }, success: function (data) {

            let redirect = '#';
            if (data.success) {
                redirect = `${baseUrl}afericao`;
            }

            avisoRetorno(data.title, data.message, data.type, redirect);

        }, error: function (xhr, status, error) {

            if (xhr.status === 403) {
              avisoRetorno('Algo deu errado!', `Você não tem permissão para realizar essa operação!`, 'error', '#');
            }
          }
    })

})

$(document).on('click', '.btn-prestar-contas-afericao', function () {

    $('.id-setor-empresa').val($(this).data('id-setor-empresa'));

    $(`.campos-duplicados`).html('');

    carregaSelect2('select2', 'modalPrestarConta');

    $('.codigo-romaneio').val($(this).data('codigo'));

    $('.nome-funcionario').html($(this).data('funcionario'));
    $('.saldo-funcionario').html(formatarValorMoeda($(this).data('saldo')));

    $('.input-saldo-funcionario').val($(this).data('saldo'));

    $('.id-funcionario').val($(this).data('id-funcionario'));

    $('.total-troco').html('');
    $('.campos-duplicados').html('');
});




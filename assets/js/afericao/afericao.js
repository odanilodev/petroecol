$(document).on('click', '.btn-finalizar-afericao', function () {

    let permissao = verificaCamposObrigatorios('input-obrigatorio');

    if (permissao) {

        let codRomaneio = $('.codigo-romaneio').val();
        let dadosResiduos = [];
        $('.input-aferido').each(function () {

            let selectMedida = $(this).closest('.div-input-aferido').next().find('select');

            if ($(this).val()) {
                dadosResiduos.push({
                    idResiduo: $(this).data('id-residuo'),
                    qtdColetada: $(this).data('qtd-coletada'),
                    setorEmpresa: $(this).data('id-setor-empresa'),
                    idTrajeto: $(this).data('id-trajeto'),
                    aferido: $(this).val(),
                    medida: selectMedida.val()
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

                $('.btn-form').addClass('d-none');
                $('.load-form').removeClass('d-none');

            }, success: function (data) {

                $('.btn-form').removeClass('d-none');
                $('.load-form').addClass('d-none');

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
    }

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


$(document).on('click', '.btn-add-trajeto', function () {

    carregaSelect2('select2', 'modalTrajeto');
    $('.codigo-romaneio').val($(this).data('codigo'));
    $('.select-trajeto').val($(this).data('id-trajeto')).trigger('change');
})

const finalizarTrajetoAfericao = () => {

    let codigoRomaneio = $('.codigo-romaneio').val();
    let idTrajeto = $('.select-trajeto').val();

    $.ajax({
        type: "post",
        url: `${baseUrl}afericao/salvarTrajetoAfericao`,
        data: {
            idTrajeto: idTrajeto,
            codRomaneio: codigoRomaneio
        }, beforeSend: function () {

            $('.btn-form').addClass('d-none');
            $('.load-form').removeClass('d-none');

        }, success: function (data) {

            $('.btn-form').removeClass('d-none');
            $('.load-form').addClass('d-none');

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
}




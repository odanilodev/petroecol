$(document).on('click', '.btn-proximo', function () {
    
    verificaCamposObrigatorios('input-obrigatorio-terceiros');

    if ($('.etapa-pagamento').hasClass('active')) {
        $('.btn-proximo').addClass('btn-finalizar');
    } else {
        $('.btn-proximo').removeClass('btn-finalizar');
    }

})

$(document).on('click', '.btn-finalizar', function () {

    let permissao =  verificaCamposObrigatorios('input-obrigatorio-terceiros');

    if (permissao) {

        let dados = {};
        ['#form-residuo', '#form-afericao', '#form-pagamento'].forEach(form => {
            $(`${form} :input`).each(function () {
                dados[$(this).attr('name')] = $(this).val();
            });
        });

        $.ajax({
            type: "post",
            url: `${baseUrl}afericaoTerceiros/salvarAfericaoTerceiros` ,
            data: {
                dados: dados,
            },
            beforeSend: function () {
                $('.load-form').removeClass('d-none');
                $('.div-btn-modal').addClass('d-none');
            },
            success: function (response) {
                $('.load-form').addClass('d-none');
                $('.div-btn-modal').removeClass('d-none');

                let redirect = response.type == 'success' ? `${baseUrl}/afericaoTerceiros/index/all` : '#';
                avisoRetorno(response.title, response.message, response.type, redirect);

            },
            error: function (xhr, status, error) {
                avisoRetorno(`Erro ${xhr.status}`, `Entre em contato com o administrador.`, 'error', redirect);
            }
        });
    }
    
})

$(document).on('change', '.select-macros', function () {

    let idMacro = $(this).val();

    $.ajax({
        type: "post",
        url: `${baseUrl}finMicro/recebeMicrosMacro`,
        data: {
            idMacro: idMacro
        }, beforeSend: function () {
            $('.select-micros').html('<option disabled selected value="">Selecione</option>');
        }, success: function (data) {

            $('.select-micros').attr('disabled', false);

            for (i = 0; i < data.microsMacro.length; i++) {

                $('.select-micros').append(`<option value="${data.microsMacro[i].id}">${data.microsMacro[i].nome}</option>`);
            }
        }
    })
})


$(document).on('change', '#check-agendar-pagamento', function () {

    if ($(this).is(':checked')) {
        $('.label-data').html('Data de Vencimento');
        $('.label-valor').html('Valor da Conta');
        $('.div-conta-bancaria').addClass('d-none');
        $('.div-forma-pagamento').addClass('d-none');

        $('.select-conta-bancaria').attr('required', false);
        $('.select-conta-bancaria').val('');

        $('.select-forma-pagamento').attr('required', false);
        $('.select-forma-pagamento').val('');

        $('.select-conta-bancaria').removeClass('input-obrigatorio-terceiros');
        $('.select-forma-pagamento').removeClass('input-obrigatorio-terceiros');
    } else {
        $('.label-data').html('Data da Aferição');
        $('.label-valor').html('Valor Pago');
        $('.div-conta-bancaria').removeClass('d-none');
        $('.div-forma-pagamento').removeClass('d-none');
        $('.select-conta-bancaria').attr('required', true);
        $('.select-forma-pagamento').attr('required', true);
        $('.select-conta-bancaria').addClass('input-obrigatorio-terceiros');
        $('.select-forma-pagamento').addClass('input-obrigatorio-terceiros');
    }
})
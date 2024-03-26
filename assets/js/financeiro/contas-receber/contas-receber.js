var baseUrl = $(".base-url").val();

$(document).on('change', '.select-macros', function () {

    let idMacro = $(this).val();

    $.ajax({
        type: "post",
        url: `${baseUrl}finMicro/recebeMicrosMacro`,
        data: {
            idMacro: idMacro
        }, beforeSend: function () {
            $('.select-micros').html('<option value="">Selecione</option>');
        }, success: function (data) {

            $('.select-micros').attr('disabled', false);

            for (i = 0; i < data.microsMacro.length; i++) {

                $('.select-micros').append(`<option value="${data.microsMacro[i].id}">${data.microsMacro[i].nome}</option>`);
            }
        }
    })
})

const receberConta = () => {

    let dadosFormulario = {};
    let permissao = true;

    $(".form-entrada-receber").find(":input").each(function () {

        dadosFormulario[$(this).attr('name')] = $(this).val();

        if ($(this).hasClass('input-obrigatorio') && !$(this).val()) {

            $(this).addClass('invalido');

            // verifica se é select2
            if ($(this).next().hasClass('aviso-obrigatorio')) {

                $(this).next().removeClass('d-none');

            } else {
                $(this).next().next().removeClass('d-none');
                $(this).next().addClass('select2-obrigatorio');
            }

            permissao = false;

        } else {

            $(this).removeClass('invalido');

            if ($(this).next().hasClass('aviso-obrigatorio')) {

                $(this).next().addClass('d-none');

            } else {
                $(this).next().next().addClass('d-none');
                $(this).next().removeClass('select2-obrigatorio');

            }
        }

    })

    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}finContasReceber/cadastraContasReceber`,
            data: {
                dados: dadosFormulario
            }, beforeSend: function () {
                $(".load-form").removeClass("d-none");
                $(".btn-form").addClass("d-none");
            }, success: function (data) {
                $(".load-form").addClass("d-none");
                $(".btn-form").removeClass("d-none");

                avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${baseUrl}finContasReceber`);

            }
        })
    }
}

$(document).on('click', '.novo-lancamento', function () {

    $('.select2').select2({
        dropdownParent: "#modalEntradaContasReceber",
        theme: "bootstrap-5",
    });

})
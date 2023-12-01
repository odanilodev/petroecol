var baseUrl = $('.base-url').val();

$(document).ready(function () {

    $('.btn-romaneio').each(function () {

        let idEtiqueta = $(this).data('id');
        var btnAtual = $(this);  // Armazena a referência para o botão atual

        $.ajax({
            type: "POST",
            url: `${baseUrl}romaneios/verificaRomaneioEtiqueta`,
            data: {
                id: idEtiqueta
            },
            success: function (data) {

                if (data.retorno == false) {
                    btnAtual.attr('disabled', true);
                }

            }
        });
    });

});



$(document).on('click', '.btn-salva-romaneio', function () {

    let idEtiqueta = $('.input-id-etiqueta').val();
    let idMotorista = $('#select-motorista').val();
    let dataRomaneio = $('.data-romaneio').val();

    $('.campo-obrigatorio').each(function () {

        if (!$(this).val()) {
            $(this).addClass('select-validation-invalido');
        }
    })

    if (idMotorista && dataRomaneio) {

        $('.btn-salva-romaneio').addClass('d-none');
        $('.load-form').removeClass('d-none');

        window.location.href = `${baseUrl}romaneios/gerarromaneioetiqueta/${idEtiqueta}/${idMotorista}/${dataRomaneio}`;
    }



})


$(document).on('click', '.btn-romaneio', function () {

    $('.input-id-etiqueta').val($(this).data('id'));

})

$(document).ready(function () {

    $('#select-motorista').select2({
        dropdownParent: "#modalRomaneio",
        theme: 'bootstrap-5' // Aplicar o tema Bootstrap 5
    });

})
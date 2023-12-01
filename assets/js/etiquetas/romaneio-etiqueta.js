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

                    btnAtual.css('pointer-events', 'none');
                    btnAtual.css('background', '#19461A');
                    btnAtual.css('color', '#5B5E66');
                }
    
            }
        });
    });

});


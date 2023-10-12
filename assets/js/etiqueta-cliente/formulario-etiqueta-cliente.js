var baseUrl = $('.base-url').val();

const cadastraEtiquetaCliente = () => {

    let idCliente = $('.id-cliente').val();

    let idEtiqueta = $('#select-etiqueta').val();

    var nomeEtiqueta = [];
    $('#select-etiqueta option:selected').each(function () {
        nomeEtiqueta.push($(this).text());
    });

    if (idEtiqueta != "") {
        permissao = true;
    }

    if (permissao) {
        $.ajax({
            type: "POST",
            url: `${baseUrl}etiquetaCliente/cadastraEtiquetaCliente`,
            data: {
                id_cliente: idCliente,
                id_etiqueta: idEtiqueta,
                nome_etiqueta: nomeEtiqueta
            },
            beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-form').addClass('d-none');

            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');
                
                if (data.success) {

                    $('.div-etiquetas').append(data.message);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');
                    $('.div-etiquetas').append(data.etiqueta);

                }
            }
        })
    }

}

const exibirEtiquetasCliente = (idCliente) => {

    $('.id-cliente').val(idCliente);

    $.ajax({
        type: "POST",
        url: `${baseUrl}etiquetaCliente/recebeEtiquetaCliente`,
        data: {
            id_cliente: idCliente
        },
        beforeSend: function () {
            $('.div-etiquetas').html('');
        },
        success: function (data) {

            if (data) {

                $('.div-etiquetas').html(data);

            }
        }
    })
}


const deletaEtiquetaCliente = (idEtiquetaCliente) => {

    $.ajax({
        type: "POST",
        url: `${baseUrl}etiquetaCliente/deletaEtiquetaCliente`,
        data: {
            id: idEtiquetaCliente
        },
        success: function (data) {

            $(`.etiqueta-${idEtiquetaCliente}`).remove();
        }
    })

}
var baseUrl = $('.base-url').val();

const cadastraEtiquetaCliente = () => {

    let idCliente = $('.id-cliente').val();

    let idEtiqueta = $('#select-etiqueta option:selected').val();

    var nomeEtiqueta = $('#select-etiqueta option:selected').text();

    permissao = true;

    if (!idEtiqueta) {
        permissao = false;

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

                } else if (data.message != undefined) {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                } else {
                    avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação`, 'error', '#');

                }
            }
        })
    }

}


const exibirEtiquetasCliente = (idCliente) => {

    $('#select-etiqueta').val('').trigger('change');

    $('.select2').select2({
        dropdownParent: "#modalEtiqueta",
        theme: "bootstrap-5",
    });

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
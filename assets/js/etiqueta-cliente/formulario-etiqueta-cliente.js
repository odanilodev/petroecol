var baseUrl = $('.base-url').val();

const cadastraEtiquetaCliente = () => {

    let idCliente = $('.btn-salva-etiqueta').data('id-cliente');

    let idEtiqueta = $('#select-etiqueta').val();

    var nomeEtiqueta = [];
    $('#select-etiqueta option:selected').each(function () {
        nomeEtiqueta.push($(this).text());
    });

    if (idEtiqueta != "") {
        permissao = true;
    }

    $.ajax({
        type: "POST",
        url: `${baseUrl}etiquetaCliente/cadastraEtiquetaCliente`,
        data: {
            id_cliente: idCliente,
            id_etiqueta: idEtiqueta,
            nome_etiqueta: nomeEtiqueta
        },
        success: function (data) {
            
            if (data.success) {

                $('.div-etiquetas').append(data.message);


            } else {

                avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

            }
        }
    })

}

const exibirEtiquetasCliente = (idCliente) => {

    $('.btn-salva-etiqueta').attr('data-id-cliente', idCliente);
    
    $.ajax({
        type: "POST",
        url: `${baseUrl}etiquetaCliente/recebeEtiquetaCliente`,
        data: {
            id_cliente: idCliente
        },
        beforeSend: function () {

            $('.load-form').removeClass('d-none');
            $('.titulo-etiqueta').html('');
            $('.div-etiquetas').html('');

        },
        success: function (data) {

            $('.load-form').addClass('d-none');

            if (data) {

                $('.titulo-etiqueta').html('Etiquetas atribuídas: ');
                $('.div-etiquetas').html(data);

            } else {

                $('.titulo-etiqueta').html('Nenhuma etiqueta atribuída');

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
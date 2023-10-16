var baseUrl = $('.base-url').val();

const cadastraResiduoCliente = () => {

    let idCliente = $('.id-cliente').val();

    let idResiduo = $('#select-residuo').val();

    var nomeResiduo = $('#select-residuo').text();

    permissao = true;

    if (!idResiduo) {
        permissao = false;

    }

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}residuoCliente/cadastraResiduoCliente`,
            data: {
                id_cliente: idCliente,
                id_residuo: idResiduo,
                nome_residuo: nomeResiduo
            },
            beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-form').addClass('d-none');

            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');

                if (data.success) {

                    $('.div-residuos').append(data.message);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');
                    $('.div-residuos').append(data.residuo);

                }
            }
        })
    }

}


const exibirResiduoCliente = (idCliente) => {

    $('.id-cliente').val(idCliente);

    $.ajax({
        type: "POST",
        url: `${baseUrl}residuoCliente/recebeResiduoCliente`,
        data: {
            id_cliente: idCliente
        },
        beforeSend: function () {
            $('.div-residuos').html('');
        },
        success: function (data) {

            if (data) {

                $('.div-residuos').html(data);

            }
        }
    })
}


const deletaResiduoCliente = (idResiduoCliente) => {

    $.ajax({
        type: "POST",
        url: `${baseUrl}residuoCliente/deletaResiduoCliente`,
        data: {
            id: idResiduoCliente
        },
        success: function (data) {

            $(`.residuo-${idResiduoCliente}`).remove();
        }
    })

}
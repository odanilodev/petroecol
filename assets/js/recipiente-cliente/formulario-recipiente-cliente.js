var baseUrl = $('.base-url').val();

const cadastraRecipienteCliente = () => {

    let idCliente = $('.id-cliente').val();

    let idRecipiente = $('#select-recipiente').val();

    let quantidade = $('#quantidade-recipiente').val();

    var nomeRecipiente= $('#select-recipiente').text();

    permissao = true;

    if (!idRecipiente || !quantidade) {
        
        permissao = false;

    } else {

        permissao = true;

    }

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}recipienteCliente/cadastraRecipienteCliente`,
            data: {
                id_cliente: idCliente,
                id_recipiente: idRecipiente,
                quantidade: quantidade,
                nome_recipiente: nomeRecipiente
            },
            beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-form').addClass('d-none');

            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');

                if (data.success) {

                    $('.div-recipientes').append(data.message);

                } else if (data.message != undefined) {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                } else {
                    avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação`, 'error', '#');

                }
            }
        })
    }

}


const exibirRecipientesCliente = (idCliente) => {

    $('#quantidade-recipiente').val('');

    $('.id-cliente').val(idCliente);

    $.ajax({
        type: "POST",
        url: `${baseUrl}recipienteCliente/recebeRecipienteCliente`,
        data: {
            id_cliente: idCliente
        },
        beforeSend: function () {
            $('.div-recipientes').html('');
        },
        success: function (data) {

            if (data) {

                $('.div-recipientes').html(data);

            }
        }
    })
}


const deletaRecipienteCliente = (idRecipienteCliente) => {

    $.ajax({
        type: "POST",
        url: `${baseUrl}recipienteCliente/deletaRecipienteCliente`,
        data: {
            id: idRecipienteCliente
        },
        success: function (data) {

            $(`.recipiente-${idRecipienteCliente}`).remove();
        }
    })

}
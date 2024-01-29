var baseUrl = $('.base-url').val();

const cadastraGrupoCliente = () => {

    let idCliente = $('.id-cliente').val();

    let idGrupo = $('#select-grupo-cliente option:selected').val();

    var nomeGrupo = $('#select-grupo-cliente option:selected').text();

    permissao = true;

    if (!idGrupo) {
        permissao = false;

    }

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}grupoCliente/cadastraGrupoCliente`,
            data: {
                id_cliente: idCliente,
                idGrupo: idGrupo,
                nomeGrupo: nomeGrupo
            },
            beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-form').addClass('d-none');

            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');

                if (data.success) {

                    $('.div-grupos').append(data.message);

                } else if (data.message != undefined) {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                } else {
                    avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação`, 'error', '#');

                }
            }
        })
    }

}


const exibirGruposCliente = (idCliente) => {

    $('#select-grupo-cliente').val('').trigger('change');

    $('.select2').select2({
        dropdownParent: "#modalGrupoCliente",
        theme: "bootstrap-5",
    });

    $('.id-cliente').val(idCliente);

    $.ajax({
        type: "POST",
        url: `${baseUrl}grupoCliente/recebeGrupoCliente`,
        data: {
            idCliente: idCliente
        },
        beforeSend: function () {
            $('.div-grupos').html('');
        },
        success: function (data) {

            if (data) {

                $('.div-grupos').html(data);

            }
        }
    })
}


const deletaGrupoCliente = (idGrupoCliente) => {

    $.ajax({
        type: "POST",
        url: `${baseUrl}grupoCliente/deletaGrupoCliente`,
        data: {
            idGrupoCliente: idGrupoCliente
        },
        success: function (data) {

            $(`.grupo-cliente-${idGrupoCliente}`).remove();
        }
    })

}
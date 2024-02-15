var baseUrl = $('.base-url').val();

const cadastraSetorEmpresaCliente = () => {

    let idCliente = $('.id-cliente').val();

    let idSetorEmpresa = $('#select-setor-empresa option:selected').val();

    var nomeSetorEmpresa = $('#select-setor-empresa option:selected').text();

    permissao = true;

    if (!idSetorEmpresa) {
        permissao = false;

    }

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}setoresEmpresaCliente/cadastraSetorEmpresaCliente`,
            data: {
                id_cliente: idCliente,
                id_setor_empresa: idSetorEmpresa,
                nome_setor_empresa: nomeSetorEmpresa
            },
            beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-form').addClass('d-none');

            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');

                if (data.success) {

                    $('.div-setor-empresa').append(data.message);

                } else if (data.message != undefined) {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                } else {
                    avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação`, 'error', '#');

                }
            }
        })
    }

}


const exibirSetorEmpresaCliente = (idCliente) => {

    alert(idCliente)

    $('#select-setor-empresa').val('').trigger('change');

    $('.select2').select2({
        dropdownParent: "#modalSetoresEmpresaCliente",
        theme: "bootstrap-5",
    });


    $('.id-cliente').val(idCliente);

    $.ajax({
        type: "POST",
        url: `${baseUrl}setoresEmpresaCliente/recebeSetoresEmpresaCliente`,
        data: {
            idCliente: idCliente
        },
        beforeSend: function () {
            $('.div-setor-empresa').html('');
        },
        success: function (data) {

            if (data) {

                $('.div-setor-empresa').html(data);

            }
            console.log(data)
            
        }
        
    })
}


const deletaSetorEmpresaCliente = (idSetorEmpresa) => {

    $.ajax({
        type: "POST",
        url: `${baseUrl}setoresEmpresaCliente/deletaSetorEmpresaCliente`,
        data: {
            id: idSetorEmpresa
        },
        success: function (data) {

            $(`.setor-empresa-${idSetorEmpresa}`).remove();
        }
    })

}
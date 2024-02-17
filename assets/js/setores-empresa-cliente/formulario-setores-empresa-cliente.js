var baseUrl = $('.base-url').val();

const cadastraSetorEmpresaCliente = () => {

    let idCliente = $('.id-cliente').val();

    let idSetorEmpresa = $('#select-setor-empresa option:selected').val();

    let idFrequenciaColeta = $('#select-frequencia-coleta-setor option:selected').val();

    var nomeSetorEmpresa = $('#select-setor-empresa option:selected').text();

    let diaFixoSemana = $('.select-dia-fixo option:selected').val();

    permissao = true;

    if (!idSetorEmpresa || !idFrequenciaColeta) {
        permissao = false;
    }

    if (!$('.fixo-coleta').hasClass('d-none') && !diaFixoSemana) {
        permissao = false;
    } 

    // verifica se é para editar ou cadastrar um novo
    let editarSetorEmpresa = 'cadastrando';
    if ($('.input-editar-setor-empresa').val() == "editar") {

        editarSetorEmpresa = 'editando';
    }

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}setoresEmpresaCliente/cadastraSetorEmpresaCliente`,
            data: {
                id_cliente: idCliente,
                idSetorEmpresa: idSetorEmpresa,
                nomeSetorEmpresa: nomeSetorEmpresa,
                idFrequenciaColeta: idFrequenciaColeta,
                diaFixoSemana: diaFixoSemana,
                editarSetorEmpresa: editarSetorEmpresa
            },
            beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-form').addClass('d-none');

            },
            success: function (data) {

                $('#select-setor-empresa').val('').trigger('change');

                $('#select-frequencia-coleta-setor').val('').trigger('change');

                $('.input-editar-setor-empresa').val('');

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');

                if (data.success && !data.editado) {

                    $('.div-setor-empresa').append(data.message);

                } else if (data.success && data.editado) {

                    let novaFuncaoClick = `verSetorEmpresaCliente('${data.nome_setor_empresa}', '${data.id_frequencia_coleta}', '${data.dia_coleta_fixo}')`;

                    $('.edita-setor-empresa-' + data.id_setor_empresa).attr('onclick', novaFuncaoClick);

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

    $('#select-setor-empresa').val('').trigger('change');

    $('#select-frequencia-coleta-setor').val('').trigger('change');

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

$(document).on('change', '.select-frequencia', function () {

    if ($('.select-frequencia option:selected').text() == "Fixo") {

        $('.fixo-coleta').removeClass('d-none');
        $('.select-dia-fixo').attr('required', true);

    } else {

        $('.select-dia-fixo').val('');
        $('.fixo-coleta').addClass('d-none');
        $('.select-dia-fixo').attr('required', false);
    }
})


const verSetorEmpresaCliente = (setorEmpresa, frequenciaColeta) => {

    $('.input-editar-setor-empresa').val('editar');

    let nomeSetorEmpresa = setorEmpresa.toUpperCase(); // deixa o nome com letras minusculas

    let selectSetorEmpresa = $('#select-setor-empresa').find('option').filter(function () {
        return $(this).text().toUpperCase() == nomeSetorEmpresa;
    });

    selectSetorEmpresa.prop('selected', true);
    $('#select-setor-empresa').val(selectSetorEmpresa.val()).trigger('change');
    
    let selectFrequenciaColetaSetor = $('#select-frequencia-coleta-setor').find('option').filter(function () {
        return $(this).val() == frequenciaColeta;
    });

    selectFrequenciaColetaSetor.prop('selected', true);
    $('#select-frequencia-coleta-setor').val(selectFrequenciaColetaSetor.val()).trigger('change');

}
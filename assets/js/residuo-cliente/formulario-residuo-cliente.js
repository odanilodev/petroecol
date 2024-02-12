var baseUrl = $('.base-url').val();

$(document).on('change', '#forma-pagamento-residuo', function () {

    if ($('#forma-pagamento-residuo option:selected').data('id-tipo-pagamento') == "1") {

        $('#valor-pagamento-residuo').attr('type', 'text');

        $('#valor-pagamento-residuo').mask('000.000.000.000.000.00', {reverse: true});
        
        $('#valor-pagamento-residuo').val('');


    } else {

        $('#valor-pagamento-residuo').attr('type', 'number');
        $('#valor-pagamento-residuo').unmask();

    }
})

const cadastraResiduoCliente = () => {

    let idCliente = $('.id-cliente').val();

    let idResiduo = $('#select-residuo option:selected').val();

    var nomeResiduo = $('#select-residuo option:selected').text();

    let idPagamento = $('#forma-pagamento-residuo option:selected').val();

    let valorPagamento = $('#valor-pagamento-residuo').val();

    let idTipoPagamento = $('#forma-pagamento-residuo option:selected').data('id-tipo-pagamento');

    permissao = true;

    if (!idResiduo) {
        permissao = false;

    }

    // verifica se é para editar ou cadastrar um novo
    let editarResiduo = 'cadastrando';
    if ($('.input-editar-residuo').val() == "editar") {

        editarResiduo = 'editando';
    }

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}residuoCliente/cadastraResiduoCliente`,
            data: {
                id_cliente: idCliente,
                id_residuo: idResiduo,
                nome_residuo: nomeResiduo,
                forma_pagamento: idPagamento,
                valor_pagamento: valorPagamento,
                editarResiduo: editarResiduo,
                idTipoPagamento: idTipoPagamento
            },
            beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-form').addClass('d-none');

            },
            success: function (data) {

                $('#select-residuo').val('').trigger('change');

                $('#forma-pagamento-residuo').val('').trigger('change');
                $('#valor-pagamento-residuo').val('');
            
                $('.select2').select2({
                    dropdownParent: "#modalResiduo",
                    theme: "bootstrap-5",
                });
            

                $('.input-editar-residuo').val('');

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');

                if (data.success && !data.editado) {

                    $('.div-residuos').append(data.message);

                } else if (data.success && data.editado) {

                    let novaFuncaoClick = `verResiduoCliente('${data.nome_residuo}', '${data.forma_pagamento}', '${data.valor_pagamento}')`;

                    $('.edita-residuo-' + data.id_residuo).attr('onclick', novaFuncaoClick);

                } else if (data.message != undefined) {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                } else {
                    avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação`, 'error', '#');

                }
                
            }
        })
    }

}


const exibirResiduoCliente = (idCliente) => {

    $('.input-editar-residuo').val('');

    $('#select-residuo').val('').trigger('change');

    $('#forma-pagamento-residuo').val('').trigger('change');
    $('#valor-pagamento-residuo').val('');

    $('.select2').select2({
        dropdownParent: "#modalResiduo",
        theme: "bootstrap-5",
    });

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

const verResiduoCliente = (residuo, formaPagamento, valorPagamento) => {

    $('.input-editar-residuo').val('editar');

    let nomeResiduo = residuo.toUpperCase(); // deixa o nome com letras minusculas

    let selectResiduo = $('#select-residuo').find('option').filter(function () {
        return $(this).text().toUpperCase() == nomeResiduo;
    });

    selectResiduo.prop('selected', true);
    $('#select-residuo').val(selectResiduo.val()).trigger('change');
    
    let selectFormaPagamento = $('#forma-pagamento-residuo').find('option').filter(function () {
        return $(this).val() == formaPagamento;
    });

    selectFormaPagamento.prop('selected', true);
    $('#forma-pagamento-residuo').val(selectFormaPagamento.val()).trigger('change');

    $('#valor-pagamento-residuo').val(valorPagamento);

}
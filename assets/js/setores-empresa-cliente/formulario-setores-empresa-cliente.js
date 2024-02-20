var baseUrl = $('.base-url').val();

    $('.dia-pagamento').on('input', function() {

        let valor = $(this).val().replace(/\D/g, '');

        valor = Math.min(Math.max(parseInt(valor, 10) || 0, ''), 31);

        $(this).val(valor === 0 ? '' : valor);
    });


const cadastraSetorEmpresaCliente = () => {

    let idCliente = $('.id-cliente').val();

    let selectSetorEmpresa = $('.select-nome-setor-empresa option:selected');

    let nomeSetorEmpresa = selectSetorEmpresa.text();
    let idSetorEmpresa = selectSetorEmpresa.val();

    let idFrequenciaColeta = $('.select-frequencia-coleta-setor option:selected').val();

    let diaFixoSemana = $('.select-dia-fixo option:selected').val();
    
    let transacaoColeta = $('.select-transacao-coleta-setor option:selected').val();

    let diaPagamento = $('.dia-pagamento').val();

    let idFormaPagamento = $('.forma-pagamento-setor option:selected').val();

    let observacaoFormaPagamento = $('.observacao-pagamento-setor').val();

    permissao = true;

    $('.input-obrigatorio').each(function(){
        if(!$(this).val()){
            permissao = false;
            avisoRetorno('Algo deu errado!', `Preencha todos os campos`, 'error', '#');
        }    
        
    });
    if (!$('.fixo-coleta').hasClass('d-none') && !diaFixoSemana) {
        permissao = false;
        avisoRetorno('Algo deu errado!', `Preencha todos os campos`, 'error', '#');
    } 

    // verifica se é para editar ou cadastrar um novo
    let editarSetorEmpresa = 'cadastrando';
    if ($('.input-editar-setor-empresa').val() == "editando") {

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
                editarSetorEmpresa: editarSetorEmpresa,
                transacaoColeta: transacaoColeta,
                diaPagamento: diaPagamento,
                idFormaPagamento: idFormaPagamento,
                observacaoFormaPagamento: observacaoFormaPagamento
            },
            beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-form').addClass('d-none');

            },
            success: function (data) {

                $('.select-nome-setor-empresa').val('').trigger('change');

                $('.select-nome-setor-empresa').attr('disabled', false);

                $('.editando-txt').html('');

                $('.select-frequencia-coleta-setor').val('').trigger('change');

                $('.select-transacao-coleta-setor').val('').trigger('change');

                $('.dia-pagamento').val('');

                $('.select-dia-fixo').val('').trigger('change');

                $('.forma-pagamento-setor').val('').trigger('change');

                $('.observacao-pagamento-setor').val('');

                $('.input-editar-setor-empresa').val('');

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');

                if (data.success && !data.editado) {

                    $('.div-setor-empresa').append(data.message);

                } else if (data.success && data.editado) {

                    let novaFuncaoClick = `verSetorEmpresaCliente('${data.nome_setor_empresa}', '${data.id_frequencia_coleta}', '${data.dia_coleta_fixo}', '${data.transacao_coleta}', '${data.dia_pagamento}', '${data.id_forma_pagamento}', '${data.observacao_pagamento}')`;


                    $('.input-edita-setor-empresa-' + data.id_setor_empresa).attr('onclick', novaFuncaoClick);

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

    $('.select-nome-setor-empresa').val('').trigger('change');

    $('.select-nome-setor-empresa').attr('disabled', false);

    $('.editando-txt').html('');

    $('.select-frequencia-coleta-setor').val('').trigger('change');

    $('.select-transacao-coleta-setor').val('').trigger('change');

    $('.dia-pagamento').val('');

    $('.select-dia-fixo').val('').trigger('change');

    $('.forma-pagamento-setor').val('').trigger('change');

    $('.observacao-pagamento-setor').val('');

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

            $('.select-nome-setor-empresa').val('').trigger('change');

            $('.select-nome-setor-empresa').attr('disabled', false);

            $('.editando-txt').html('');

            $('.select-frequencia-coleta-setor').val('').trigger('change');

            $('.select-transacao-coleta-setor').val('').trigger('change');

            $('.dia-pagamento').val('');

            $('.select-dia-fixo').val('').trigger('change');

            $('.forma-pagamento-setor').val('').trigger('change');

            $('.observacao-pagamento-setor').val('');

            $('.input-editar-setor-empresa').val('');
        }
    })

}

$(document).on('change', '.select-frequencia-coleta-setor', function () {

    if ($('.select-frequencia-coleta-setor option:selected').text() == "Fixo") {

        $('.fixo-coleta').removeClass('d-none');
        $('.select-dia-fixo').attr('required', true);

    } else {

        $('.select-dia-fixo').val('');
        $('.fixo-coleta').addClass('d-none');
        $('.select-dia-fixo').attr('required', false);
    }
})


const verSetorEmpresaCliente = (setorEmpresa, frequenciaColeta, diaColetaFixo, transacaoColeta, diaPagamento, formaPagamento, observacaoFormaPagamento) => {

    $('.input-editar-setor-empresa').val('editando');

    $('.select-nome-setor-empresa').attr('disabled', true);

    $('.editando-txt').html('- Editando');

    let nomeSetorEmpresa = setorEmpresa.toUpperCase(); // deixa o nome com letras maiusculas

    let selectSetorEmpresa = $('.select-nome-setor-empresa').find('option').filter(function () {
        return $(this).text().toUpperCase() == nomeSetorEmpresa;
    });

    selectSetorEmpresa.prop('selected', true);
    $('.select-nome-setor-empresa').val(selectSetorEmpresa.val()).trigger('change');
    
    let selectFrequenciaColetaSetor = $('.select-frequencia-coleta-setor').find('option').filter(function () {
        return $(this).val() == frequenciaColeta;
    });

    selectFrequenciaColetaSetor.prop('selected', true);
    $('.select-frequencia-coleta-setor').val(selectFrequenciaColetaSetor.val()).trigger('change');

    let selectTrasacaoColeta = $('.select-transacao-coleta-setor').find('option').filter(function () {
        return $(this).val() == transacaoColeta;
    });

    selectTrasacaoColeta.prop('selected', true);
    $('.select-transacao-coleta-setor').val(selectTrasacaoColeta.val()).trigger('change');

    let selectFormaPagamento = $('.forma-pagamento-setor').find('option').filter(function(){
        return $(this).val() == formaPagamento;
    });

    selectFormaPagamento.prop('selected', true);
    $('.forma-pagamento-setor').val(selectFormaPagamento.val()).trigger('change');

    $('.dia-pagamento').val(diaPagamento);

    $('.observacao-pagamento-setor').val(observacaoFormaPagamento);

    let selectDiaColetaFixo = $('.select-dia-fixo').find('option').filter(function(){
        return $(this).val() == diaColetaFixo;
    });

    selectDiaColetaFixo.prop('selected', true);
    $('.select-dia-fixo').val(selectDiaColetaFixo.val()).trigger('change');

}
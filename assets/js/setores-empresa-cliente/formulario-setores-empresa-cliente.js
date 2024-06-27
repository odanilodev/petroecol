var baseUrl = $('.base-url').val();

$('.dia-pagamento').on('input', function () {

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

    let frequenciaColeta = $('.select-frequencia-coleta-setor option:selected').data('qtd-dias'); // quantidade de dias da frequencia selecionada

    let diaFixoSemana = $('.select-dia-fixo option:selected').val();

    let transacaoColeta = $('.select-transacao-coleta-setor option:selected').val();

    let diaPagamento = $('.dia-pagamento').val();

    let idFormaPagamento = $('.forma-pagamento-setor option:selected').val();

    let observacaoFormaPagamento = $('.observacao-pagamento-setor').val();

    permissao = true;

    $(".input-obrigatorio").each(function () {

        // Verifica se o valor do input atual está vazio
        if (!$(this).val()) {

            $(this).addClass('invalido');

            // verifica se é select2
            if ($(this).next().hasClass('aviso-obrigatorio')) {

                $(this).next().removeClass('d-none');

            } else {
                $(this).next().next().removeClass('d-none');
                $(this).next().addClass('select2-obrigatorio');
            }

            permissao = false;

        } else {

            $(this).removeClass('invalido');

            if ($(this).next().hasClass('aviso-obrigatorio')) {

                $(this).next().addClass('d-none');

            } else {
                $(this).next().next().addClass('d-none');
                $(this).next().removeClass('select2-obrigatorio');

            }
        }
    });


    if (!$('.fixo-coleta').hasClass('d-none') && !diaFixoSemana) {
        permissao = false;
        $('.select-dia-fixo').next().next().removeClass('d-none');
        $('.select-dia-fixo').next().addClass('select2-obrigatorio');
    } else {
        $('.select-dia-fixo').next().next().addClass('d-none');
        $('.select-dia-fixo').next().removeClass('select2-obrigatorio');
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

                    agendarCliente(idCliente, idSetorEmpresa, frequenciaColeta);

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


function agendarCliente(cliente, setorEmpresa, frequenciaColeta) {

    let dataAtual = new Date();

    // Função para somar dias a uma data
    function adicionarDias(data, dias) {
        let novaData = new Date(data);
        novaData.setDate(novaData.getDate() + dias);
        return novaData;
    }

    let dataFutura = adicionarDias(dataAtual, frequenciaColeta);

    // Formatando a data para YYYY-MM-DD
    let dia = ("0" + dataFutura.getDate()).slice(-2);
    let mes = ("0" + (dataFutura.getMonth() + 1)).slice(-2); 
    let ano = dataFutura.getFullYear();

    let dataFormatada = `${ano}-${mes}-${dia}`;

    $.ajax({
        type: "post",
        url: `${baseUrl}agendamentos/cadastraAgendamento`,
        data: {
            cliente: cliente,
            data: dataFormatada,
            setorEmpresa: setorEmpresa,
            prioridade: 0
        }
    })

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

    let selectFormaPagamento = $('.forma-pagamento-setor').find('option').filter(function () {
        return $(this).val() == formaPagamento;
    });

    selectFormaPagamento.prop('selected', true);
    $('.forma-pagamento-setor').val(selectFormaPagamento.val()).trigger('change');

    $('.dia-pagamento').val(diaPagamento);

    $('.observacao-pagamento-setor').val(observacaoFormaPagamento);

    let selectDiaColetaFixo = $('.select-dia-fixo').find('option').filter(function () {
        return $(this).val() == diaColetaFixo;
    });

    selectDiaColetaFixo.prop('selected', true);
    $('.select-dia-fixo').val(selectDiaColetaFixo.val()).trigger('change');

}
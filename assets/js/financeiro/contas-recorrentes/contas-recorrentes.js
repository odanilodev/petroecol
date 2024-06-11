$(document).on('click', '.nova-conta', function () {

    $('.select-macros').val('').trigger('change');
    $('.select-recebido').val('').trigger('change');
    $('.select-grupo-recebidos').val('').trigger('change');
})

$(document).on('change', '.select-macros', function () {

    let idMacro = $(this).val();

    $.ajax({
        type: "post",
        url: `${baseUrl}finMicro/recebeMicrosMacro`,
        data: {
            idMacro: idMacro
        }, beforeSend: function () {
            $('.select-micros').html('<option disabled>Selecione</option>');
        }, success: function (data) {

            $('.select-micros').attr('disabled', false);

            let options = '<option value="" disabled >Selecione</option>';

            for (i = 0; i < data.microsMacro.length; i++) {

                options += `<option value="${data.microsMacro[i].id}">${data.microsMacro[i].nome}</option>`;
            }

            $('.select-micros').html(options);

            $('.select-micros').val('').trigger('change');

        }
    })
})

$(document).on('change', '.select-grupo-recebidos', function () {

    let grupo = $(this).val();

    if (grupo == "clientes") {

        $.ajax({
            type: "post",
            url: `${baseUrl}finContasPagar/recebeTodosClientesAll`
            , beforeSend: function () {
                $('.select-recebido').attr('disabled', true);
                $('.select-recebido').html('<option disabled>Carregando...</option>');
            }, success: function (data) {
                $('.select-recebido').attr('disabled', false);

                let options = '<option disabled="disabled" value="">Selecione</option>';
                for (let i = 0; i < data.clientes.length; i++) {
                    options += `<option value="${data.clientes[i].id}">${data.clientes[i].nome}</option>`;
                }
                $('.select-recebido').html(options);

                $('.select-recebido').val('').trigger('change');

            }
        })
    } else {

        $.ajax({
            type: "post",
            url: `${baseUrl}finDadosFinanceiros/recebeDadosFinanceiros`,
            data: {
                grupo: grupo
            },
            beforeSend: function () {
                $('.select-recebido').attr('disabled');
                $('.select-recebido').html('<option value="">Carregando...</option>');
            }, success: function (data) {

                $('.select-recebido').attr('disabled', false);
                $('.select-recebido').html('<option value="">Selecione</option>');

                for (i = 0; i < data.dadosFinanceiro.length; i++) {

                    $('.select-recebido').append(`<option value="${data.dadosFinanceiro[i].id}">${data.dadosFinanceiro[i].nome}</option>`);
                }
            }
        })

    }

})


$(document).on('change', '.select-recebido', function () {

    let nomeRecebido = $('.select-recebido option:selected').text();

    $('.nome-recebido').val(nomeRecebido);
})


const cadastraContasRecorrentes = (classe) => {

    let idConta = $('.id-editar-conta').val();

    let dadosFormulario = {};
    let permissao = verificaCamposObrigatorios('input-obrigatorio');

    if ($('.input-dia-pagamento').val() > 31) {
        permissao = false;
        $('.input-dia-pagamento').next().removeClass('d-none');
        $('.input-dia-pagamento').next().html('Digite um valor entre 1 e 31');
        $('.input-dia-pagamento').addClass('invalido');
    }

    $(`.${classe}`).find(":input").each(function () {

        dadosFormulario[$(this).attr('name')] = $(this).val();

    })

    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}finContasRecorrentes/cadastraContasRecorrentes`,
            data: {
                idConta: idConta,
                dados: dadosFormulario
            }, beforeSend: function () {
                $(".load-form").removeClass("d-none");
                $(".btn-form").addClass("d-none");
            }, success: function (data) {
                $(".load-form").addClass("d-none");
                $(".btn-form").removeClass("d-none");

                avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${baseUrl}finContasRecorrentes`);

            }
        })
    }
}

const visualizarConta = (idConta) => {

    $('.id-editar-conta').val(idConta);

    $.ajax({
        type: "post",
        url: `${baseUrl}finContasRecorrentes/visualizarConta`,
        data: {
            idConta: idConta
        }, beforeSend: function () {
            $('.html-clean').html('');
        }, success: function (data) {

            $('.select-micros').prop('disabled', false);
            $('.select-recebido').prop('disabled', false);

            $('.input-dia-pagamento').val(data['conta'].dia_pagamento);

            $('.select-macros').val(data['conta'].id_macro).trigger('change');

            $('.select-setor').val(data['conta'].id_setor_empresa).trigger('change');

            if (data['conta'].GRUPO_CREDOR) {
                $('.select-grupo-recebidos').val(data['conta'].GRUPO_CREDOR).trigger('change');
            } else {
                $('.select-grupo-recebidos').val('clientes').trigger('change');
            }

            $(setTimeout(() => {
                $('.select-micros').val(data['conta'].id_micro).trigger('change');
                $('.select-recebido').val(data['conta'].ID_RECEBIDO ?? data['conta'].ID_CLIENTE).trigger('change');
            }, 550));



        }
    })

}

const deletarConta = (idConta) => {

    Swal.fire({
        title: 'Você tem certeza?',
        text: "Esta ação não poderá ser revertida",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sim, deletar'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                type: "post",
                url: `${baseUrl}finContasRecorrentes/deletarConta`,
                data: {
                    idConta: idConta
                }, success: function (data) {

                    let redirect = data.type != 'error' ? `${baseUrl}finContasRecorrentes` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                }
            })

        }
    })


}


$(function () {
    $('.select2').select2({
        dropdownParent: "#modalNovaContaRecorrente",
        theme: "bootstrap-5",
    });
})
var baseUrl = $('.base-url').val();

const inativaCliente = (id) => {

    $.ajax({
        type: 'post',
        url: `${baseUrl}clientes/verificaRecipienteCliente`,
        data: {
            id: id
        }, success: function (data) {

            if (data.success) { // verifica se existe recipentes no cliente

                $.ajax({
                    type: 'post',
                    url: `${baseUrl}clientes/deletaCliente`,
                    data: {
                        id: id
                    }, success: function () {

                        let qtdClientes = $('.quantidade-notificacao').val();

                        $(".notificacao-" + id).remove();

                        $('.quantidade-notificacao').val(qtdClientes - 1);

                        let qtdClientesAtualizado = qtdClientes - 1;

                        if (qtdClientesAtualizado > 99) {

                            $('.icon-indicator-number').text('99+');

                        } else if (qtdClientes > 1) {

                            $('.icon-indicator-number').text(qtdClientesAtualizado);

                        } else {

                            $(".btn-aprovacao-inativacao").remove();
                        }
                    }
                })

            } else {
                avisoRetorno('Algo deu errado!', `${data.message}`, 'error', `${baseUrl}clientes/detalhes/${id}`);
            }

        }
    })



}

$(function () {


    const mostrarAlerta = $('.mostrar-alerta').val();

    if (mostrarAlerta) {
        $.ajax({
            type: 'POST',
            url: `${baseUrl}admin/recebeDocumentos`,
            success: function (data) {
                if (data.success) {
                    Swal.fire({
                        title: 'Atenção!',
                        html: data.mensagem,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Atualizar Documentos',
                        cancelButtonText: 'Fechar',
                        cancelButtonColor: 'red',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `${baseUrl}documentoEmpresa/`;
                        }
                    });
                }
            },
            error: function (xhr) {
                console.error('Erro ao receber documentos:', xhr.responseText);
            }
        });
    }

    $('#btnNotificacao').on('click', function () {

        $('#collapseAprovacaoInativacao').removeClass('show');
        $('#collapseDocumentos').removeClass('show');

        let clientesCount = parseInt($('.quantidade-notificacao-clientes').val());
        let documentosCountVencendo = parseInt($('.quantidade-notificacao-documentos-vencendo').val());
        let documentosCountVencidos = parseInt($('.quantidade-notificacao-documentos-vencidos').val());

        let totalCount = clientesCount + documentosCount;

        totalCount = totalCount >= 100 ? '99+' : totalCount;

        $('#notificacaoCount').text(totalCount);

        if (clientesCount > 0) {
            $('#clientesBadge').text(clientesCount);
            $('#clientesBadge').show();
        } else {
            $('#clientesBadge').hide();
        }

        if (documentosCountVencendo > 0) {
            $('#documentosVencendoBadge').text(documentosCount);
            $('#documentosVencendoBadge').show();
        } else {
            $('#documentosVencendoBadge').hide();
        }

        if (documentosCountVencidos > 0) {
            $('#documentosVencidosBadge').text(documentosCountVencidos);
            $('#documentosVencidosBadge').show();
        } else {
            $('#documentosVencidosBadge').hide();
        }
    });
});


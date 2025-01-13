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

        let totalCount = clientesCount + documentosCountVencendo + documentosCountVencidos;

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
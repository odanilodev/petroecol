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

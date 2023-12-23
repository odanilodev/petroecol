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

                        $(".notificacao-" + id).animate({
                            opacity: 0,
                            height: 0
                        }, 200);

                        let qtdClientes = parseInt($('.icon-indicator-number').text());

                        if (qtdClientes >= 99) {

                            $('.icon-indicator-number').text('99+');

                        } else if (qtdClientes > 1) {

                            $('.icon-indicator-number').text(qtdClientes - 1);

                        } else {
                            
                            $(".btn-aprovacao-inativacao").animate({
                                opacity: 0,
                                height: 0
                            }, 200);
                        }
                    }
                })

            } else {
                avisoRetorno('Algo deu errado!', `${data.message}`, 'error', `${baseUrl}clientes/detalhes/${id}`);
            }

        }
    })


}

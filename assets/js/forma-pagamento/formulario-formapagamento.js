var baseUrl = $('.base-url').val();

const cadastraFormaPagamento = () => {


    let formaPagamento = $('.input-nome').val();

    let id = $('.input-id').val();
    let permissao = false;

    // cadastra uma forma de Pagamento nova
    if (formaPagamento != "") {

        permissao = true;

    } else {

        permissao = false;

    }

    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}formapagamento/cadastraFormaPagamento`,
            data: {
                formaPagamento: formaPagamento,
                id: id
            },
            beforeSend: function () {
                $('.load-form').removeClass('d-none');
                $('.btn-envia').addClass('d-none');
            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-envia').removeClass('d-none');

                if (data.success) {

                    avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}formapagamento`);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                }
            }
        });
    }
}

const deletaFormaPagamento = (id) => {

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
                type: 'post',
                url: `${baseUrl}formapagamento/deletaFormaPagamento`,
                data: {
                    id: id
                }, success: function () {

                    avisoRetorno('Sucesso!', 'Forma de pagamento deletada com sucesso!', 'success', `${baseUrl}formapagamento`);

                }
            })

        }
    })


}
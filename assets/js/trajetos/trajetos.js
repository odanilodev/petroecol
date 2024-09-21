var baseUrl = $(".base-url").val();

const cadastraTrajeto = () => {

    let nome = $('.input-trajeto').val();
    let id = $('.input-id').val();

    let permissao = verificaCamposObrigatorios('input-obrigatorio');

    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}trajetos/cadastraTrajeto`,
            data: {
                nome: nome,
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

                    avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}trajetos`);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                }
            },  error: function (xhr, status, error) {
                
                $('.load-form').addClass('d-none');
                $('.btn-envia').removeClass('d-none');
                if (xhr.status === 403) {
                    avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação..`, 'error', '#');
                }
            }
        });
    }
}

const deletarTrajeto = (id) => {


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
                url: `${baseUrl}trajetos/deletaTrajeto`,
                data: {
                    id: id
                }, success: function (data) {

                    let redirect = data.success ? `${baseUrl}trajetos` : `#`;

                    avisoRetorno(data.title, data.message, data.type, redirect);



                }
            })

        }
    })


}



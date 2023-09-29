var baseUrl = $('.base-url').val();

const cadastraUsuario = () => {

    let nome = $('.input-nome').val();
    let icone = $('.input-icone').val();
    let link = $('.input-link').val();
    let ordem = $('.input-ordem').val();
    let sub = $('.input-sub').val();

    $.ajax({
        type: "post",
        url: `${baseUrl}menu/cadastraMenu`,
        data: {
            nome: nome,
            icone: icone,
            link: link,
            ordem: ordem,
            sub: sub
        },
        beforeSend: function () {
            $('.load-form').removeClass('d-none');
            $('.btn-envia').addClass('d-none');
        },
        success: function (data) {

            $('.load-form').addClass('d-none');
            $('.btn-envia').removeClass('d-none');

            if (data.success) {

                avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}menu`);

            } else {

                avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

            }
        }
    });
}

function validaEmail(email) {

    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    return filter.test(email);
}

const deletarUsuario = (id) => {

    Swal.fire({
        title: 'Você tem certeza?',
        text: "Esta ação não porerá ser revertida",
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
                url: `${baseUrl}usuarios/deletaUsuario`,
                data: {
                    id: id
                }, success: function () {

                    avisoRetorno('Sucesso!', 'Usuário deletado com sucesso!', 'success', `${baseUrl}usuarios`);

                }
            })

        }
    })


}

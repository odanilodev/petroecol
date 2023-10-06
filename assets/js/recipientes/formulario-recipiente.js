var baseUrl = $('.base-url').val();

const cadastraRecipiente = () => {
    let nome_recipiente = $('.input-nome').val();
    let volume_suportado = $('.input-volume').val();
    let quantidade = $('.input-quantidade').val();
    let unidade_peso = $('.input-unidade').val();

    let id = $('.input-id').val();
    let permissao = false;

    // cadastra um setor novo
    if (nome_recipiente != "") {

        permissao = true;

    } else {

        permissao = false;

    }

    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}recipientes/cadastraRecipiente`,
            data: {
                nome_recipiente: nome_recipiente,
                volume_suportado: volume_suportado,
                quantidade: quantidade,
                unidade_peso: unidade_peso,
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

                    avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}recipientes`);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                }
            }
        });
    }
}

const deletarRecipiente = (id) => {

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
                url: `${baseUrl}recipientes/deletaRecipiente`,
                data: {
                    id: id
                }, success: function () {

                    avisoRetorno('Sucesso!', 'Recipiente deletado com sucesso!', 'success', `${baseUrl}recipientes`);

                }
            })

        }
    })


}
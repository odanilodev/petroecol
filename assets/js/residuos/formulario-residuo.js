var baseUrl = $('.base-url').val();

const cadastraResiduos = () => {

    let residuo = $('.input-nome').val();
    let grupo = $('.input-grupo').val();
    let id = $('.input-id').val();

    let permissao = false;

    // cadastra um setor novo
    if (residuo != "" || grupo != "") {

        permissao = true;

    }

    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}residuos/cadastraResiduo`,
            data: {
                residuo: residuo,
                grupo: grupo,
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

                    avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}residuos`);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                }
            }
        });
    }
}

const deletarResiduo = (id) => {

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
                url: `${baseUrl}residuos/deletaResiduo`,
                data: {
                    id: id
                }, success: function () {

                    avisoRetorno('Sucesso!', 'Residuo deletado com sucesso!', 'success', `${baseUrl}residuos`);

                }
            })

        }
    })


}
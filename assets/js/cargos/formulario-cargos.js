var baseUrl = $('.base-url').val();

const cadastraCargo = () => {

    let nome = $('.input-nome').val();
    let id = $('.input-id').val();

    if ($('.input-responsavelagendamento').is(':checked')) {
        var responsavelAgendamento = 1;
    } else {
        var responsavelAgendamento = 0;
    }

    let permissao = false;

    // cadastra um cargo novo
    if (nome != "") {

        permissao = true;

    }

    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}cargos/cadastraCargos`,
            data: {
                nome: nome,
                id: id,
                responsavelAgendamento: responsavelAgendamento
            },
            beforeSend: function () {
                $('.load-form').removeClass('d-none');
                $('.btn-envia').addClass('d-none');
            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-envia').removeClass('d-none');

                if (data.success) {

                    avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}cargos`);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                }
            }
        });
    }
}

const deletaCargos = (id) => {

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
                url: `${baseUrl}cargos/deletaCargos`,
                data: {
                    id: id
                }, success: function () {

                    avisoRetorno('Sucesso!', 'Cargo deletado com sucesso!', 'success', `${baseUrl}cargos`);

                }
            })

        }
    })


}
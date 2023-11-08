var baseUrl = $('.base-url').val();

const salvaAgendamento = () => {

    let cliente = $('.cliente-agendamento').val();
    let data = $('.data-agendamento').val();
    let horario = $('.horario-agendamento').val();
    let obs = $('.obs-agendamento').val();

    alert(cliente);
    let id = $('.input-id').val();
    let permissao = false;

    // cadastra uma etiqueta nova
    if (nome != "") {

        permissao = true;

    } else {

        permissao = false;

    }

    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}etiquetas/cadastraEtiqueta`,
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

                    avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}etiquetas`);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                }
            }
        });
    }
}

const deletarEtiqueta = (id) => {

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
                url: `${baseUrl}etiquetas/deletaEtiqueta`,
                data: {
                    id: id
                }, success: function () {

                    avisoRetorno('Sucesso!', 'Etiqueta deletada com sucesso!', 'success', `${baseUrl}etiquetas`);

                }
            })

        }
    })


}
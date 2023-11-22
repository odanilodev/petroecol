var baseUrl = $('.base-url').val();

const cadastraFrequenciaColeta = () => {

    let frequenciaColeta = $('.input-frequencia').val();
    let diaColeta = $('.input-dias').val();

    let id = $('.input-id').val();
    let permissao = false;

    // cadastra uma nova Frequencia
    if (frequenciaColeta!= "") {

        permissao = true;

    } else {

        permissao = false;

    }

    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}frequenciacoleta/cadastraFrequenciaColeta`,
            data: {
                frequenciaColeta: frequenciaColeta,
                diaColeta: diaColeta,
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

                    avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}frequenciacoleta`);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                }
            }
        });
    }
}

const deletaFrequenciaColeta = (id) => {

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
                url: `${baseUrl}frequenciacoleta/deletaFrequenciaColeta`,
                data: {
                    id: id
                }, success: function () {

                    avisoRetorno('Sucesso!', 'Frequência de coleta deletada com sucesso!', 'success', `${baseUrl}frequenciacoleta`);

                }
            })

        }
    })


}
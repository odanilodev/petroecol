var baseUrl = $('.base-url').val();

const cadastraFrequenciaColeta = () => {

    let frequenciaColeta = $('.input-frequencia').val();
    let diaColeta = $('.input-dias').val();

    let id = $('.input-id').val();
    let permissao = true;

    $('.campo-obrigatorio').each(function(){
        if (!$(this).val()) {
            $(this).addClass('invalido');
           $(this).next('.msg-invalido').removeClass('d-none');

            permissao = false;
        } 
    });

    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}frequenciaColeta/cadastraFrequenciaColeta`,
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

                let redirect = data.type != 'error' ? `${baseUrl}frequenciaColeta` : '#';

                avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

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
                url: `${baseUrl}frequenciaColeta/deletaFrequenciaColeta`,
                data: {
                    id: id
                }, success: function (data) {

                    let redirect = data.type != 'error' ? `${baseUrl}frequenciaColeta` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                }
            })

        }
    })


}
var baseUrl = $('.base-url').val();

$(document).ready(function () {

    $('.btn-envia').click(function (event) {

        event.preventDefault();

        var form = $(this).closest('form'); // pega o <form> mais perto do botão de enviar
        var formData = form.serialize();

        $.ajax({
            type: "post",
            url: `${baseUrl}menu/cadastraMenu`,
            data: formData,
            beforeSend: function () {
                form.find('.load-form').removeClass('d-none');
                form.find('.btn-envia').addClass('d-none');
            },
            success: function (data) {
                form.find('.load-form').addClass('d-none');
                form.find('.btn-envia').removeClass('d-none');

                if (data.success) {
                    avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}menu`);
                } else {
                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');
                }
            }
        });

    });

});

const deletarMenu= (id) => {

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
                url: `${baseUrl}menu/deletaMenu`,
                data: {
                    id: id
                }, success: function () {

                    avisoRetorno('Sucesso!', 'Menu deletado com sucesso!', 'success', `${baseUrl}menu`);

                }
            })

        }
    })

}

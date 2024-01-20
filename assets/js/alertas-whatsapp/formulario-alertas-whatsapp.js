var baseUrl = $('.base-url').val();

const cadastraAlertaWhatsapp = () => {
    
    let titulo = $('.input-titulo').val();
    let textoAlerta = $('.input-texto-alerta').val();
    let id = $('.input-id').val();

    if ($('.input-status-alerta').is(':checked')) {

        var statusAlerta = 1;

    } else {

        var statusAlerta = 0;
    }
    //Verificação de campo vazio e permissao para cadastrar
    let permissao = true

	$(".input-obrigatorio").each(function () {
		// Verifica se o valor do input atual está vazio
		if ($(this).val().trim() === "") {

            $(this).addClass('invalido');
            $(this).next().removeClass('d-none');

			permissao = false;

		} else {

            $(this).removeClass('invalido');
            $(this).next().addClass('d-none');
        }
	});


    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}alertasWhatsapp/cadastraAlertaWhatsapp`,
            data: {
                titulo: titulo,
                textoAlerta: textoAlerta,
                statusAlerta: statusAlerta,
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

                    avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}alertasWhatsapp`);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                }
            }
        });
    }
}

const deletaAlertaWhatsapp = (id) => {

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
                url: `${baseUrl}alertasWhatsapp/deletaAlertaWhatsapp`,
                data: {
                    id: id
                }, success: function (data) {

                    let redirect = data.type != 'error' ? `${baseUrl}alertasWhatsapp` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                }
            })

        }
    })


}

$(document).ready(function () {

    var emojisSelecionados = [];

    $('#emojiButton').click(function () {

        $('.picmo__searchContainer').remove(); // remove o search box de emojis

        // clique no emoji dentro do modal
        $('.picmo__emojiButton').off().on('click', function (event) {

            event.stopPropagation(); // impede fechar o modal quando seleciona um emoji

            // junta o texto digitado com o emoji para não imprimir somente o emoji
            var textoComEmoji = $('#emojiTextarea').val() + $(this).attr('data-emoji');

            // Atualiza o valor do textarea
            $('#emojiTextarea').val(textoComEmoji);

            // Adiciona o emoji ao array emojisSelecionados
            emojisSelecionados.push($(this).attr('data-emoji'));
        });

    });

});
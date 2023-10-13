var baseUrl = $('.base-url').val();

$(document).ready(function () {

    $('.btn-envia').click(function (event) {

        event.preventDefault();

        let id = $('.input-id-menu').val();

        let form = $(this).closest('form'); // pega o <form> mais perto do botão de enviar

        let formData = form.serialize();

        formData += `&id=${id}`; // acrescenta o id no formData

        var inputsObrigatorios = form.find('.input-obrigatorio');

        var permissao = true;

        inputsObrigatorios.each(function () {

            if ($(this).val() == "" || $(this).val() == null) {

                $(this).addClass('invalido');
                permissao = false;


            } else {

                $(this).removeClass('invalido');
            }

        });

        if (permissao) {

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
        }

    });

});

const deletarMenu = (id, link) => {

    if (link) {

        excluirMenuPadrao(id);

    } else {

        excluirMenuPai(id);
    }
}


// alerta para excluir menu padrão
const excluirMenuPadrao = (id) => {

    Swal.fire({
        title: 'Você tem certeza?',
        text: 'Esta ação não poderá ser revertida',
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
                },
                success: function () {
                    avisoRetorno('Sucesso!', 'Menu deletado com sucesso!', 'success', `${baseUrl}menu`);
                }
            });
        }
    });
}


// alerta para excluir menu pai
const excluirMenuPai = (id) => {

    Swal.fire({
        title: 'Você tem certeza?',
        text: 'Esta ação não pode ser revertida. A exclusão deste menu pode afetar submenus vinculados a ele. Deseja continuar?',
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
                },
                success: function () {
                    avisoRetorno('Sucesso!', 'Menu e submenus deletados com sucesso!', 'success', `${baseUrl}menu`);
                }
            });
        }
    });
}

// exibe o tipo do menu quando editar
$(document).ready(function () {

    let tipoMenu = $('.tipo-menu').val();

    switch (tipoMenu) {
        case 'padrao':
            $('.accordion-padrao').click();
            $('.tipos-menu').remove();
            break;

        case 'pai':
            $('.accordion-pai').click();
            $('.tipos-menu').remove();
            break;

        case 'submenu':
            $('.accordion-sub').click();
            $('.tipos-menu').remove();
            break;
    }

})
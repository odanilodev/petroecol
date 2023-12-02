var baseUrl = $('.base-url').val();

const cadastraRecipiente = () => {
    let nome_recipiente = $('.input-nome').val();
    let volume_suportado = $('.input-volume').val();
    let quantidade = $('.input-quantidade').val();
    let unidade_peso = $('.input-unidade').val();

    let permissao = false;

    $('.input-obrigatorio').each(function(){
        if($(this).val() == "" || $(this).val() == null) {
            $(this).addClass('invalido')
            permissao = false;
        }else{
            $(this).removeClass('invalido')
        }
    })

    let id = $('.input-id').val();

    // cadastra um setor novo
    if (nome_recipiente != "" && volume_suportado != "" && quantidade != "" && unidade_peso != null) {

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

const deletaRecipiente = (id) => {

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
                url: `${baseUrl}recipientes/deletaRecipiente`,
                data: {
                    id: id
                }, success: function (data) {   

                    let redirect = data.type != 'error' ? `${baseUrl}recipientes` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                }
            })

        }
    })


}
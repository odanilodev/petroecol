var baseUrl = $('.base-url').val();

const cadastraMotorista = () => {

    let nome = $('.input-nome').val();
    let telefone = $('.input-telefone').val();
    let cpf = $('.input-cpf').val();
    let fotoPerfil = $('.inputFoto')[0].files[0];
    let fotoCnh = $('.inputCnh')[0].files[0];
    let dataCnh = $('.input-data').val();
    let id = $('.input-id').val();

    // cria um FormData para enviar os dados e a imagem
    let formData = new FormData();
    formData.append('nome', nome);
    formData.append('telefone', telefone);
    formData.append('cpf', cpf);
    formData.append('foto_perfil', fotoPerfil);
    formData.append('foto_cnh', fotoCnh);
    formData.append('data_cnh', dataCnh);

    var permissao = false;

  
    // cadastra um usuario novo
    if (id == "" && nome != "") {

        permissao = true;

    }

    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}motoristas/cadastraMotorista`,
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.load-form').removeClass('d-none');
                $('.btn-envia').addClass('d-none');
            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-envia').removeClass('d-none');

                if (data.success) {

                    avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}motoristas`);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                }
            }
        });
    }
}

const deletarUsuario = (id) => {

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
                url: `${baseUrl}usuarios/deletaUsuario`,
                data: {
                    id: id
                }, success: function () {

                    avisoRetorno('Sucesso!', 'Usuário deletado com sucesso!', 'success', `${baseUrl}usuarios`);

                }
            })

        }
    })


}

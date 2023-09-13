const cadastraUsuario = () => {

    let nome = $('.input-nome').val();
    let telefone = $('.input-telefone').val();
    let email = $('.input-email').val();
    let senha = $('.input-senha').val();
    let repeteSenha = $('.input-repete-senha').val();
    let imagemInput = $('#imageInput')[0].files[0];

    // cria um FormData para enviar os dados e a imagem
    let formData = new FormData();
    formData.append('nome', nome);
    formData.append('telefone', telefone);
    formData.append('email', email);
    formData.append('senha', senha);
    formData.append('imagem', imagemInput);

    var permissao = false;

    if (nome != "" && telefone != "" && email != "" && senha != "" && repeteSenha != "") {

        if (!validaEmail(email)) {
            permissao = false;
            return;
        }

        if (senha != repeteSenha) {
            permissao = false;
            return;
        } else {
            permissao = true;
        }

    } else {
        permissao = false;
    }

    if (permissao) {

        var baseUrl = $('.base-url').val();

        $.ajax({
            type: "post",
            url: `${baseUrl}usuarios/cadastraUsuario`,
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

                if (data == "email já existe") {

                    Swal.fire({
                        title: 'Erro',
                        text: 'Este email está vinculado a outra conta! Tente um email diferente',
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    })
                   
                } else {

                    Swal.fire(
                        'Sucesso!',
                        'O usuário foi cadastrado com sucesso!',
                        'success'
                    )

                    $('#cadastra-usuario').trigger("reset");

                }
            }
        });
    }
}


function validaEmail(email) {

    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    return filter.test(email);
}

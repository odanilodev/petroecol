const cadastraUsuario = () => {

    let nome = $('.input-nome').val();
    let telefone = $('.input-telefone').val();
    let email = $('.input-email').val();
    let senha = $('.input-senha').val();
    let repeteSenha = $('.input-repete-senha').val();
    let foto = $('.foto-perfil').attr('alt');

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
            data: {
                nome: nome,
                telefone: telefone,
                email: email,
                foto: foto,
                senha: senha
            }, beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-envia').addClass('d-none');

            }, success: function () {

                $('.load-form').addClass('d-none');
                $('.btn-envia').removeClass('d-none');

                Swal.fire(
                    'Sucesso!',
                    'O usuário foi cadastrado com sucesso!',
                    'success'
                )

                $('#cadastra-usuario').trigger("reset");
            }

        })
    }

}


function validaEmail(email) {

    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    return filter.test(email);
}
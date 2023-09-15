var baseUrl = $('.base-url').val();

const cadastraUsuario = () => {

    let nome = $('.input-nome').val();
    let telefone = $('.input-telefone').val();
    let email = $('.input-email').val();
    let senha = $('.input-senha').val();
    let repeteSenha = $('.input-repete-senha').val();
    let imagemInput = $('#imageInput')[0].files[0];
    let id = $('.input-id').val();

    // cria um FormData para enviar os dados e a imagem
    let formData = new FormData();
    formData.append('nome', nome);
    formData.append('telefone', telefone);
    formData.append('email', email);
    formData.append('senha', senha);
    formData.append('imagem', imagemInput);

    var permissao = false;

    // cadastra um usuario novo
    if (id == "" && nome != "" && telefone != "" && email != "" && senha != "" && repeteSenha != "") {

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

    } else if (id != "" && nome != "" && telefone != "" && email != "") {

        if (!validaEmail(email)) {
            permissao = false;
            return;
        }

        // == redefine senha do usuario == //

        let senhaAntiga = $('.input-senha-antiga').val();

        // verifica se a senha antiga existe no banco para poder alterar
        if (senhaAntiga != "") {

            $.ajax({
                type: "post",
                url: `${baseUrl}usuarios/verificaSenhaAntiga`,
                async: false,
                data: {
                    id: id,
                    senhaAntiga: senhaAntiga
                },
                success: function (data) {

                    if (data != "senha encontrada") {

                        $('.input-senha-antiga').addClass('invalido');
                        $('.senha-antiga-invalida').addClass('d-flex');

                    } else {

                        $('.input-senha-antiga').removeClass('invalido');
                        $('.senha-antiga-invalida').addClass('d-none');
                        $('.senha-antiga-invalida').addClass('form-control');

                        let novaSenha = $('.input-nova-senha').val();
                        let repeteNovaSenha = $('.input-repete-nova-senha').val();

                        if (novaSenha != "" && repeteNovaSenha != "") {

                            if (novaSenha != repeteNovaSenha) {

                                $('.input-repete-nova-senha').addClass('invalido');
                                $('.aviso-senha-diferente').addClass('d-flex');

                            } else {

                                $('.inputs-redefine').removeClass('invalido');
                                $('.inputs-redefine').addClass('form-control');
                                $('.aviso-senha-diferente').addClass('d-none');
                                $('.aviso-nova-senha').addClass('d-none');

                                formData.append('id', id);
                                formData.append('novaSenha', repeteNovaSenha);

                                permissao = true;

                            }

                        } else {

                            $('.input-repete-nova-senha').addClass('invalido');
                            $('.aviso-senha-diferente').addClass('d-flex');
                            $('.input-nova-senha').addClass('invalido');
                            $('.aviso-nova-senha').addClass('d-flex');

                            permissao = false;

                        }
                    }

                }
            });
        } else {

            formData.append('id', id);
            permissao = true;
        }
    }

    if (permissao) {

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

                } else if (data == "usuario cadastrado") {

                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'O usuário foi cadastrado com sucesso!',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {

                            window.location.href = `${baseUrl}usuarios/`;
                        }
                    });


                } else if (data == "usuario editado") {

                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'O usuário foi editado com sucesso!',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {

                            window.location.href = `${baseUrl}usuarios/`;
                        }
                    });

                }
            }
        });
    }
}

function validaEmail(email) {

    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    return filter.test(email);
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

                    avisoDeletado('Usuário', 'usuarios');
                }
            })

        }
    })


}

function avisoDeletado(string, redirect) {
    Swal.fire({
        title: 'Sucesso!',
        text: `${string} deletado com sucesso!`,
        icon: 'success',
    }).then((result) => {
        if (result.isConfirmed) {

            window.location.href = `${baseUrl}${redirect}`;
        }
    });
}
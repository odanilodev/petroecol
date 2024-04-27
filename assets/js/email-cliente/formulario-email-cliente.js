var baseUrl = $('.base-url').val();

let idEmail = $('.input-editar-email');
let emailCliente = $('#input-email');

const cadastraEmailCliente = () => {

    let idCliente = $('.id-cliente').val();
    let idGrupo = $('#id-grupo').val();
    let emailAtual = $('.email-atual').val();
    let nomeGrupo = $('#id-grupo option:selected').text();

    //Verificação de campo vazio e permissao para cadastrar

    let permissao = verificaCamposObrigatorios('input-obrigatorio-email')

    if (!validaEmail(emailCliente.val())) {

        emailCliente.addClass('invalido');
        emailCliente.next().removeClass('d-none');

        permissao = false;
        avisoRetorno('Algo deu errado!', `O email não é válido, verifique e tente novamente.`, 'error', '#');
    } else {

        emailCliente.removeClass('invalido');
        emailCliente.next().addClass('d-none');

    }

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}emailCliente/cadastraEmailCliente`,
            data: {
                idCliente: idCliente,
                emailCliente: emailCliente.val(),
                idGrupo: idGrupo,
                nomeGrupo: nomeGrupo,
                idEmail: idEmail.val(),
                verificaEmail: emailAtual == emailCliente.val()
            },
            beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-form').addClass('d-none');

            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');

                emailCliente.val('');
                $('#id-grupo').val(null).trigger('change');

                if (data.success && !data.editado) { //Cadastra

                    $('.div-emails').append(data.message);

                } else if (data.success && data.editado) { //Edita

                    let novaFuncaoClick = `verEmailCliente('${data.email}', '${data.grupoEmail}','${idEmail.val()}')`;

                    $('.edita-email-' + data.id).attr('onclick', novaFuncaoClick);

                    $('.txt-email-' + data.id).html(`${data.email} - ${data.nomeGrupo}`);

                    idEmail.val('');

                    $('.editando-label').addClass('d-none');

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                    idEmail.val('');

                    $('.editando-label').addClass('d-none');

                }
            },
            error: function (xhr, status, error) {
                $(".load-form").addClass("d-none");
                $(".btn-envia").removeClass("d-none");
                if (xhr.status === 403) {
                    avisoRetorno(
                        "Algo deu errado!",
                        `Você não tem permissão para esta ação..`,
                        "error",
                        "#"
                    );
                }
            },
        })
    }

}


const exibirEmailsCliente = (idCliente) => {

    emailCliente.val('')

    $('#id-grupo').val(null).trigger('change');

    idEmail.val('');

    $('.editando-label').addClass('d-none');

    $('#input-email').val('');

    $('.select2').select2({
        dropdownParent: "#modalEmail",
        theme: "bootstrap-5",
    });

    $('.id-cliente').val(idCliente);

    $.ajax({
        type: "POST",
        url: `${baseUrl}emailCliente/recebeEmailCliente`,
        data: {
            id_cliente: idCliente
        },
        beforeSend: function () {
            $('.div-emails').html('');
        },
        success: function (data) {

            if (data) {

                $('.div-emails').html(data);

            }
        }
    })
}


const deletaEmailCliente = (idEmailCliente) => {

    $.ajax({
        type: "POST",
        url: `${baseUrl}emailCliente/deletaEmailCliente`,
        data: {
            id: idEmailCliente
        },
        success: function (data) {

            $(`.email-${idEmailCliente}`).remove();
        }
    })

}

const verEmailCliente = (email, idGrupo, idEmail) => {

    $('.editando-label').removeClass('d-none');
    $('.input-editar-email').val(idEmail);

    $('.email-atual').val(email);

    $('#input-email').val(email);

    let selectGrupo = $('#id-grupo').find('option').filter(function () {
        return $(this).val() == idGrupo;
    });
    selectGrupo.prop('selected', true);
    $('#id-grupo').val(selectGrupo.val()).trigger('change');


}
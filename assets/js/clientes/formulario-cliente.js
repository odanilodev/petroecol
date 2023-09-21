var baseUrl = $('.base-url').val();

const verificaCampos = () => {

    var permissao = false;

    let dadosEmpresa = {};
    $('#form-empresa input').each(function () {
        dadosEmpresa[$(this).attr('name')] = $(this).val();
    });

    let dadosEndereco = {};
    $('#form-endereco .campo').each(function () {
        dadosEndereco[$(this).attr('name')] = $(this).val();
    });

    let dadosResponsavel = {};
    $('#form-responsavel input').each(function () {
        dadosResponsavel[$(this).attr('name')] = $(this).val();
    });

    let camposObrigatorios = [
        // form empresa
        'nome',
        'telefone',
        'razao_social',
        // form endereco
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado'
    ];

    let camposVazios = [];

    $.each(camposObrigatorios, function (index, campo) {
        if (dadosEndereco[campo] == "" || dadosEmpresa[campo] == "") {
            camposVazios.push(campo);

            $(`input[name="${campo}"]`).addClass('invalido');
        }
    });

    if (!camposVazios.length) {

        permissao = true;

    } else {

        permissao = false;
    }

    if (permissao) {
        cadastraCliente(dadosEmpresa, dadosEndereco, dadosResponsavel);
    }

}


const cadastraCliente = (dadosEmpresa, dadosEndereco, dadosResponsavel) => {

    let id = $('.input-id').val();

    $.ajax({
        type: 'POST',
        url: `${baseUrl}clientes/cadastraCliente`,
        data: {
            dadosEmpresa: dadosEmpresa,
            dadosEndereco: dadosEndereco,
            dadosResponsavel: dadosResponsavel,
            id: id
        },
        beforeSend: function () {
            $('.load-form').removeClass('d-none');
            $('.bnt-voltar').addClass('d-none');
            $('.btn-proximo').addClass('d-none');
        },
        success: function (data) {

            if (data == "Cliente cadastrado com sucesso") {

                Swal.fire({
                    title: 'Sucesso!',
                    text: 'O cliente foi cadastrado com sucesso!',
                    icon: 'success',
                }).then((result) => {
                    if (result.isConfirmed) {

                        window.location.href = `${baseUrl}clientes/`;
                    }
                });

            } else if (data == "Cliente editado com sucesso") {

                Swal.fire({
                    title: 'Sucesso!',
                    text: 'O cliente foi editado com sucesso!',
                    icon: 'success',
                }).then((result) => {
                    if (result.isConfirmed) {

                        window.location.href = `${baseUrl}clientes/`;
                    }
                });

            }


        }
    });
}

// preenche todos os campos de endereço depois de digitar o cep
$(document).ready(function() {
    $('.input-cep').on('blur', function() {
        var cep = $(this).val().replace(/\D/g, '');

        if (cep.length !== 8) {
            alert('CEP inválido');
            return;
        }

        $.ajax({
            url: 'https://viacep.com.br/ws/' + cep + '/json/',
            dataType: 'json',
            success: function(data) {

                if (!data.erro) {
                    $('#rua').val(data.logradouro);
                    $('#bairro').val(data.bairro);
                    $('#cidade').val(data.localidade);
                    $('#estado').val(data.uf);
                } else {
                    alert('CEP não encontrado');
                }
            },
            error: function() {
                alert('Erro ao buscar o CEP');
            }
        });
    });
});



$(document).on('click', '.btn-proximo', function () {

    if ($('a.nav-link.btn-responsavel').hasClass('active')) {

        $('.btn-proximo').attr('onclick', 'verificaCampos()');
        $('.btn-proximo').html('Finalizar <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3">');

    }

});

$(document).on('click', '.btn-etapas', function () {

    if ($('a.nav-link.btn-responsavel').hasClass('active')) {

        $('.btn-proximo').attr('onclick', 'verificaCampos()');
        $('.btn-proximo').html('Finalizar <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3">');

    } else {
        $('.btn-proximo').removeAttr('onclick', 'verificaCampos()');
        $('.btn-proximo').html('Próximo <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3">');

    }
});

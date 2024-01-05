var baseUrl = $('.base-url').val();

const verificaCampos = () => {

    var permissao = true;

    let dadosEmpresa = {};
    $('#form-empresa .campo-empresa').each(function () {
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

    if ($('.select-dia-fixo').attr('required') && !$('.select-dia-fixo').val()) {

        permissao = false;

    }

    if (camposVazios.length) {

        permissao = false;

    }

    if (permissao) {
        cadastraCliente(dadosEmpresa, dadosEndereco, dadosResponsavel);
    }

}

$(document).on('change', '.select-frequencia', function () {

    if ($('.select-frequencia option:selected').text() == "Fixo") {

        $('.fixo-coleta').removeClass('d-none');
        $('.select-dia-fixo').attr('required', true);

    } else {

        $('.select-dia-fixo').val('');
        $('.fixo-coleta').addClass('d-none');
        $('.select-dia-fixo').attr('required', false);
    }
})


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

            if (data.success) {

                avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}clientes`);

            } else {

                avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

            }

        }
    });
}

// preenche todos os campos de endereço depois de digitar o cep
$(document).ready(function () {
    $('.input-cep').on('blur', function () {
        var cep = $(this).val().replace(/\D/g, '');

        if (cep.length !== 8) {
            avisoRetorno('CEP inválido', 'Verifique se digitou corretamente!', 'error', '#');
            return;
        }

        $.ajax({
            url: 'https://viacep.com.br/ws/' + cep + '/json/',
            dataType: 'json',
            success: function (data) {

                if (!data.erro) {
                    $('#rua').val(data.logradouro);
                    $('#bairro').val(data.bairro);
                    $('#cidade').val(data.localidade);
                    $('#estado').val(data.uf);
                } else {
                    avisoRetorno('CEP não encontrado', 'Verifique se digitou corretamente', 'error', '#');
                }
            }
        });
    });
});

$(document).ready(function () {

    if ($('.valida-email').val() != "" && !validaEmail($('.valida-email').val())) {

        $('.valida-email').attr('required', true);

        $('.email-invalido').css('display', 'block');

    }

});

$(document).on('click', '.btn-proximo', function () {

    if (!validaEmail($('.valida-email').val()) && $('.valida-email').val() != "") {

        $('.valida-email').addClass('invalido');

        $('.email-invalido').css('display', 'block');

        permissao = false;
        return;

    } else {

        $('.valida-email').removeClass('invalido');

        $('.email-invalido').css('display', 'none');

        permissao = true;

    }

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


const deletaCliente = (id) => {

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

            // verifica se tem algum recipiente com o cliente antes de deletar
            verificaRecipienteCliente(id);

        }
    })

}

const verificaRecipienteCliente = (id) => {

    $.ajax({
        type: 'post',
        url: `${baseUrl}clientes/verificaRecipienteCliente`,
        data: {
            id: id
        }, success: function (data) {

            if (data.success) {

                $.ajax({
                    type: 'post',
                    url: `${baseUrl}clientes/deletaCliente`,
                    data: {
                        id: id
                    }, success: function () {

                        avisoRetorno('Sucesso!', 'Cliente deletado com sucesso!', 'success', `${baseUrl}clientes`);

                    }
                })

            } else {

                avisoRetorno('Algo deu errado!', `${data.message}`, 'error', `#`);

            }

        }
    })

}

const alteraStatusCliente = (id) => {


    let status = $('.select-status').val();

    $.ajax({
        type: 'post',
        url: `${baseUrl}clientes/alteraStatusCliente`,
        data: {
            id: id,
            status: status
        }, success: function (data) {

            avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${baseUrl}clientes/detalhes/${id}`);

        }
    })
}


const detalhesHistoricoColeta = (idColeta) => {

    $.ajax({
        type: 'post',
        url: `${baseUrl}coletas/detalhesHistoricoColeta`,
        data: {
            idColeta: idColeta,
        }, beforeSend: function () {

            $('.html-clean').html('');

        }, success: function (data) {

            if (data.success) {
                $('.btn-gerar-certificado').attr('data-coleta', idColeta);

                let valorPago = JSON.parse(data.coleta['valor_pago']);
                let qtdColeta = JSON.parse(data.coleta['quantidade_coletada']);
                let formaPag = JSON.parse(data.coleta['forma_pagamento']);
                let residuos = JSON.parse(data.coleta['residuos_coletados']);

                for (let i = 0; i < valorPago.length; i++) {
                    let totalPago = `<span class="mb-0">${valorPago[i]} em ${data.formasPagamento[formaPag[i]]}</span><br>`;
                    $('.total-pago').append(totalPago)
                }

                for (let i = 0; i < qtdColeta.length; i++) {
                    let quantidadeColetada = `<span class="mb-0">${qtdColeta[i]}${data.residuosColetados[residuos[i]]}</span><br>`;
                    $('.residuos-coletados').append(quantidadeColetada)
                }

                $('.data-coleta').html(data.dataColeta);
                $('.responsavel-coleta').html(data.coleta.nome_responsavel);

            } else {
                avisoRetorno('Algo deu errado', 'Não foi possível encontrar a coleta para este cliente!', 'error', '#')

            }



        }
    })

}

$(document).on('click', '.btn-gerar-certificado', function () {

    let modeloCertificado = $('.select-modelo-certificado').val();

    if (!modeloCertificado) {

        $('.select-modelo-certificado').addClass('invalido');
        return;
    }

    const modelo = modeloCertificado;
    const coleta = $(this).data('coleta');

    if (modelo && coleta) {
        var redirect = `${baseUrl}coletas/certificadoColeta/${coleta}/${modelo}`
        window.open(redirect, '_blank');
    } else {
        avisoRetorno('Algo deu errado!', 'Não foi possível encontrar o certificado de coleta.', 'error', `#`);
    }

});

const exibirAlertasCliente = (idCliente) => {
    $('.id-cliente').val(idCliente);
}

const enviarAlertaCliente = () => {

    let idCliente = $('.id-cliente').val();

    let idAlerta = $('#select-alertas').val();

    permissao = true;

    if (!idAlerta) {
        permissao = false;
    }

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}clientes/enviaAlertaCliente`,
            data: {
                id_cliente: idCliente,
                id_alerta: idAlerta
            },
            beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-form').addClass('d-none');

            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');

                if (data.success) {
                    avisoRetorno('Sucesso!', `${data.message}`, 'success', '#');
                    $("#modalAlertas").modal('hide');
                }
            }
        })
    } else {
        avisoRetorno('Algo deu errado!', 'Selecione uma notificação', 'error', '#');
    }

}
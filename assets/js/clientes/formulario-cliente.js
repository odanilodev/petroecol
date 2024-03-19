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

            if (data.success) {

                avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}clientes`);

            } else {

                avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

            }

        }
    });
}


$(document).ready(function () {
    $('.input-cep').on('blur', function () {
        var cep = $(this).val().replace(/\D/g, '');

        if (cep.length !== 8 && cep.length >= 1) {
            avisoRetorno('CEP inválido', 'Verifique se digitou corretamente!', 'error', '#');
            return;
        } else {
            preencherEnderecoPorCEP(cep, function(retornoViaCep) {
                $('#rua').val(retornoViaCep.logradouro);
                $('#bairro').val(retornoViaCep.bairro);
                $('#cidade').val(retornoViaCep.localidade);
                $('#estado').val(retornoViaCep.uf);
            });    
        }
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

    $('.input-id-coleta').val(idColeta);

    $.ajax({
        type: 'post',
        url: `${baseUrl}coletas/detalhesHistoricoColeta`,
        data: {
            idColeta: idColeta,
        }, beforeSend: function () {

            $('.body-coleta').show();
            $('.html-clean').html('');

        }, success: function (data) {

            if (data.success) {
               
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

const detalhesHistoricoColetaMassa = (idCliente) => {

    const dataInicio = $('.data-inicio-coleta').val();
    const dataFim = $('.data-fim-coleta').val();
    const idResiduo = $('.id-residuo-coleta').val();

    if (!dataInicio || !dataFim) {
        avisoRetorno('Algo deu errado', 'Seleciona datas para gerar certificado!', 'error', '#')
        return
    }

    $.ajax({
        type: 'post',
        url: `${baseUrl}coletas/clienteColetas`,
        data: {
            idCliente: idCliente,
            dataInicio: dataInicio,
            dataFim: dataFim,
            residuo: idResiduo
        }, beforeSend: function () {

            $('.body-coleta').hide();

        }, success: function (data) {

            if (data.success) {

                $('.modal-historico-coleta').modal('show');

                $('.input-id-coleta').val(data.coletasId);

            } else {
                avisoRetorno('Algo deu errado', 'Não foi encontrada nenhuma coleta com essas informações!', 'error', '#')
                return
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

    const idModelo = modeloCertificado;
    const coleta = $('.input-id-coleta').val();
    const idResiduo = $('.id-residuo-coleta').val() != null ? $('.id-residuo-coleta').val() : "";

    if (idModelo && coleta) {
        var redirect = `${baseUrl}coletas/certificadoColeta/${coleta}/${idModelo}/${idResiduo}`
        window.open(redirect, '_blank');
    } else {
        avisoRetorno('Algo deu errado!', 'Não foi possível encontrar o certificado de coleta.', 'error', `#`);
    }

});

const exibirAlertasClientes = (idCliente) => {
    $('.id-cliente').val(idCliente);
}

const enviarAlertaCliente = () => {

    let idCliente = $('.id-cliente').val();

    let mensagem = $('#select-alertas').val();

    permissao = true;

    if (!mensagem) {
        permissao = false;
    }

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}clientes/enviaAlertaCliente`,
            data: {
                id_cliente: idCliente,
                mensagem: mensagem
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
                } else {
                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');
                    $("#modalAlertas").modal('hide');
                }
            }
        })
    } else {
        avisoRetorno('Algo deu errado!', 'Selecione uma notificação', 'error', '#');
    }

}

$(document).ready(function () {
    
    $('#select-select-classificacao-cliente').val('').trigger('change');

    $('.select2').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
    });
})

//Select2 dentro do modal de filtros
$('.filtros-clientes').click(function(){

    $('.select2').val('all').trigger('change');

    $('.select2').select2({
            dropdownParent: "#reportsFilterModal",
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });
})
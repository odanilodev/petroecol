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
            preencherEnderecoPorCEP(cep, function (retornoViaCep) {

                if (retornoViaCep.erro) {

                    avisoRetorno(`${retornoViaCep.titulo}`, `${retornoViaCep.mensagem}`, `${retornoViaCep.type}`, '#');

                }

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

const emailsCertificadoColeta = (idColeta, idCliente) => {

    detalhesHistoricoColeta(idColeta, '.data-coleta-certificado'); // exibe os detalhes

    // busca os emails
    $.ajax({
        type: 'post',
        url: `${baseUrl}emailCliente/recebeEmailsCliente`,
        data: {
            idCliente: idCliente
        }, success: function (data) {

            let emailPrincipal = `
                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                    <td class="align-middle white-space-nowrap email-cliente text-1000" data-email="${data['emailPrincipal'].email}" style="padding-left: 4px;">
                        <input class="form-check-input check-clientes-modal cursor-pointer check-element" style="margin-right:8px;" name="clientes" type="checkbox" value="${data['emailPrincipal'].email}">
                        ${data['emailPrincipal'].email}
                    </td>

                    <td class="align-middle white-space-nowrap email-cliente text-1000 " data-email="${data['emailPrincipal'].email}">
                        Principal
                    </td>
                </tr>
            `;

            let emailsAdicionais = emailPrincipal;

            for (i = 0; i < data['emailsAdicionais'].length; i++) {

                emailsAdicionais += `
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="align-middle white-space-nowrap email-cliente" data-email="${data['emailsAdicionais'][i].email}" style="padding-left: 4px;">
                            <input class="form-check-input check-clientes-modal cursor-pointer check-element" style="margin-right:8px;" name="clientes" type="checkbox" value="${data['emailsAdicionais'][i].email}">
                            ${data['emailsAdicionais'][i].email}
                        </td>

                        <td class="align-middle white-space-nowrap email-cliente" data-email="${data['emailsAdicionais'][i].email}">
                            ${data['emailsAdicionais'][i].grupo}
                        </td>
                    </tr>
                `;
            }

            $('.emails-cliente').html(emailsAdicionais);

        }, error: function (xhr, status, error) {

            $('.btn-finaliza-romaneio').removeClass('d-none');
            $('.load-form-modal-romaneio').addClass('d-none');
            if (xhr.status === 403) {
                avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação..`, 'error', '#');
            }
        }
    })

}

const detalhesHistoricoColeta = (idColeta, classe) => {

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

                $(classe ? classe : '.data-coleta').html(data.dataColeta);
                $('.responsavel-coleta').html(data.coleta.nome_responsavel);

            } else {
                avisoRetorno('Algo deu errado', 'Não foi possível encontrar a coleta para este cliente!', 'error', '#')

            }

        }
    })

}

const detalhesHistoricoColetaMassa = (idCliente) => {

    $('.btn-enviar-certificado').removeClass('d-none');

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

$(document).on('click', '.btn-envia-certificado', function (e) {

    if ($('.emails-clientes-selecionados').val() && $('.select-modelo-certificado').val() != 'null'){

        $('.btn-form').addClass('d-none');
        $('.load-form').removeClass('d-none')
    }
});

$(document).on('click', '.btn-gerar-certificado', function () {

    let modeloCertificado = $('.select-modelo-certificado').val();

    if (!modeloCertificado) {

        $('.select-modelo-certificado').addClass('invalido');
        return;
    }

    const idModelo = modeloCertificado;
    const coleta = $('.input-id-coleta').val();

    if (idModelo && coleta) {
        var redirect = `${baseUrl}coletas/certificadoColeta/${coleta}/${idModelo}`;
        window.open(redirect, '_self');
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
        // dropdownParent: ".modal-cadastrar-coleta",
        theme: "bootstrap-5",
    });

})

//Select2 dentro do modal de filtros
$('.filtros-clientes').click(function () {

    $('.select2').val('all').trigger('change');

    $('.select2').select2({
        dropdownParent: "#reportsFilterModal",
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
    });
})


const recebeDadosColeta = (idColeta, idCliente) => {

    $('.input-id-coleta').val(idColeta);
    $('.input-id-cliente').val(idCliente);

    $.ajax({
        type: 'post',
        url: `${baseUrl}coletas/recebeColeta`,
        data: {
            idColeta: idColeta,
        }, beforeSend: function () {

            $('.body-coleta').show();
            $('.html-clean').html('');
            $('.residuos-coletados-editar').html('');

        }, success: function (data) {

            if (data.success) {

                $('.data-coleta-editar').val(data.dataColeta);

                $('.select-responsavel-editar option').each(function () {

                    if ($(this).val() == data.responsavel) {
                        $('.select-responsavel-editar').val(data.responsavel).trigger('change');
                    }
                })

                $('.residuos-coletados-editar').html(data.residuosColetados);


                $('.select2').select2({
                    dropdownParent: ".modal-editar-coleta",
                    theme: "bootstrap-5"
                });

            }


        }
    })

}



// verifica qual é o tipo da forma de pagamento para aplicar mascara
$(document).on('change', '.select-pagamento', function () {

    let valorPagamento = $(this).closest('.div-pagamento').next('.div-pagamento').find('.input-pagamento');

    if ($('option:selected', this).data('id-tipo-pagamento') == "Moeda Financeira") {

        valorPagamento.attr('type', 'text');

        valorPagamento.mask('000000000000000.00', { reverse: true });

        valorPagamento.val('');


    } else {

        valorPagamento.attr('type', 'number');
        valorPagamento.unmask();

    }

});


const salvarColetaEdit = () => {

    let idColeta = $('.input-id-coleta').val();
    let dadosClientes = [];
    let idResponsavel = $('.select-responsavel-editar option:selected').val();
    let dataColeta = $('.data-coleta-editar').val().split('/');
    let dataColetaFormatada = `${dataColeta[2]}-${dataColeta[1]}-${dataColeta[0]}`;
    let idCliente = $('.input-id-cliente').val();

    let permissao = verificaCamposObrigatorios('input-obrigatorio-coleta');

    // valores resíduos 
    let residuosSelecionados = [];

    $('.select-residuo option:selected').each(function () {

        if ($(this).val() != '') {

            residuosSelecionados.push($(this).val());
        }
    });

    let qtdResiduos = [];

    $('.input-quantidade').each(function () {

        if ($(this).val() != '') {

            qtdResiduos.push($(this).val());
            salvarDados = true;
        }
    });

    // valores pagamentos
    let formaPagamentoSelecionados = [];

    $('.residuos-coletados-editar').find('.div-pagamento .select-pagamento option:selected').each(function () {

        if ($(this).val() != '') {

            formaPagamentoSelecionados.push($(this).val());
        }

    });

    let valorPagamento = [];

    $('.input-pagamento').each(function () {

        if ($(this).val() != '') {

            valorPagamento.push($(this).val());
        }

    });


    let dadosCliente = {
        idCliente: idCliente,
        residuos: residuosSelecionados,
        qtdColetado: qtdResiduos,
        pagamento: formaPagamentoSelecionados,
        valor: valorPagamento,
        coletado: 1,
    };

    dadosClientes.push(dadosCliente);

    if (permissao) {
        $.ajax({
            type: 'post',
            url: `${baseUrl}coletas/cadastraColeta`,
            data: {
                idColeta: idColeta,
                clientes: dadosClientes,
                idResponsavel: idResponsavel,
                dataRomaneio: dataColetaFormatada

            }, beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-form').addClass('d-none');

            }, success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');

                if (data.success) {

                    avisoRetorno('Sucesso!', data.message, 'success', `${baseUrl}clientes/detalhes/${idCliente}`);


                    $('.select-responsavel-editar option').each(function () {

                        if ($(this).val() == data.responsavel) {
                            $('.select-responsavel-editar').val(data.responsavel).trigger('change');
                        }
                    })

                    $('.residuos-coletados-editar').html(data.residuosColetados);


                    $('.select2').select2({
                        dropdownParent: ".modal-editar-coleta",
                        theme: "bootstrap-5"
                    });

                }


            }
        })
    }
}


// duplica forma de pagamento e residuos
function duplicarElemento(novoElemento, novoInput, classe) {

    // Pega os options do select
    let options = $('.select-' + novoElemento).html();

    let selectHtml = `
        <div class="col-md-5 mb-2 mt-2 div-${novoElemento}">
            <select class="select2 form-select select-${novoElemento} w-100 ${novoElemento == "residuo" ? 'obrigatorio-coleta' : ''} ">
                ${options}
            </select>
        </div>
    `;

    let inputHtml = `
        <div class="col-md-5 mb-2 div-${novoElemento}">
            <input class="form-control mt-2 input-${novoElemento} ${novoElemento == "residuo" ? 'obrigatorio-coleta' : ''}" type="text" placeholder="Digite ${novoInput}" value="">
        </div>
    `;

    let btnRemove = $(`
    <div class="col-md-2 mb-2 mt-1 row">

        <button class="btn btn-phoenix-danger remover-${novoElemento} w-25">-</button>

    </div>`);

    // div com row para cada grupo ficar em row diferente
    let novaLinha = $('<div class="row"></div>');

    // imprime os elementos dentro da div row
    novaLinha.append(selectHtml);
    novaLinha.append(inputHtml);
    novaLinha.append(btnRemove);

    //remove a linha duplicada
    btnRemove.find(`.remover-${novoElemento}`).on('click', function () {

        novaLinha.remove();
    });

    $(`.${classe}`).append(novaLinha);

}

$(document).on('click', '.duplicar-residuo', function () {

    duplicarElemento('residuo', 'quantidade coletada', 'residuos-duplicados');

    $('.select2').select2({
        dropdownParent: ".modal-cadastrar-coleta",
        theme: "bootstrap-5",
    });

});

$(document).on('click', '.duplicar-pagamento', function () {

    duplicarElemento('pagamento', 'valor pago', 'pagamentos-duplicados');

    $('.select2').select2({
        dropdownParent: ".modal-cadastrar-coleta",
        theme: "bootstrap-5",
    });

});

const cadastraColetaCliente = (idCliente) => {

    let dadosClientes = [];

    let permissao = verificaCamposObrigatorios('obrigatorio-coleta');

    let idResponsavel = $('.select-responsavel').val();
    let dataColeta = $('.data-coleta-cadastrar').val().split('/');
    let dataColetaFormatada = `${dataColeta[2]}-${dataColeta[1]}-${dataColeta[0]}`;

    // valores resíduos 
    let residuosSelecionados = [];
    $('.select-residuo option:selected').each(function () {

        if ($(this).val() != '') {

            residuosSelecionados.push($(this).val());
        }
    });

    let qtdResiduos = [];
    $('.input-residuo').each(function () {

        if ($(this).val() != '') {

            qtdResiduos.push($(this).val());
            salvarDados = true;
        }
    });

    // valores pagamentos
    let formaPagamentoSelecionados = [];
    $('.div-pagamento .select-pagamento option:selected').each(function () {

        if ($(this).val() != '') {

            formaPagamentoSelecionados.push($(this).val());
        }

    });

    let valorPagamento = [];
    $('.div-pagamento .input-pagamento').each(function () {

        if ($(this).val() != '') {

            valorPagamento.push($(this).val());
        }

    });


    let dadosCliente = {
        idCliente: idCliente,
        residuos: residuosSelecionados,
        qtdColetado: qtdResiduos,
        pagamento: formaPagamentoSelecionados,
        valor: valorPagamento,
        obs: $('.input-obs').val(),
        coletado: 1
    };

    dadosClientes.push(dadosCliente);

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}coletas/cadastraColeta`,
            data: {
                clientes: dadosClientes,
                idResponsavel: idResponsavel,
                dataRomaneio: dataColetaFormatada,
                coletaManual: 1

            }, beforeSend: function () {

                $('.btn-finaliza-romaneio').addClass('d-none');
                $('.load-form-modal-romaneio').removeClass('d-none');
                $('.btn-form').addClass('d-none');
                $('.load-form').removeClass('d-none');

            }, success: function (data) {

                $('.btn-form').removeClass('d-none');
                $('.load-form').addClass('d-none');

                if (data.success) {
                    avisoRetorno('Sucesso!', 'A coleta foi registrada com sucesso!', 'success', `${baseUrl}clientes/detalhes/${idCliente}`);
                } else {
                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');
                }

            }, error: function (xhr, status, error) {

                $('.btn-finaliza-romaneio').removeClass('d-none');
                $('.load-form-modal-romaneio').addClass('d-none');
                if (xhr.status === 403) {
                    avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação..`, 'error', '#');
                }
            }

        })
    }
}
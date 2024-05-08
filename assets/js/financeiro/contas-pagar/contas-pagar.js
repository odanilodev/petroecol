var baseUrl = $(".base-url").val();

// Duplica formas de pagamento
function duplicarFormasPagamento() {
    let clone = $(".campos-pagamento .duplica-pagamento").clone();

    // Limpe os valores dos campos clonados
    clone.find("select").val("");
    clone.find("input").val("");
    clone.find("label").remove();

    let btnRemove = `
        <div class="col-md-1 mt-0">            
            <button type="button" class="btn btn-phoenix-danger deleta-dicionario" >
                <span class="fas fa-minus"></span>
            </button>
        </div>
    `;
    //por padrão row vem com margin e padding - classes retiram
    let novaLinha = $('<div class="row m-0 p-0"></div>');

    // imprime os elementos dentro da div row
    novaLinha.append(clone);
    novaLinha.append(btnRemove);

    $(novaLinha).find(`.deleta-dicionario`).on('click', function () {

        novaLinha.remove();
    });

    $(".campos-duplicados").append(novaLinha);
    $('.mascara-dinheiro').mask('000.000.000.000.000,00', { reverse: true });

}

const cadastraContasPagar = (classe) => {

    let idConta = $('.id-editar-conta').val();

    let dadosFormulario = {};
    let permissao = true;

    $(`.${classe}`).find(":input").each(function () {

        dadosFormulario[$(this).attr('name')] = $(this).val();

        if ($(this).hasClass('input-obrigatorio') && !$(this).val()) {

            $(this).addClass('invalido');

            // verifica se é select2
            if ($(this).next().hasClass('aviso-obrigatorio')) {

                $(this).next().removeClass('d-none');

            } else {
                $(this).next().next().removeClass('d-none');
                $(this).next().addClass('select2-obrigatorio');
            }

            permissao = false;

        } else {

            $(this).removeClass('invalido');

            if ($(this).next().hasClass('aviso-obrigatorio')) {

                $(this).next().addClass('d-none');

            } else {
                $(this).next().next().addClass('d-none');
                $(this).next().removeClass('select2-obrigatorio');

            }
        }

    })

    if (permissao) {

        let url = `${baseUrl}finContasPagar/${idConta ? 'editaConta' : 'cadastraContasPagar'}`;

        $.ajax({
            type: "post",
            url: url,
            data: {
                idConta: idConta,
                dados: dadosFormulario
            }, beforeSend: function () {
                $(".load-form").removeClass("d-none");
                $(".btn-form").addClass("d-none");
            }, success: function (data) {
                $(".load-form").addClass("d-none");
                $(".btn-form").removeClass("d-none");

                avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${baseUrl}finContasPagar`);

            }
        })
    }
}

$(document).on('click', '.novo-lancamento', function () {


    $('.id-editar-conta').val('');
    $('.dados-conta').val('');

    $('.select-micros').attr('disabled', true);
    $('.select-recebido').attr('disabled', true);

    $('.select2').select2({
        dropdownParent: "#modalLancamentoContasPagar",
        theme: "bootstrap-5",
    });

})


$(document).on('click', '.editar-lancamento', function () {

    $('.select2').select2({
        dropdownParent: "#modalLancamentoContasPagar",
        theme: "bootstrap-5",
    });

    $('.input-editar-valor').val($(this).data('valor'));

    let id = $(this).data('id');
    $('.id-editar-conta').val(id);


    $.ajax({
        type: "post",
        url: `${baseUrl}finContasPagar/recebeContaPagar`,
        data: {
            id: id
        }, beforeSend: function () {

            $('.select-micros').attr('disabled', false);
            $('.editando').removeClass('d-none');

        }, success: function (data) {

            let dataVencimento = data['conta'].data_vencimento.split('-');
            dataVencimento = dataVencimento[2] + '/' + dataVencimento[1] + '/' + dataVencimento[0];
            $('.input-data-vencimento').val(dataVencimento);

            let dataEmissao = data['conta'].data_emissao.split('-');
            dataEmissao = dataEmissao[2] + '/' + dataEmissao[1] + '/' + dataEmissao[0];

            $('.input-data-emissao').val(dataEmissao);

            $('.input-observacao').text(data['conta'].observacao);

        }
    })

})


$(document).on('change', '.select-macros', function () {

    let idMacro = $(this).val();

    $.ajax({
        type: "post",
        url: `${baseUrl}finMicro/recebeMicrosMacro`,
        data: {
            idMacro: idMacro
        }, beforeSend: function () {
            $('.select-micros').html('<option disabled>Selecione</option>');
        }, success: function (data) {

            $('.select-micros').attr('disabled', false);

            let options = '<option value="" disabled >Selecione</option>';

            for (i = 0; i < data.microsMacro.length; i++) {

                options += `<option value="${data.microsMacro[i].id}">${data.microsMacro[i].nome}</option>`;
            }

            $('.select-micros').html(options);

            $('.select-micros').val('').trigger('change');

        }
    })
})

$(document).on('change', '.select-grupo-recebidos', function () {

    let grupo = $(this).val();

    if (grupo == "clientes") {

        $.ajax({
            type: "post",
            url: `${baseUrl}finContasPagar/recebeTodosClientesAll`
            , beforeSend: function () {
                $('.select-recebido').attr('disabled', true);
                $('.select-recebido').html('<option disabled>Carregando...</option>');
            }, success: function (data) {
                $('.select-recebido').attr('disabled', false);

                let options = '<option disabled="disabled" value="">Selecione</option>';
                for (let i = 0; i < data.clientes.length; i++) {
                    options += `<option value="${data.clientes[i].id}">${data.clientes[i].nome}</option>`;
                }
                $('.select-recebido').html(options);

                $('.select-recebido').val('').trigger('change');

            }
        })
    } else {

        $.ajax({
            type: "post",
            url: `${baseUrl}finDadosFinanceiros/recebeDadosFinanceiros`,
            data: {
                grupo: grupo
            },
            beforeSend: function () {
                $('.select-recebido').attr('disabled');
                $('.select-recebido').html('<option value="">Carregando...</option>');
            }, success: function (data) {

                $('.select-recebido').attr('disabled', false);
                $('.select-recebido').html('<option value="">Selecione</option>');

                for (i = 0; i < data.dadosFinanceiro.length; i++) {

                    $('.select-recebido').append(`<option value="${data.dadosFinanceiro[i].id}">${data.dadosFinanceiro[i].nome}</option>`);
                }
            }
        })

    }

})


$(document).on('change', '.select-recebido', function () {

    let nomeRecebido = $('.select-recebido option:selected').text();

    $('.nome-recebido').val(nomeRecebido);
})


$(document).on('click', '.realizar-pagamento', function () {

    $('.input-obrigatorio-unic').each(function () {
        $(this).val('');
    })

    $('.obs-pagamento-inicio').val('');

    $('.id-conta-pagamento').val($(this).data('id'));
    $('.id-dado-financeiro').val($(this).data('id-dado-financeiro'));
    $('.input-valor').val($(this).data('valor'));
    $('.valor-total-conta').html(`R$ ${$(this).data('valor')}`);
})

const realizarPagamento = () => {

    let permissao = verificaCamposObrigatorios('input-obrigatorio-unic');

    if (permissao) {
        let contasBancarias = [];
        let formasPagamento = [];
        let valores = [];
        let obs = $('.obs-pagamento').val();
        let dataPagamento = $('.input-data-pagamento').val();
        let valorTotal = 0;

        let idConta = $('.id-conta-pagamento').val();
        let idDadoFinanceiro = $('.id-dado-financeiro').val();

        $('.select-conta-bancaria-unic').each(function () {

            contasBancarias.push($(this).val());
        })

        $('.select-forma-pagamento-unic').each(function () {

            formasPagamento.push($(this).val());
        })

        $('.input-valor-unic').each(function () {
            valores.push($(this).val());

            // soma o valor total
            let valorNumerico = parseFloat($(this).val().replace('.', '').replace(',', '.'));
            valorTotal += valorNumerico;
        });

        let valorTotalFormatado = valorTotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

        $.ajax({
            type: "post",
            url: baseUrl + "finContasPagar/realizarPagamento",
            data: {
                contasBancarias: contasBancarias,
                formasPagamento: formasPagamento,
                valores: valores,
                obs: obs,
                idConta: idConta,
                valorTotal: valorTotal,
                idDadoFinanceiro: idDadoFinanceiro,
                dataPagamento: dataPagamento
            }, beforeSend: function () {
                $(".load-form").removeClass("d-none");
                $(".btn-form").addClass("d-none");
            }, success: function (data) {

                atualizaFrontDadosFinanceiro(); // atualiza os valores (total pago, total em aberto, total caixa)

                $(".load-form").addClass("d-none");
                $(".btn-form").removeClass("d-none");

                if (data.success) {

                    $('#modalPagarConta').modal('hide');

                    // atualiza o front
                    $(`.status-pagamento-${idConta}`).removeClass('cursor-pointer');
                    $(`.status-pagamento-${idConta}`).removeAttr('data-bs-target');
                    $(`.valor-pago-${idConta}`).html(valorTotalFormatado);
                    $(`.data-pagamento-${idConta}`).html(dataPagamento);
                    $(`.tipo-status-conta-${idConta}`).removeClass('badge-phoenix-danger');
                    $(`.tipo-status-conta-${idConta}`).addClass('badge-phoenix-success');
                    $(`.icone-status-conta-${idConta}`).remove();
                    $(`.tipo-status-conta-${idConta}`).append(`<span class="uil-check ms-1 icone-status-conta-${idConta}" style="height:12.8px;width:12.8px;"></span>`);
                    $(`.status-pagamento-${idConta}`).html('Pago');

                    avisoRetorno("Sucesso!", `${data.message}`, `${data.type}`, `#`);

                }


            }

        })
    }
}
// Formatar os valores para exibição
function formatarValorExibicao(valor) {
    return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }).replace('R$', '');
}

const atualizaFrontDadosFinanceiro = () => {

    let totalPagoFront = $('.total-pago-front').html();
    let totalPago = formatarValorMoeda(totalPagoFront);

    let totalCaixaFront = $('.total-caixa-front').html();
    let totalCaixa = formatarValorMoeda(totalCaixaFront);


    let totalAbertoFront = $('.total-aberto-front').html();
    let totalAberto = formatarValorMoeda(totalAbertoFront);


    let valorTotalPago = $('.valor-total-conta').html().replace('R$', '');
    valorTotalPago = formatarValorMoeda(valorTotalPago);

    let totalPagoAtualizado = totalPago + valorTotalPago;

    let totalCaixaAtualizado = totalCaixa - valorTotalPago;

    let totalAbertoAtualizado = totalAberto - valorTotalPago;



    let totalPagoAtualizadoFormatado = formatarValorExibicao(totalPagoAtualizado);
    let totalCaixaAtualizadoFormatado = formatarValorExibicao(totalCaixaAtualizado);
    let totalAbertoAtualizadoFormatado = formatarValorExibicao(totalAbertoAtualizado);

    // Atualiza os valores no front
    $('.total-pago-front').html(totalPagoAtualizadoFormatado);
    $('.total-caixa-front').html(totalCaixaAtualizadoFormatado);
    $('.total-aberto-front').html(totalAbertoAtualizadoFormatado < 0 ? '0,00' : totalAbertoAtualizadoFormatado);
};



function formatarValorMoeda(valor) {
    return parseFloat(valor.replace(/\./g, '').replace(',', '.').replace('&nbsp;', ''));
}



$(document).on('click', '.btn-pagar-tudo', function () {

    // trata o front
    $('.proxima-etapa-pagamento').removeClass('d-none');
    $('.finalizar-varios-pagamentos').addClass('d-none');


    $('.campos-pagamentos-novos .campos-pagamento-inicio').remove();
    $('.div-pagamento-inicial').removeClass('d-none');

    // zerar campos
    $('.input-obrigatorio-inicio').each(function () {
        $(this).val('')
    })

    valoresContasPagar();

});

$(document).on('click', '.proxima-etapa-pagamento', function () {

    let permissao = verificaCamposObrigatorios('input-obrigatorio-inicio');

    if (permissao) {

        $('.proxima-etapa-pagamento').addClass('d-none');
        $('.finalizar-varios-pagamentos').removeClass('d-none');

        let quantidadeContasPagar = $('.check-aberto:checked').length;

        let divPagamentoInicial = $('.campos-pagamento-inicio').clone();

        divPagamentoInicial.removeClass('d-none');

        let valores = valoresContasPagar();

        let ids = idsContasPagar();

        let idsDadoFinanceiro = [];
        $('.check-aberto').each(function () {
            idsDadoFinanceiro.push($(this).data('id-dado-financeiro'));
        });

        let nomesEmpresas = [];
        $('.check-aberto').each(function () {
            nomesEmpresas.push($(this).data('nome-empresa'));
        });


        for (let i = 0; i < quantidadeContasPagar; i++) {

            let clone = divPagamentoInicial.clone();
            clone.find('select, input').each(function () {
                $(this).val(valores[i]);
                $(this).addClass('campo-form-' + ids[i]);
                $(this).addClass('dado-financeiro-' + idsDadoFinanceiro[i]);
            });

            let tituloCampos = $('<h5 class="my-3">').text(nomesEmpresas[i]);
            clone.prepend(tituloCampos);
            $('.campos-pagamentos-novos').append(clone);
        }

        let contaBancaria = $('.select-conta-bancaria-inicio').val();
        let formasPagamento = $('.select-forma-pagamento-inicio').val();

        $('.campos-pagamentos-novos').find('.select-conta-bancaria').val(contaBancaria);
        $('.campos-pagamentos-novos').find('.select-forma-pagamento').val(formasPagamento);

        $('.div-pagamento-inicial').addClass('d-none');
        $('.mascara-dinheiro').mask('000.000.000.000.000,00', { reverse: true });

    }

})

function valoresContasPagar() {
    let valores = [];
    let totalAberto = 0;
    $('.td-valor-aberto').each(function () {
        let valorAtual = parseFloat($(this).data('valor'));
        // Formatando o valor atual como moeda BRL sem o símbolo do Real (R$)
        let valorFormatado = valorAtual.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).replace('R$', '').trim();

        valores.push(valorFormatado);
        totalAberto += valorAtual;
    });

    let totalFormatado = totalAberto.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });

    $('.total-em-aberto-modal').html(totalFormatado);

    return valores;
}


function idsContasPagar() {

    let ids = [];
    $('.check-aberto').each(function () {
        ids.push($(this).val());
    });

    return ids;
}

function duplicarFormaPagamentoModal(event) {

    let camposForm = $(event.target).closest('.campos-pagamento-inicio');

    let clones = camposForm.find('.duplica-pagamento-multiplo').clone();
    clones.find('input').val('');
    clones.find('label').html('');

    // botão de remover
    let botaoRemover = $('<button class="botao-remover btn btn-phoenix-danger">-</button>');
    botaoRemover.click(function () {
        linhaDuplicada.remove();
    });

    let divBotaoRemover = $('<div class="col-lg-1 mt-4"></div>').append(botaoRemover);

    let linhaDuplicada = $('<div class="row linha-duplicada"></div>').append(clones, divBotaoRemover);

    linhaDuplicada.insertAfter(camposForm);

    if ($('.linha-duplicada').length === 1) {
        $('.linha-duplicada').append('<hr>');
    }
    $('.mascara-dinheiro').mask('000.000.000.000.000,00', { reverse: true });

}


function realizarVariosPagamentos() {
    let dataPagamento = $('.data-pagamento-inicio').val();

    let operacoes = [];

    $('.campos-pagamentos-novos .campos').each(function () {
        let idInput = $(this).attr('class').match(/campo-form-(\d+)/);
        let idsDadoFinanceiro = $(this).attr('class').match(/dado-financeiro-(\d+)/);
        if (idInput) {
            idInput = idInput[1];
            idsDadoFinanceiro = idsDadoFinanceiro[1];
            let observacao = $('.obs-pagamento-inicio').val()

            let operacaoExistente = operacoes.find(op => op.idConta === idInput);
            if (!operacaoExistente) {
                let novaOperacao = {
                    idConta: idInput,
                    idDadoFinanceiro: idsDadoFinanceiro,
                    formasPagamento: [],
                    contasBancarias: [],
                    valores: [],
                    dataPagamento: dataPagamento,
                    observacao: observacao
                };
                operacoes.push(novaOperacao);
                operacaoExistente = novaOperacao;
            }

            if ($(this).hasClass('forma-pagamento')) {
                operacaoExistente.formasPagamento.push($(this).val());
            } else if ($(this).hasClass('conta-bancaria')) {
                operacaoExistente.contasBancarias.push($(this).val());
            } else if ($(this).hasClass('valor-pago')) {
                operacaoExistente.valores.push($(this).val());
            }
        }
    });

    $.ajax({
        type: "post",
        url: `${baseUrl}finContasPagar/realizarMultiPagamentos`,
        data: {
            operacoes: operacoes
        }, beforeSend: function () {
            $(".load-form").removeClass("d-none");
            $(".btn-form").addClass("d-none");
        }, success: function (data) {

            $(".load-form").addClass("d-none");

            let redirect = data.type != 'error' ? `${baseUrl}finContasPagar` : '#';

            avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);
            $(".btn-form").removeClass("d-none");

        }
    })
}

const visualizarConta = (idConta) => {

    $.ajax({
        type: "post",
        url: `${baseUrl}finContasPagar/visualizarConta`,
        data: {
            idConta: idConta
        }, beforeSend: function () {
            $('.html-clean').html('');
        }, success: function (data) {

            let dataEmissao = formatarDatas(data['conta'].data_emissao);
            let dataVencimento = formatarDatas(data['conta'].data_vencimento);
            let valorConta = formatarValorExibicao(parseFloat(data['conta'].valor));
            let valorPago = formatarValorExibicao(parseFloat(data['conta'].valor_pago));

            $('.nome-empresa').html(data['conta'].RECEBIDO);
            $('.data-vencimento').html(dataVencimento);
            $('.data-emissao').html(dataEmissao);
            $('.valor-conta').html(valorConta);
            $('.obs-conta').html(data['conta'].observacao);

            if (data['conta'].valor_pago) {
                let dataPagamento = formatarDatas(data['conta'].data_pagamento);
                $('.div-valor-pago').removeClass('d-none');
                $('.valor-pago').html(valorPago);
                $('.div-data-pagamento').removeClass('d-none');
                $('.data-pagamento').html(dataPagamento);

            } else {
                $('.div-valor-pago').addClass('d-none');
            }


        }
    })

}

const deletaContaPagar = (idConta) => {

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
                type: "post",
                url: `${baseUrl}finContasPagar/deletarConta`,
                data: {
                    idConta: idConta
                }, success: function (data) {

                    let redirect = data.type != 'error' ? `${baseUrl}finContasPagar` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                }
            })

        }
    })


}
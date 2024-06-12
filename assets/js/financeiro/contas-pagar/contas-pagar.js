var baseUrl = $(".base-url").val();


$(document).on('click', '.duplicar-pagamento', function () {

    duplicarElemento();

    carregaSelect2('select2', 'modalPagarConta');
});


// duplica forma de pagamento e residuos
function duplicarElemento() {

    // Pega os options do select
    let optionsContaBancaria = $('.select-conta-bancaria-unic').html();
    let optionsFormaPagamento = $('.select-forma-pagamento-unic').html();

    let contaBancaria = `
        <div class="col-md-4 mb-2 mt-2">
            <select class="select2 form-select select-conta-bancaria-unic w-100 input-obrigatorio">
            ${optionsContaBancaria}
            </select>
            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
        </div>
    `;

    let formaPagamento = `
        <div class="col-md-4 mb-2 mt-2">
            <select class="select2 form-select select-forma-pagamento-unic w-100 input-obrigatorio">
                ${optionsFormaPagamento}
            </select>
            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
        </div>
    `;

    let inputValor = `
        <div class="col-md-3 mb-2 input-obrigatorio">
            <input class="form-control mt-2 input-valor" type="text" placeholder="Digite o valor" value="">
        </div>
        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
    `;

    let btnRemove = $(`
    <div class="col-md-1 mt-1">

        <button class="btn btn-phoenix-danger remover-inputs">-</button>

    </div>`);

    // div com row para cada grupo ficar em row diferente
    let novaLinha = $('<div class="row mb-3"></div>');

    // imprime os elementos dentro da div row
    novaLinha.append(contaBancaria);
    novaLinha.append(formaPagamento);
    novaLinha.append(inputValor);
    novaLinha.append(btnRemove);

    //remove a linha duplicada
    btnRemove.find(`.remover-inputs`).on('click', function () {

        novaLinha.remove();
    });

    $(`.campos-duplicados`).append(novaLinha);

}


const cadastraContasPagar = (classe) => {

    let idConta = $('.id-editar-conta').val();

    let dadosFormulario = {};
    let permissao = true;

    $(`.${classe}`).find(":input").each(function (index) {

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

const cadastraMultiplasContasPagar = (classe) => {
    let dadosFormulario = {};
    let permissao = true;

    $(`.${classe}`).find(":input").each(function (index) {
        let inputName = $(this).attr('name');
        let inputValue = $(this).val();

        // Inicializa o campo como um array se não estiver definido
        if (!dadosFormulario[inputName]) {
            dadosFormulario[inputName] = [];
        }

        // Adiciona o valor ao array
        dadosFormulario[inputName].push(inputValue);

        permissao = verificaCamposObrigatorios('input-obrigatorio-recorrente');
    });

    if (permissao) {
        $.ajax({
            type: "post",
            url: `${baseUrl}finContasPagar/cadastraMultiplasContasPagar`,
            data: {
                dados: dadosFormulario
            }, 
            beforeSend: function () {
                $(".load-form").removeClass("d-none");
                $(".btn-form").addClass("d-none");
            }, 
            success: function (data) {
                $(".load-form").addClass("d-none");
                $(".btn-form").removeClass("d-none");
                avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${baseUrl}finContasPagar`);
            }
        });
    }
};


$(document).on('click', '.novo-lancamento', function () {


    $('.id-editar-conta').val('');
    $('.dados-conta').val('');

    $('.select-micros').attr('disabled', true);
    $('.select-recebido').attr('disabled', true);

    carregaSelect2('select2', 'modalLancamentoContasPagar');

})

$(document).on('click', '.editar-lancamento', function () {

    carregaSelect2('select2', 'modalEditarContasPagar');

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

            $('.select-setor-empresa').val(data['conta'].id_setor_empresa).trigger('change');

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
    $('.id-dado-cliente').val($(this).data('id-dado-cliente'));
    $('.input-valor').val($(this).data('valor'));
    $('.valor-total-conta').html(`R$ ${$(this).data('valor')}`);

    carregaSelect2('select2', 'modalPagarConta');
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
        let idDadoCliente = $('.id-dado-cliente').val();

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
                idDadoCliente: idDadoCliente,
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

                    $(`.btn-editar-${idConta}`).remove();
                    $(`.btn-excluir-${idConta}`).remove();
                    $(`.btn-realizar-pagamento-${idConta}`).remove();

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

$('.select-setor').on('change',function(){
    
    $('#nomeSetor').val($(this).find('option:selected').text());
    
});

const atualizaFrontDadosFinanceiro = () => {

    let totalPagoFront = $('.total-pago-front').html();
    let totalPago = formatarValorMoeda(totalPagoFront);

    let totalCaixaFront = $('.total-caixa-front').html();
    let totalCaixa = formatarValorMoeda(totalCaixaFront);

    let totalAbertoFront = $('.total-aberto-front').html();
    let totalAberto = formatarValorMoeda(totalAbertoFront);

    let valorSetorFront = $('.total-setor-front').html();
    valorSetorFront = formatarValorMoeda(valorSetorFront);

    let valorTotalConta = $('.valor-total-conta').html().replace('R$', '');
    valorTotalConta = formatarValorMoeda(valorTotalConta);

    let valorTotalPago = 0;
    $('.input-valor-unic').each(function () {
        let valorNumerico = parseFloat($(this).val().replace('.', '').replace(',', '.'));
        valorTotalPago += valorNumerico;
    });

    let totalPagoAtualizado = totalPago + valorTotalConta;

    let totalCaixaAtualizado = totalCaixa - valorTotalPago;

    let totalAbertoAtualizado = totalAberto - valorTotalConta;

    let valorSetorFrontAtualizado = valorSetorFront - valorTotalPago;

    let totalPagoAtualizadoFormatado = formatarValorExibicao(totalPagoAtualizado);
    let totalCaixaAtualizadoFormatado = formatarValorExibicao(totalCaixaAtualizado);
    let totalAbertoAtualizadoFormatado = formatarValorExibicao(totalAbertoAtualizado);
    let valorSetorFrontAtualizadoFormatado = formatarValorExibicao(valorSetorFrontAtualizado);

    // Atualiza os valores no front
    $('.total-pago-front').html(totalPagoAtualizadoFormatado);
    $('.total-caixa-front').html(totalCaixaAtualizadoFormatado);
    $('.total-aberto-front').html(totalAbertoAtualizadoFormatado < 0 ? '0,00' : totalAbertoAtualizadoFormatado);
    $('.total-setor-front').html(valorSetorFrontAtualizadoFormatado < 0 ? '0,00' : valorSetorFrontAtualizadoFormatado);
};



function formatarValorMoeda(valor) {
    return parseFloat(valor.replace(/\./g, '').replace(',', '.').replace('&nbsp;', ''));
}


$(document).on('click', '.btn-pagar-tudo', function () {

    carregaSelect2('select2', 'modalPagarVariasContas');

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

// constas recorrentes
$(document).on('click', '.btn-proxima-etapa-lancamento', function () {

    $('.check-element').prop('checked', false);
    $('.check-all-element').prop('checked', false);

    $('.btn-excluir-contas').addClass('d-none');
    $('.btn-pagar-tudo').addClass('d-none');

    let permissao = verificaCamposObrigatorios('select-tipo-conta');

    if (permissao) {
        if ($('.select-tipo-conta').val() == "comum") {

            $('#modalLancamentoContasPagar').modal('show');

        } else {

            $('#modalSelecionarContasPagarRecorrentes').modal('show');

        }
    }
})


$(document).on('click', '.btn-proxima-etapa-recorrente', function () {

    let idsAgrupados = agruparIdsCheckbox();

    let camposContas = '';


    if (idsAgrupados.length > 0) {

        $.ajax({
            type: "post",
            url: `${baseUrl}finContasRecorrentes/recebeVariasContasRecorrentes`,
            data: {
                idsContas: idsAgrupados
            }, beforeSend: function () {
                $(".load-form").removeClass("d-none");
                $(".btn-form").addClass("d-none");
            }, success: function (data) {

                console.log(data)

                let dataAtual = new Date();
                let mesAtual = (dataAtual.getMonth());

                let anoAtual = dataAtual.getFullYear();

                $('#modalSelecionarContasPagarRecorrentes').modal('hide');

                $('#modalLancamentoContasPagarRecorrentes').modal('show');


                $(".load-form").addClass("d-none");
                $(".btn-form").removeClass("d-none");

                for (i = 0; i < data.contas.length; i++) {
                    camposContas += `
                        <div class="col-12 ${i > 0 ? 'mt-5' : ''}">${data.contas[i].RECEBIDO ?? data.contas[i].CLIENTE} (${data.contas[i].SETOR}) </div>
                        <div class="col-12 col-md-6 mt-3"> 
                            <input class="form-control input-obrigatorio-recorrente datetimepicker cursor-pointer mascara-data" type="text" placeholder="dd/mm/aaaa" data-options='{"disableMobile":true,"dateFormat":"d/m/Y"}' value="${data.contas[i].dia_pagamento}/${mesAtual}/${anoAtual}" name="data_vencimento"/>
                            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                        </div>

                        <div class="col-12 col-md-6 mt-3">
                            <input class="form-control input-obrigatorio-recorrente mascara-dinheiro" name="valor" type="text" placeholder="Valor" />
                            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                        </div>

                        <input type="hidden" class="aviso-obrigatorio" name="recebido" value="${data.contas[i].ID_RECEBIDO}">

                        <input type="hidden" class="aviso-obrigatorio" name="nome-recebido" value="${data.contas[i].RECEBIDO ?? data.contas[i].CLIENTE}">

                        <input type="hidden" class="aviso-obrigatorio" name="micros" value="${data.contas[i].ID_MICRO}">

                        <input type="hidden" class="aviso-obrigatorio" name="macros" value="${data.contas[i].id_macro}">

                        <input type="hidden" class="aviso-obrigatorio" name="setor" value="${data.contas[i].id_setor_empresa}">

                    `;
                }

                $('.lista-contas-recorrentes').html(camposContas);

                $('.datetimepicker').flatpickr({
                    dateFormat: "d/m/Y",
                    disableMobile: true,
                    allowInput: true
                });

                $('.mascara-dinheiro').mask('000.000.000.000.000,00', { reverse: true });
                $('.mascara-data').mask('00/00/0000');

            }
        })
    }
})

// Clique para selecionar todos as contas recorrentes
$(document).on('change', '.modal-dialog .check-all-modal-element', function () {
    let estaChecado = $(this).prop('checked');
    $('.check-element-modal').prop('checked', estaChecado);
    atualizarElementosChecados('.check-element-modal');
});

// Clique para selecionar um por um
$(document).on('change', '.check-element-modal', function () {
    atualizarElementosChecados('.check-element-modal');
    verificarTodosCheckboxes('.check-element-modal', '.check-all-modal-element');
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

            let dataEmissao = data['conta'].data_emissao ? formatarDatas(data['conta'].data_emissao) : "";
            let dataVencimento = formatarDatas(data['conta'].data_vencimento);
            let valorConta = formatarValorExibicao(parseFloat(data['conta'].valor));
            let valorPago = formatarValorExibicao(parseFloat(data['conta'].valor_pago));

            if (data['conta'].RECEBIDO) {
                $('.nome-empresa').html(data['conta'].RECEBIDO);
            } else {
                $('.nome-empresa').html(data['conta'].CLIENTE);
            }

            $('.setor-empresa').html(data['conta'].SETOR);
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

    let idsAgrupados = agruparIdsCheckbox();

    if (idsAgrupados.length >= 2) {
        var ids = idsAgrupados;
    } else {
        var ids = [idConta];
    }

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
                    ids: ids
                }, success: function (data) {

                    let redirect = data.type != 'error' ? `${baseUrl}finContasPagar` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                }
            })

        }
    })


}
$(document).on('click', '.btn-prestar-contas', function () {

    $('.id-setor-empresa').val($(this).data('id-setor-empresa'));

    let nextTab = new bootstrap.Tab($('.btn-custos'));
    nextTab.show();

    $(`.campos-duplicados`).html('');

    carregaSelect2('select2', 'modalPrestarConta');

    $('.codigo-romaneio').val($(this).data('codigo'));

    $('.nome-funcionario').html($(this).data('funcionario'));
    $('.saldo-funcionario').html(formatarValorMoeda($(this).data('saldo')));

    $('.input-saldo-funcionario').val($(this).data('saldo'));

    $('.id-funcionario').val($(this).data('id-funcionario'));

    $('.total-troco').html('');
    $('.campos-duplicados').html('');
});


$(document).on('click', '.duplicar-custo', function () {
    duplicarCustos();
    carregaSelect2('select2', 'modalPrestarConta');

});


function duplicarCustos() {
    // Pega os options do select
    let optionsTiposCustos = $('.select-tipos-custos').html();
    let optionsRecebidos = $('.select-recebido').html();
    let optionsMacros = $('.select-macros-prestacao').html();
    let optionsMicros = $('.select-micros-prestacao').html();

    let selectMacros = `
        <div class="col-lg-6 mb-2 mt-2 div-tipo-pagamento-duplicado">
            <div class="mb-4 ">
                <label class="text-body-highlight fw-bold mb-2">Grupos Macros</label>
                <select class="form-select select2 select-macros-prestacao input-obrigatorio-custo dados-conta" name="id_macro">
                    ${optionsMacros}
                </select>
                <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                <input type="hidden" name="nome-recebido" class="nome-recebido">
            </div>
        </div>
    `;

    let selectMicros = `
        <div class="col-lg-6 mb-2 mt-2 div-tipo-pagamento-duplicado">
            <div class="mb-4 ">
                <label class="text-body-highlight fw-bold mb-2">Grupos Micros</label>
                <select disabled class="form-select select2 select-micros-prestacao input-obrigatorio-custo dados-conta" name="id_micro">
                    ${optionsMicros}
                </select>
                <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                <input type="hidden" name="nome-recebido" class="nome-recebido">
            </div>
        </div>
    `;

    let selectTipoPagamento = `
        <div class="col-lg-6 mb-2 mt-2 div-tipo-pagamento-duplicado">
            <div class="mb-4 ">
                <label class="text-body-highlight fw-bold mb-2">Tipo de Pagamento</label>
                <select class="form-select select2 select-tipo-pagamento input-obrigatorio-custo dados-conta" name="tipo-pagamento">
                    <option selected disabled value="">Selecione</option>
                    <option value="ato" data-tipo="0">Pagamento no Ato</option>
                    <option value="prazo" data-tipo="1">Pagamento a Prazo</option>
                </select>
                <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                <input type="hidden" name="nome-recebido" class="nome-recebido">
            </div>
        </div>
    `;

    let selectRecebidos = `
        <div class="col-lg-4 mb-2 mt-2">
            <div class="mb-4 ">
                <label class="text-body-highlight fw-bold mb-2">Recebido</label>
                <select class="form-select select2 select-recebido dados-conta" name="recebido">
                    ${optionsRecebidos}
                </select>
                <div class="d-none aviso-obrigatorio">Preencha este campo</div>
                <input type="hidden" name="nome-recebido" class="nome-recebido">
            </div>
        </div>
    `;

    let tiposCustos = `
        <div class="col-md-6 mb-2 mt-2">
            <label class="text-body-highlight fw-bold mb-2">Tipo de custo</label>
            <select class="select2 form-select w-100 input-obrigatorio-custo select-tipos-custos" name="tipos-custos">
                ${optionsTiposCustos}
            </select>
            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
        </div>
    `;

    let inputValor = `
        <div class="col-md-4 mb-2">
            <label class="text-body-highlight fw-bold mb-2">Valor</label>
            <input name="valor" class="form-control mt-2 input-valor mascara-dinheiro input-obrigatorio-custo" type="text" placeholder="Digite o valor" value="">
            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
        </div>
    `;

    let dataPagamento = `
         <div class="col-lg-4 mb-2 mt-2">
            <div class="mb-4">
                <label class="text-body-highlight fw-bold mb-2">Data Para pagamento</label>
                <input disabled autocomplete="off" class="form-control datetimepicker data-pagamento input-obrigatorio-custo" required type="text" placeholder="Escolha uma Data" data-options='{"disableMobile":true,"allowInput":true, "dateFormat":"d/m/Y"}' style="cursor: pointer;" autocomplete="off" />
                <div class="d-none aviso-obrigatorio">Preencha este campo</div>
            </div>
        </div>
    `;

    let btnRemove = $(`
    <div class="mt-1 text-end add-botao-mais">
        <button class="btn btn-phoenix-danger remover-inputs">-</button>
        <button title="Mais custos" type="button" class="btn btn-phoenix-success duplicar-custo">+</button>
    </div>`);

    // div com row para cada grupo ficar em row diferente
    let novaLinha = $('<div class="row mb-3 campos-pretacao"></div>');

     // Remove o botão + da linha atual
     $('.duplicar-custo').last().hide();

    // Imprime os elementos dentro da nova linha
    novaLinha.append('<hr>');
    novaLinha.append(selectMacros);
    novaLinha.append(selectMicros);
    novaLinha.append(selectTipoPagamento);
    novaLinha.append(tiposCustos);
    novaLinha.append(selectRecebidos);
    novaLinha.append(inputValor);
    novaLinha.append(dataPagamento);
    novaLinha.append(btnRemove);

    // Adiciona a nova linha aos campos duplicados
    $(`.campos-duplicados-prestacao-contas`).append(novaLinha);

    novaLinha.find('.select-micros-prestacao').val('').trigger('change'); // deixa vazio o select de micros

     // Remove a linha duplicada
     btnRemove.find(`.remover-inputs`).on('click', function () {
        novaLinha.remove();
        atualizarSaldoFuncionario();

        // Reaparece o botão + na última linha existente
        $('.duplicar-custo').last().show();
    });

    // Adiciona a máscara de dinheiro aos campos apropriados
    $('.mascara-dinheiro').mask('000.000.000.000.000,00', { reverse: true });

    $('.datetimepicker').flatpickr({
        dateFormat: "d/m/Y",
        disableMobile: true
    });
}


$(document).on('focusout', '.input-valor', function () {
    atualizarSaldoFuncionario();
});

$(document).on('change', '.select-recebido', function () {
    let dataFormatada = formatarDatas($(this).find('option:selected').data('faturamento'));
    let tipoPagamento = $(this).closest('.campos-pretacao').find('.select-tipo-pagamento').val();

    if (tipoPagamento == "prazo") {
        $(this).closest('.campos-pretacao').find('.select-recebido').addClass('input-obrigatorio-custo');
        $(this).closest('.campos-pretacao').find('.data-pagamento').attr('disabled', false);
        $(this).closest('.campos-pretacao').find('.data-pagamento').val(dataFormatada);
    } else {
        $(this).closest('.campos-pretacao').find('.select-recebido').removeClass('input-obrigatorio-custo');
        $(this).closest('.campos-pretacao').find('.data-pagamento').attr('disabled', true);
        $(this).closest('.campos-pretacao').find('.data-pagamento').val('');
        atualizarSaldoFuncionario();
    }
});

$(document).on('change', '.select-tipo-pagamento', function () {
    let tipoPagamento = $(this).find('option:selected').val();

    if (tipoPagamento == "prazo") {
    
        $(this).closest('.campos-pretacao').find('.select-recebido').addClass('input-obrigatorio-custo');
        $(this).closest('.campos-pretacao').find('.data-pagamento').attr('disabled', false);
        $(this).closest('.campos-pretacao').find('.data-pagamento').addClass('input-obrigatorio-custo');
        let dataFaturamento = $(this).closest('.campos-pretacao').find('.select-recebido option:selected').data('faturamento');
        atualizarSaldoFuncionario();

        if (dataFaturamento) {
            let dataFormatada = formatarDatas(dataFaturamento);
            $(this).closest('.campos-pretacao').find('.data-pagamento').val(dataFormatada);
        }

    } else {

        $(this).closest('.campos-pretacao').find('.data-pagamento').attr('disabled', true);
        $(this).closest('.campos-pretacao').find('.data-pagamento').val('');
        $(this).closest('.campos-pretacao').find('.data-pagamento').removeClass('input-obrigatorio-custo');
        $(this).closest('.campos-pretacao').find('.data-pagamento').next().addClass('d-none');
        $(this).closest('.campos-pretacao').find('.data-pagamento').removeClass('invalido');
        $(this).closest('.campos-pretacao').find('.select-recebido').removeClass('input-obrigatorio-custo');
        $(this).closest('.campos-pretacao').find('.select-recebido').next().next().addClass('d-none');
        $(this).closest('.campos-pretacao').find('.select-recebido').next().removeClass('select2-obrigatorio');
        atualizarSaldoFuncionario();
    }
});

function atualizarSaldoFuncionario() {

    let saldoTotalFuncionario = parseFloat($('.input-saldo-funcionario').val());
    let saldoAtual = saldoTotalFuncionario;

    $('.input-valor').each(function () {

        let tipoPagamento = $(this).closest('.campos-pretacao').find('.select-tipo-pagamento option:selected').val();

        if (tipoPagamento == "ato") {

            let valorGasto = $(this).val().replace(/\./g, '').replace(',', '.');

            valorGasto = parseFloat(valorGasto);

            if (!isNaN(valorGasto)) {
                
                saldoAtual = saldoAtual - valorGasto;
            }
        }
    });

    if (!isNaN(saldoAtual)) {
                
        let valorTroco = formatarValorMoeda(saldoAtual);
        $('.saldo-funcionario').html(valorTroco);
        $('.valor-troco-parcial').val(valorTroco); // grava o troco para fazer o calculo com mais pagamentos
    }
}


$(function () {

    $('.btn-proxima-etapa, .btn-troco').on('click', function () {

        let permissao = verificaCamposObrigatorios('input-obrigatorio-custo');

        if (permissao) {

            $('.btn-proxima-etapa').html('Finalizar');
            $('.btn-proxima-etapa').attr('onclick', 'salvarPrestacaoContas()');

            $('.btn-troco').attr('disabled', false);

            $('#btn-voltar-etapa').removeClass('d-none');
            let nextTab = new bootstrap.Tab($('.btn-troco'));
            nextTab.show();
        } else {
            $('.btn-troco').attr('disabled', true);

        }

    });

    $('#btn-voltar-etapa, .btn-custos').on('click', function () {

        $('#btn-voltar-etapa').addClass('d-none');

        $('.btn-proxima-etapa').html('Próxima Etapa');

        $('.btn-proxima-etapa').removeAttr('onclick');


        let prevTab = new bootstrap.Tab($('.btn-custos'));
        prevTab.show();
    });

});



const salvarPrestacaoContas = () => {

    let saldoTrocoFuncionario = $('.valor-troco-parcial').val().replace(/[^\d-]/g, '');
    saldoTrocoFuncionario = parseFloat(saldoTrocoFuncionario);

    if (saldoTrocoFuncionario < 0) {
        avisoRetorno('Algo deu errado!', 'O saldo do responsável não pode ser negativo.', 'error', '#');
        return;
    }

    // dados para tabela prestacao de contas
    let dadosPrestacaoContas = {
        idTipoCusto: [],
        idRecebido: [],
        valor: [],
        macros: [],
        micros: [],
        dataPagamento: [],
        tipoPagamento: []
    };

    // dados do troco devolvido
    let dadosTrocoFuncionario = {
        valor: $('.valor-troco').val(),
        contaBancaria: $('.conta-bancaria-troco').val(),
        formaPagamentoTroco: $('.forma-pagamento-troco').val()
    }

    $('.campos-pretacao').each(function () {
        
        let tipoPagamento = $(this).find('.select-tipo-pagamento'); 
        let tipoCusto = $(this).find('.select-tipos-custos').val();
        let recebido = $(this).find('.select-recebido').val();
        let valor = $(this).find('.input-valor').val();
        let dataPagamento = $(this).find('.data-pagamento').val();
        let macro = $(this).find('.select-macros-prestacao').val();
        let micro = $(this).find('.select-micros-prestacao').val();

        dadosPrestacaoContas.idTipoCusto.push(tipoCusto);
        dadosPrestacaoContas.idRecebido.push(recebido);
        dadosPrestacaoContas.valor.push(valor);
        dadosPrestacaoContas.macros.push(macro);
        dadosPrestacaoContas.micros.push(micro);
        dadosPrestacaoContas.dataPagamento.push(dataPagamento ?? '');
        dadosPrestacaoContas.tipoPagamento.push(tipoPagamento.find('option:selected').data('tipo'));

    });

    let permissao = verificaCamposObrigatorios('input-obrigatorio-modal');

    if (permissao) {

        finalizarPrestacaoContas(dadosPrestacaoContas, dadosTrocoFuncionario);

    }

}

const finalizarPrestacaoContas = (dadosPrestacaoContas, dadosTrocoFuncionario) => {

    let codigoRomaneio = $('.codigo-romaneio').val();
    let idFuncionario =  $('.id-funcionario').val();  
    let idSetorEmpresa = $('.id-setor-empresa').val();  

    $.ajax({
        type: "post",
        url: `${baseUrl}finPrestacaoContas/cadastraPrestacaoContas`,
        data: {
            idFuncionario: idFuncionario,
            codigoRomaneio: codigoRomaneio,
            dadosPrestacaoContas: dadosPrestacaoContas,
            dadosTroco: dadosTrocoFuncionario,
            idSetorEmpresa: idSetorEmpresa

        }, beforeSend: function () {
            $('.btn-form').addClass('d-none');
            $('.load-form').removeClass('d-none');
        }, success: function (data) {

            $('.btn-form').removeClass('d-none');
            $('.load-form').addClass('d-none');

            let redirect = data.success ? `${baseUrl}romaneios` : '#';

            avisoRetorno(data.title, data.message, data.type, redirect);

        }
    })
    
}


$(document).on('change', '.data-romaneio', function () {

    let idFuncionario = $('.id-funcionario').val();
    let dataRomaneio = $(this).val();

    $.ajax({
        type: "post",
        url: `${baseUrl}finPrestacaoContas/recebeDatasRomaneiosFuncionario`,
        data: {
            idFuncionario: idFuncionario,
            dataRomaneio: dataRomaneio,
        }, success: function (data) {

            if (!data) {
                avisoRetorno('Algo deu errado!', 'Não existe romaneio para esse funcionário com essa data.', 'error', '#');
                $('.btn-salvar-prestacao').addClass('d-none');

            } else {
                $('.btn-salvar-prestacao').removeClass('d-none');
            }

        }
    })

})



$(document).on('focusout', '.input-valor', function () {
    let saldoTotalFuncionario = parseFloat($('.input-saldo-funcionario').val().replace(',', '.'));
    let valorTotal = 0;

    $('.input-valor').each(function () {
        let valor = parseFloat($(this).val().replace(',', '.'));
        if (!isNaN(valor)) {
            valorTotal += valor;
        }
    });

    let valorTroco = saldoTotalFuncionario - valorTotal;

    $('.total-troco').html('Troco: ' + valorTroco.toFixed(2).replace('.', ','));
});


$(document).on('change', '.select-macros-prestacao', function () {

    let idMacro = $(this).val();

    let selectMicro = $(this).closest('.campos-pretacao').find('.select-micros-prestacao');

    $.ajax({
        type: "post",
        url: `${baseUrl}finMicro/recebeMicrosMacro`,
        data: {
            idMacro: idMacro
        }, beforeSend: function () {
            selectMicro.html('<option disabled>Selecione</option>');
        }, success: function (data) {

            selectMicro.attr('disabled', false);

            let options = '<option value="" disabled >Selecione</option>';

            for (i = 0; i < data.microsMacro.length; i++) {

                options += `<option value="${data.microsMacro[i].id}">${data.microsMacro[i].nome}</option>`;
            }

            selectMicro.html(options);

            selectMicro.val('').trigger('change');

        }
    })
})

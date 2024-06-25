$(document).on('click', '.btn-prestar-contas', function () {

    carregaSelect2('select2', 'modalPrestarConta');

    $('.nome-funcionario').html($(this).data('funcionario'));
    $('.saldo-funcionario').html(`R$ ${$(this).data('saldo')}`);

    $('.input-saldo-funcionario').val($(this).data('saldo'));

    $('.id-funcionario').val($(this).data('id'));

    $('.total-troco').html('');
});

$(document).on('click', '.duplicar-pagamento', function () {

    duplicarElemento();

    carregaSelect2('select2', 'modalPrestarConta');
});


// duplica forma de pagamento e residuos
function duplicarElemento() {

    // Pega os options do select
    let optionsTiposCustos = $('.select-tipos-custos').html();

    let tiposCustos = `
        <div class="col-md-6 mb-2 mt-2">
            <select class="select2 form-select w-100 input-obrigatorio-modal select-tipos-custos" name="tipos-custos">
                ${optionsTiposCustos}
            </select>
            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
        </div>
    `;

    let inputValor = `
        <div class="col-md-4 mb-2">
            <input name="valor" class="form-control mt-2 input-valor mascara-dinheiro input-obrigatorio-modal" type="text" placeholder="Digite o valor" value="">
            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
        </div>
    `;

    let btnRemove = $(`
    <div class="col-md-2 mt-1">

        <button class="btn btn-phoenix-danger remover-inputs">-</button>

    </div>`);

    // div com row para cada grupo ficar em row diferente
    let novaLinha = $('<div class="row mb-3"></div>');

    // imprime os elementos dentro da div row
    novaLinha.append(tiposCustos);
    novaLinha.append(inputValor);
    novaLinha.append(btnRemove);

    //remove a linha duplicada
    btnRemove.find(`.remover-inputs`).on('click', function () {

        novaLinha.remove();
    });

    $(`.campos-duplicados`).append(novaLinha);
    $('.mascara-dinheiro').mask('000.000.000.000.000,00', { reverse: true });


}

const salvarPrestacaoContas = () => {

    let permissao = verificaCamposObrigatorios('input-obrigatorio-modal');

    let tiposCustos = $('.select-tipos-custos').map(function () {
        return $(this).val();
    }).get();

    let valores = $('.input-valor').map(function () {
        return $(this).val();
    }).get();

    let idFuncionario = $('.id-funcionario').val();
    let dataRomaneio = $('.data-romaneio').val();
    let obs = $('.observacao').val();
    let macro = $('.select-macros').val();
    let micro = $('.select-micros').val();
    let valorDevolvido = $('.valor-devolvido').val();
    let contaBancaria = $('.select-conta-bancaria').val();
    let formaPagamento = $('.select-forma-pagamento').val();

    if (permissao) {
        $.ajax({
            type: "post",
            url: `${baseUrl}finPrestacaoContas/cadastraPrestacaoContas`,
            data: {
                tiposCustos: tiposCustos,
                valores: valores,
                idFuncionario: idFuncionario,
                dataRomaneio: dataRomaneio,
                macro: macro,
                micro: micro,
                valorDevolvido: valorDevolvido,
                contaBancaria: contaBancaria,
                formaPagamento: formaPagamento,
                observacao: obs
            }, beforeSend: function () {
                $(".load-form").removeClass("d-none");
				$(".btn-form").addClass("d-none");

            }, success: function (data) {

                $(".load-form").addClass("d-none");
				$(".btn-form").removeClass("d-none");

                let redirect = data.success ? `${baseUrl}finPrestacaoContas` : '#';
                
                avisoRetorno(data.title, data.message, data.type, redirect);

            }
        })
    }


}

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

    $('.input-valor').each(function() {
        let valor = parseFloat($(this).val().replace(',', '.'));
        if (!isNaN(valor)) {
            valorTotal += valor;
        }
    });

    let valorTroco = saldoTotalFuncionario - valorTotal;
    
    $('.total-troco').html('Troco: ' + valorTroco.toFixed(2).replace('.', ','));
});

$(document).on('click', '.btn-nova-venda', function () {

    carregaSelect2('select2', 'modalNovaVenda');

})

$(document).on('change', '.select-unidade-medida', function () {
    let unidadeMedidaSelecionada = $(this).find('option:selected').html();
    $('.nome-unidade-medida').html(unidadeMedidaSelecionada);
    $('.input-valor-unidade-medida').attr('placeholder', `Valor por ${unidadeMedidaSelecionada}`);
})


$(document).on('focusout', '.input-quantidade-venda, .input-valor-unidade-medida, .input-desconto-venda', function () {

    let valorUnidadeMedida = $('.input-valor-unidade-medida').val();
    valorUnidadeMedida = parseFloat(valorUnidadeMedida.replace(/\./g, '').replace(',', '.'));

    let quantidade = $('.input-quantidade-venda').val();
    let valorTotalVenda = valorUnidadeMedida * quantidade;
    let porcentagemDescontoVenda = $('.input-desconto-venda').val();

    if (porcentagemDescontoVenda) {
        valorTotalVenda = valorTotalVenda - (valorTotalVenda * porcentagemDescontoVenda / 100);
    }

    $('.input-valor-total').val(formatarValorMoeda(valorTotalVenda).replace(/^R\$\s*/, ''));
})

$(document).on('focusout', '.input-desconto-parcela-venda', function () {

    let valorUnidadeMedida = $('.input-valor-unidade-medida').val();
    valorUnidadeMedida = parseFloat(valorUnidadeMedida.replace(/\./g, '').replace(',', '.'));

    let quantidade = $('.input-quantidade-venda').val();
    let valorTotalParcelaVenda = valorUnidadeMedida * quantidade;
    let porcentagemDescontoParcelaVenda = $(this).val();

    if (porcentagemDescontoParcelaVenda) {
        valorTotalParcelaVenda = valorTotalParcelaVenda - (valorTotalParcelaVenda * porcentagemDescontoParcelaVenda / 100);
    }

    $(this).closest('.col-md-4').next().find('.input-valor-parcela-adicional').val(formatarValorMoeda(valorTotalParcelaVenda).replace(/^R\$\s*/, ''));

})


$(document).on('click', '.btn-proximo', function () {
    
    verificaCamposObrigatorios('input-obrigatorio-venda');

    if ($('.etapa-venda').hasClass('active')) {
        $('.btn-proximo').addClass('btn-finalizar');
    } else {
        $('.btn-proximo').removeClass('btn-finalizar');
    }

})

$(document).on('click', '.btn-finalizar', function () {

    let permissao = verificaCamposObrigatorios('input-obrigatorio-venda');

    if (permissao) {

        let valorVenda = [];
        $('.input-valor-venda').each(function () {
        
            valorVenda.push($(this).val().replace(/R\$\s?/, ''));
        })

        let vencimentoParcelas = [];
        $('.input-data-vencimento').each(function () {
        
            vencimentoParcelas.push($(this).val());
        })

        let cliente = $('.select-cliente').val();
        let residuo = $('.select-residuo-venda').val();
        let unidadeMedida = $('.select-unidade-medida').val();
        let quantidade = $('.input-quantidade-venda').val();
        let porcentagemDescontoVenda = $('.input-desconto-venda').val();
        let dataDestinacao = vencimentoParcelas;
        let valorUnidadeMedida = $('.input-valor-unidade-medida').val();
        let macro = $('.select-macros').val();
        let micro = $('.select-micros').val();
        let setorEmpresa = $('.select-setor-empresa-venda').val();
        let contaBancaria = $('.select-conta-bancaria').val();
        let formaRecebimento = $('.select-forma-recebimento').val();
        let parcelas = $('.select-parcela').val();

        $.ajax({
            type: "post",
            url: `${baseUrl}vendas/novaVendaResiduo`,
            data: {
                setorEmpresa: setorEmpresa,
                cliente: cliente,
                residuo: residuo,
                unidadeMedida: unidadeMedida,
                quantidade: quantidade,
                porcentagemDescontoVenda: porcentagemDescontoVenda,
                dataDestinacao: dataDestinacao,
                valorUnidadeMedida: valorUnidadeMedida,
                macro: macro,
                micro: micro,
                contaBancaria: contaBancaria,
                valorVenda: valorVenda,
                parcelas: parcelas,
                formaRecebimento: formaRecebimento
            },
            beforeSend: function () {
                $('.btn-form').addClass('d-none');
                $('.load-form').removeClass('d-none');
            },
            success: function (response) {
                $('.btn-form').removeClass('d-none');
                $('.load-form').addClass('d-none');

                let segment1 = $('.segment-1').val();

                let redirect = response.type == 'error' ? '#' : `${baseUrl}${segment1 == 'estoqueResiduos' ? 'estoqueResiduos' : 'vendas/residuos'}`;

                avisoRetorno(response.title, response.message, response.type, redirect);

            },
            error: function (xhr, status, error) {
                avisoRetorno(`Erro ${xhr.status}`, `Entre em contato com o administrador.`, 'error', `${baseUrl}/estoqueResiduos`);
            }
        });
    }

    
})

const deletarVendaResiduo = (idVenda) => {


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
                type: 'post',
                url: `${baseUrl}vendas/deletaVendaResiduo`,
                data: {
                    idVenda: idVenda
                }, success: function (data) {

                    let redirect = data.redirect ? `${baseUrl}vendas/residuos` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                }
            })

        }
    })

}

$(document).on('change', '#check-agendar-recebimento', function () {
    let isChecked = $(this).is(':checked');
    $('.label-data').html(isChecked ? 'Data de Vencimento' : 'Data da Venda');
    $('.div-contas-receber').toggleClass('d-none', isChecked);
    $('.div-contas-receber').find(':input').toggleClass('input-obrigatorio-venda', !isChecked);

    if (isChecked) {
        $('.div-contas-receber').find(':input').val('').trigger('change');
        $('.div-select-cliente').removeClass('col-lg-12');
        $('.div-select-cliente').addClass('col-lg-6');
        $('.div-select-parcelas').removeClass('d-none');
    } else {
        $('.select-parcela').val('1').trigger('change');
        $('.div-select-parcelas').addClass('d-none');
        $('.div-select-cliente').addClass('col-lg-12');
        $('.div-select-cliente').removeClass('col-lg-6');
    }
});

$(document).on('change', '.select-macros', function () {

    let idMacro = $(this).val();

    $.ajax({
        type: "post",
        url: `${baseUrl}finMicro/recebeMicrosMacro`,
        data: {
            idMacro: idMacro
        }, beforeSend: function () {
            $('.select-micros').attr('disabled', true);
            $('.select-micros').html('<option disabled>Carregando...</option>');

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

$(document).on('change', '.input-data-primeira-parcela', function () {

    let quantidadeParcela = 2;
    let dataBR = $(this).val(); // formato DD/MM/YYYY
    let [dia, mes, ano] = dataBR.split("/"); // separa dia, mês e ano
    let dataPrimeiraParcela = new Date(`${ano}-${mes}-${dia}`); // formata para YYYY-MM-DD

    $('.input-data-parcela-adicional').each(function () {
        let dataParcelaAtual = new Date(dataPrimeiraParcela);

        // Incrementa o mês com base na quantidadeParcela - 1 para cada input
        dataParcelaAtual.setMonth(dataParcelaAtual.getMonth() + (quantidadeParcela - 1));

        let dia = String(dataParcelaAtual.getDate() + 1).padStart(2, '0');
        let mes = String(dataParcelaAtual.getMonth() + 1).padStart(1, '0');
        let ano = dataParcelaAtual.getFullYear();
        let dataFormatada = `${dia}/${mes}/${ano}`;

        $(`.input-data-parcela-${quantidadeParcela}`).val(dataFormatada);

        quantidadeParcela++;
    });
});


$(document).on('focusout', '.input-valor-primeira-parcela', function () {

    $('.input-valor-parcela-adicional').val($(this).val())
})

$(document).on('change', '.select-parcela', function () {

    let quantidadeParcelas = $(this).val();

    if (quantidadeParcelas > 1) {

        $('.div-resumo-parcelas').removeClass('d-none');
        $('.text-resumo-parcelas').removeClass('d-none');
        $('.text-primeira-parcela').removeClass('d-none');
        $('.div-total-venda').addClass('d-none');
        $('.label-data').html('Data de Vencimento');

        let divDataVencimento = $('.div-input-data-vencimento').clone();
        let divValor = $('.div-input-valor').clone();
        let divDesconto = $('.div-input-desconto').clone();

        let htmlParcelas = ``;
        for (i = 2; i <= quantidadeParcelas; i++) {

            if (i != 1) {
                divDataVencimento.find('input').removeClass('input-data-primeira-parcela');
                divDataVencimento.find('input').addClass('input-data-parcela-adicional input-data-parcela-' + i);
                divValor.find('input').removeClass('input-valor-primeira-parcela input-valor-total');
                divValor.find('input').addClass('input-valor-parcela-adicional');
                divDesconto.find('input').addClass('input-desconto-parcela-venda');
            }

            htmlParcelas += `<div class="col-12 mb-2">${i}ª Parcela </div>`;
            htmlParcelas += `<div class="col-md-4 col-12">${divDataVencimento.html()}</div>`;
            htmlParcelas += `<div class="col-md-4 col-12">${divDesconto.html()}</div>`;
            htmlParcelas += `<div class="col-md-4 col-12">${divValor.html()}</div>`;
            htmlParcelas += '<hr>';
        }

        $('.resumo-parcelas').html(htmlParcelas);

        $('.datetimepicker').flatpickr({
            dateFormat: "d/m/Y",
            disableMobile: true,
            allowInput: true
        });

        $('.mascara-dinheiro').mask('000.000.000.000.000,00', { reverse: true });
        $('.mascara-data').mask('00/00/0000');

    } else {

        let agendarVenda = $('#check-agendar-recebimento').is(':checked');

        $('.label-data').html(`${agendarVenda ? 'Data de Vencimento' : 'Data da Venda'}`);
        $('.resumo-parcelas').find('input').remove();
        $('.div-resumo-parcelas').addClass('d-none');
        $('.text-resumo-parcelas').addClass('d-none');
        $('.text-primeira-parcela').addClass('d-none');
    }

})
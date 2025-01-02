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

    $('.input-valor-total').val(formatarValorMoeda(valorTotalVenda).replace('R$ ', ''));
})

const salvarNovaVenda = () => {

    let permissao = verificaCamposObrigatorios('input-obrigatorio-venda');

    if (permissao) {

        let cliente = $('.select-cliente').val();
        let residuo = $('.select-residuo-venda').val();
        let unidadeMedida = $('.select-unidade-medida').val();
        let quantidade = $('.input-quantidade-venda').val();
        let valorTotal = $('.input-valor-total').val();
        valorTotal = valorTotal.replace(/R\$\s?/, '').replace(',', '.');
        let porcentagemDescontoVenda = $('.input-desconto-venda').val();
        let dataDestinacao = $('.input-data-destinacao').val();
        let valorUnidadeMedida = $('.input-valor-unidade-medida').val();
        let macro = $('.select-macros').val();
        let micro = $('.select-micros').val();
        let setorEmpresa = $('.select-setor-empresa').val();
        let contaBancaria = $('.select-conta-bancaria').val();
        let formaRecebimento = $('.select-forma-recebimento').val();

        $.ajax({
            type: "post",
            url: `${baseUrl}vendas/novaVendaResiduo`,
            data: {
                setorEmpresa: setorEmpresa,
                cliente: cliente,
                residuo: residuo,
                unidadeMedida: unidadeMedida,
                quantidade: quantidade,
                valorTotal: valorTotal,
                porcentagemDescontoVenda: porcentagemDescontoVenda,
                dataDestinacao: dataDestinacao,
                valorUnidadeMedida: valorUnidadeMedida,
                macro: macro,
                micro: micro,
                contaBancaria: contaBancaria,
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

}

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
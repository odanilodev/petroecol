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

        $.ajax({
            type: "post",
            url: `${baseUrl}vendas/novaVendaResiduo`,
            data: {
                cliente: cliente,
                residuo: residuo,
                unidadeMedida: unidadeMedida,
                quantidade: quantidade,
                valorTotal: valorTotal,
                porcentagemDescontoVenda: porcentagemDescontoVenda,
                dataDestinacao: dataDestinacao,
                valorUnidadeMedida: valorUnidadeMedida
            },
            beforeSend: function () {
                $('.btn-form').addClass('d-none');
                $('.load-form').removeClass('d-none');
            },
            success: function (response) {
                $('.btn-form').removeClass('d-none');
                $('.load-form').addClass('d-none');

                let redirect = response.type == 'error' ? '#' : `${baseUrl}estoqueResiduos`;

                avisoRetorno(response.title, response.message, response.type, redirect);

            },
            error: function (xhr, status, error) {
                avisoRetorno(`Erro ${xhr.status}`, `Entre em contato com o administrador.`, 'error', `${baseUrl}/estoqueResiduos`);
            }
        });
    }

}

const deletarVendaResiduo = (idVenda) => {

    alert(idVenda); return;


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
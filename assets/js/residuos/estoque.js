const inserirLancamentoEstoqueResiduos = (dadosResiduos) => {

    $.ajax({
        type: "post",
        url: `${baseUrl}estoqueResiduos/insereEstoqueResiduos`,
        data: {
            dadosResiduos: dadosResiduos
        },
        beforeSend: function () {
            $('.load-form-modal').removeClass('d-none');
            $('.btn-form-modal').addClass('d-none');
        },
        success: function (response) {
            $('.load-form-modal').addClass('d-none');
            $('.btn-form-modal').removeClass('d-none');
            avisoRetorno(response.title, response.message, response.type, `${baseUrl}estoqueResiduos/`);

        },
        error: function (xhr, status, error) {
            $('.load-form-modal').addClass('d-none');
            $('.btn-form-modal').removeClass('d-none');
            avisoRetorno(`Erro ${xhr.status}`, `Entre em contato com o administrador.`, 'error', `#`);
        }
    });
}


$(document).on('click', '.btn-nova-venda', function () {

    carregaSelect2('select2', 'modalNovaVenda');

})


$(document).on('change', '.select-unidade-medida', function () {
    $('.tipo-unidade-medida').html(`por ${$(this).find(':selected').text()}`);
    $('.input-valor').attr('placeholder', `Valor por ${$(this).find(':selected').text()}`)
})

const salvarNovaVenda = () => {

    let permissao = verificaCamposObrigatorios('input-obrigatorio-venda');

    if (permissao) {

        let cliente = $('.select-cliente').val();
        let residuo = $('.select-residuo-venda').val();
        let unidadeMedida = $('.select-unidade-medida').val();
        let quantidade = $('.input-quantidade-venda').val();
        let valorUnidadeMedida = $('.input-valor').val();
        let valorTotal = $('.input-valor-total').val();
        let dataDestinacao = $('.input-data-destinacao').val();

        $.ajax({
            type: "post",
            url: `${baseUrl}vendas/novaVendaResiduo`,
            data: {
                cliente: cliente,
                residuo: residuo,
                unidadeMedida: unidadeMedida,
                quantidade: quantidade,
                valorUnidadeMedida: valorUnidadeMedida,
                valorTotal: valorTotal,
                dataDestinacao: dataDestinacao
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
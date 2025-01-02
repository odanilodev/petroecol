const inserirLancamentoEstoqueResiduos = () => {

    let tipoLancamento = $('.select-tipo-lancamento').val();
    let residuo = $('.select-residuo').val();
    let quantidade = $('.input-quantidade').val();
    
    $.ajax({
        type: "post",
        url: `${baseUrl}estoqueResiduos/insereEstoqueResiduos`,
        data: {
            tipoLancamento: tipoLancamento,
            residuo: residuo,
            quantidade: quantidade
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


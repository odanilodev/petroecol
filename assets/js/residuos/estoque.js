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

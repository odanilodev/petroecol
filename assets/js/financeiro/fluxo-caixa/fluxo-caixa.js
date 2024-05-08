
$(document).on('change', '.select-tipo-conta', function () {

    if ($(this).val() == 'entrada') {
        $('.label-forma-pagamento').html('Forma de recebimento');
    } else {
        $('.label-forma-pagamento').html('Forma de pagamento');

    }
})

$(document).ready(function () {
    // Quando o botão de salvar for clicado
    $('.btn-form').click(function (e) {
        e.preventDefault(); // Previne o comportamento padrão do formulário

        // Coleta os dados do formulário
        var dadosFormulario = {
            movimentacao_tabela: $('.select-tipo-conta').val(),
            cadastroFinanceiro: $('select[name="cadastroFinanceiro"]').val(), // Certifique-se de adicionar o atributo 'name' nos seus selects HTML, ou ajuste esses seletores conforme necessário.
            data: $('input[name="data_movimentacao"]').val(),
            id_conta_bancaria: $('select[name="contaBancaria"]').val(), // Adicione o atributo 'name' apropriadamente em seu HTML
            id_forma_transacao: $('select[name="formaPagamento"]').val(), // Adicione o atributo 'name'
            valor: $('input[name="valor"]').val(),
            observacao: $('textarea[name="observacao"]').val() // Certifique-se de que o textarea tenha um atributo 'name="observacao"'
        };

        // Envio dos dados com AJAX
        $.ajax({
            url: 'finFluxoCaixa/insereMovimentacaoFluxo',
            type: 'POST',
            data: dadosFormulario,
            beforeSend: function () {
                $('.load-form').removeClass('d-none');
            },
            success: function (response) {


            },
            error: function (xhr, status, error) {
                // Tratamento de erro
                alert('Erro ao salvar dados: ' + error);
            },
            complete: function () {
                $('.load-form').addClass('d-none');
            }
        });
    });
});


const visualizarFluxo = (id) => {

    $.ajax({
        url: `${baseUrl}finFluxoCaixa/recebeMovimentoFluxo`,
        type: 'POST',
        data: {
            idFluxo: id
        },beforeSend: function(){
            $('.html-clean').html('');
        },
         success: function (data) {
            
            let dataFluxo = data.dadosFluxo.DATA_FLUXO.split('-');
            let dataFluxoFormatada = `${dataFluxo[2]}/${dataFluxo[1]}/${dataFluxo[0]}`

            $('.data-fluxo').html('Movimentação do dia ' + dataFluxoFormatada);
            $('.macro-micro').html(data['dadosFluxo'].NOME_MACRO + ' / ' + data['dadosFluxo'].NOME_MICRO);
            $('.recebido').html(data['dadosFluxo'].RECEBIDO);
            $('.valor-fluxo').html('R$' + data['dadosFluxo'].valor);
            
            $('.forma-pagamento').html(data['dadosFluxo'].FORMAPAGAMENTO);
            $('.observacao').html(data['dadosFluxo'].observacao);

        },
        error: function (xhr, status, error) {
            if (xhr.status === 403) {
                avisoRetorno(
                    "Algo deu errado!",
                    `Você não tem permissão para esta ação..`,
                    "error",
                    "#"
                );
            }
        },
    });
}

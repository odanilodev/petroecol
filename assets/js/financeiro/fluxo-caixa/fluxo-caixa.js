
$(document).on('change', '.select-tipo-conta', function () {

    if ($(this).val() == 'entrada') {
        $('.label-forma-pagamento').html('Forma de recebimento');
    } else {
        $('.label-forma-pagamento').html('Forma de pagamento');
        
    }
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


$(document).on('click', '.btn-novo-lancamento', function() {

    $('.select2').select2({
        dropdownParent: "#modalEntradaFluxo",
        theme: "bootstrap-5",
    });

})

$(document).on('change', '.select-recebido', function () {

    let nomeRecebido = $('.select-recebido option:selected').text();

    $('.nome-recebido').val(nomeRecebido);
})


$(document).on('click', '.btn-insere-fluxo', function() {


    let permissao = true;

    permissao = verificaCamposObrigatorios("input-fluxo-obrigatorio");


    // Coleta os dados do formulário
    let dadosFormulario = {
        movimentacao_tabela: $('.select-tipo-conta').val(),
        id_dado_financeiro: $('select[name="cadastroFinanceiro"]').val(), 
        data_movimentacao: $('input[name="data_movimentacao"]').val(),
        id_conta_bancaria: $('select[name="contaBancaria"]').val(), 
        id_forma_transacao: $('select[name="formaPagamento"]').val(), 
        valor: $('input[name="valor"]').val(),
        observacao: $('textarea[name="observacao"]').val() 
    };

    if(permissao){

        $.ajax({
            url: `${baseUrl}finFluxoCaixa/insereMovimentacaoFluxo`, 
            type: 'POST', 
            data: dadosFormulario,
            beforeSend: function () {
                $('.load-form').removeClass('d-none'); 
                $('.btn-form').addClass('d-none'); 
            },
            success: function (data) {
                avisoRetorno(data.title, data.message, data.type, `${baseUrl}finFluxoCaixa`);                
            },
            error: function (xhr, status, error) {
                // Tratamento de erro
                avisoRetorno('Algo deu errado!', error, 'error', `#`);
            }           
        });
        
    }
    
});

function formatarValorExibicao(valor) {
    return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

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

            let dataFluxo = formatarDatas(data.dadosFluxo.DATA_FLUXO);
            let valorFluxo = formatarValorExibicao(parseFloat(data['dadosFluxo'].valor));

            $('.data-fluxo').html('Movimentação do dia ' + dataFluxo);
            $('.macro-micro').html(data['dadosFluxo'].NOME_MACRO + ' / ' + data['dadosFluxo'].NOME_MICRO);
            $('.recebido').html(data['dadosFluxo'].RECEBIDO);
            $('.valor-fluxo').html(valorFluxo);
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


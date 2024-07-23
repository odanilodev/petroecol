
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

$(document).on('click', '.btn-novo-lancamento', function () {

    $('.select2').select2({
        dropdownParent: "#modalEntradaFluxo",
        theme: "bootstrap-5",
    });

})

$(document).on('change', '.select-recebido', function () {

    let nomeRecebido = $('.select-recebido option:selected').text();

    $('.nome-recebido').val(nomeRecebido);
})


$(document).on('click', '.btn-insere-fluxo', function () {


    let permissao = true;

    permissao = verificaCamposObrigatorios("input-fluxo-obrigatorio");


    // Coleta os dados do formulário
    let dadosFormulario = {
        movimentacao_tabela: $('.select-tipo-conta').val(),
        id_dado_financeiro: $('select[name="cadastroFinanceiro"]').val(),
        data_movimentacao: $('input[name="data_movimentacao"]').val(),
        id_conta_bancaria: $('select[name="contaBancaria"]').val(),
        id_forma_transacao: $('select[name="formaPagamento"]').val(),
        macros: $('select[name="macros"]').val(),
        micros: $('select[name="micros"]').val(),
        valor: $('input[name="valor"]').val(),
        observacao: $('textarea[name="observacao"]').val(),
        grupo_recebido: $('select[name="grupo-recebido"]').val()
    };

    if (permissao) {

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
                //Tratamento de erro
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
        }, beforeSend: function () {
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
            $('.setor-empresa').html(data['dadosFluxo'].NOME_SETOR);
            $('.observacao').html(data['dadosFluxo'].observacao ?? '-');

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

const deletarFluxo = (idMovimentacao, idContaBancaria, valorMovimentacao, tipoMovimentacao) => {

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

            let titulo, mensagem;
            if (idMovimentacao) {
                titulo = 'Deseja extornar o valor de entrada?';
                mensagem = 'O valor será devolvido à sua conta bancária.';
            } else {
                titulo = 'Deseja extornar o valor de saída?';
                mensagem = 'O valor será deduzido da sua conta bancária.';
            }

            Swal.fire({
                title: titulo,
                text: mensagem,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Apenas deletar',
                confirmButtonText: 'Sim, extornar'

            }).then((result) => {

                if (result.isConfirmed) {
                    deletarMovimentacao(true); // deleta a movimentação e extorna o valor
                } else {
                    deletarMovimentacao() // deleta a movimentação e mantém o valor
                }
            })

        }
    })


    function deletarMovimentacao(extornarValores = '') {

        $.ajax({
            url: `${baseUrl}finFluxoCaixa/deletaFluxo`,
            type: 'POST',
            data: {
                idFluxo: idMovimentacao,
                valor: valorMovimentacao,
                idContaBancaria: idContaBancaria,
                tipoMovimentacao: tipoMovimentacao,
                extornarValores: extornarValores
            }, beforeSend: function () {
                $('.html-clean').html('');
            },
            success: function (data) {

                let redirect = data.type != 'error' ? `${baseUrl}finFluxoCaixa` : '#';

                avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

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

}

$(function () {
    // Função para obter a data formatada conforme necessário
    function formatarDataParaNomeArquivo(data) {
        if (!data) {
            return 'geral';
        } else {
            // Formato esperado: dd/mm/yy
            var parts = data.split('/');
            return parts[0] + parts[1] + parts[2].slice(-2); // Concatenação das partes da data
        }
    }

    // Função para obter o nome do arquivo com base nas datas de início e fim
    function obterNomeArquivo(base, dataInicio, dataFim) {
        var inicioFormatado = formatarDataParaNomeArquivo(dataInicio);
        var fimFormatado = formatarDataParaNomeArquivo(dataFim);

        if (inicioFormatado === 'geral' && fimFormatado === 'geral') {
            return base + '-geral';
        } else {
            return base + '-' + inicioFormatado + '-' + fimFormatado;
        }
    }

    new DataTable('#table-fluxo', {
        layout: {
            topStart: {
                buttons: [
                    { extend: 'copy', filename: 'fluxo-copia', text: '<span class="fas fa-copy me-2"></span> Copy', className: 'btn-phoenix-secondary' },
                    { extend: 'excel', filename: function () { return obterNomeArquivo('fluxo-excel', $('#data_inicio').val(), $('#data_fim').val()); }, text: '<span class="fas fa-file-excel me-2"></span> Excel', className: 'btn-phoenix-secondary' },
                    { extend: 'pdf', filename: function () { return obterNomeArquivo('fluxo-pdf', $('#data_inicio').val(), $('#data_fim').val()); }, text: '<span class="fas fa-file-pdf me-2"></span> PDF', className: 'btn-phoenix-secondary' },
                    { extend: 'print', filename: 'fluxo-print', text: '<span class="fas fa-file me-2"></span> Print', className: 'btn-phoenix-secondary' }
                ]
            }
        },
        order: [],  // Desativa a ordenação inicial
        ordering: false,  // Desativa a ordenação em todas as colunas
        searching: false,  // Desativa a caixa de pesquisa
        columnDefs: [
            { orderable: false, targets: '_all' }  // Garante que todas as colunas não sejam ordenáveis
        ],
        paging: false,  // Desativa a paginação
        info: false  // Remove a mensagem "Showing 1 to 10 of 10 entries"
    });
});
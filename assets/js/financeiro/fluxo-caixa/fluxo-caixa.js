
$(document).on('change', '.select-tipo-conta', function () {

    if ($(this).val() == 'entrada') {
        $('.label-forma-pagamento').html('Forma de recebimento');
    } else {
        $('.label-forma-pagamento').html('Forma de pagamento');

    }
})

$(document).on('change', '.select-grupo-recebidos', function () {

    let grupo = $(this).val();
    let url;

    switch (grupo) {
        case "clientes":
            url = `${baseUrl}finContasPagar/recebeTodosClientesAll`;
            break;
        case "funcionarios":
            url = `${baseUrl}funcionarios/recebeTodosFuncionarios`;
            break;
        default:
            url = `${baseUrl}finDadosFinanceiros/recebeDadosFinanceiros`;
            break;
    }

    $.ajax({
        type: "post",
        url: url,
        data: grupo !== "clientes" && grupo !== "funcionarios" ? { grupo: grupo } : {},
        beforeSend: function () {
            $('.select-recebido').attr('disabled', true).html('<option disabled>Carregando...</option>');
        },
        success: function (data) {
            $('.select-recebido').attr('disabled', false);
            let options = '<option disabled="disabled" value="">Selecione</option>';
            let dados;

            // Ajusta a variável de dados conforme o grupo selecionado
            if (grupo === "clientes") {
                dados = data.clientes;
            } else if (grupo === "funcionarios") {
                dados = data.funcionarios;
            } else {
                dados = data.dadosFinanceiro;
            }

            // Preenche o select com as opções
            dados.forEach(dado => {
                options += `<option value="${dado.id}">${dado.nome}</option>`;
            });

            $('.select-recebido').html(options).val('').trigger('change');
        }
    });
});

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

    $('.select-recebido').attr('disabled', true);

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
        id_setor_empresa: $('select[name="setorEmpresa"]').val(),
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
            $('.recebido').html(data['dadosFluxo'].RECEBIDO ?? data['dadosFluxo'].NOME_FUNCIONARIO.toUpperCase());
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


$('#exportarBtn').on('click', function (e) {
    e.preventDefault();

    let $btn = $(this);
    let originalText = $btn.html(); // Armazena o texto original do botão

    let formData = new FormData($('#filtroForm')[0]);
    let urlExportar = `${baseUrl}finFluxoCaixa/geraExcelFluxo`; // Defina o caminho absoluto ou relativo para a sua rota

    $.ajax({
        url: urlExportar,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        xhrFields: {
            responseType: 'blob' // Indica que a resposta deve ser tratada como um blob
        },
        beforeSend: function () {
            $btn.prop('disabled', true);
            $('.txt-exportar-btn').addClass('d-none');
            $('.loader-btn-exportar').removeClass('d-none');
        },
        success: function (blob, status, xhr) {
            let contentDisposition = xhr.getResponseHeader('Content-Disposition');
            let fileName = contentDisposition ? contentDisposition.split('filename=')[1].replace(/"/g, '') : 'RelatorioFluxo.xls';

            let url = window.URL.createObjectURL(blob);
            let a = document.createElement('a');
            a.href = url;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            a.remove();

            $btn.prop('disabled', false).html(originalText); // Reativa o botão e restaura o texto original
        },
        error: function (xhr, status, error) {
            console.error('Erro ao exportar:', error);
            $btn.prop('disabled', false).html(originalText); // Reativa o botão e restaura o texto original
        }
    });
});





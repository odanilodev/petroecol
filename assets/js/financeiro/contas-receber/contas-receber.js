var baseUrl = $(".base-url").val();

$(document).on('change', '.select-macros', function () {

    let idMacro = $(this).val();

    $.ajax({
        type: "post",
        url: `${baseUrl}finMicro/recebeMicrosMacro`,
        data: {
            idMacro: idMacro
        }, beforeSend: function () {
            $('.select-micros').html('<option value="">Selecione</option>');
        }, success: function (data) {

            $('.select-micros').attr('disabled', false);

            for (i = 0; i < data.microsMacro.length; i++) {

                $('.select-micros').append(`<option value="${data.microsMacro[i].id}">${data.microsMacro[i].nome}</option>`);
            }
        }
    })
})

const cadastraContasReceber = (classe) => {

    let idConta = $('.id-editar-conta').val();

    let dadosFormulario = {};
    let permissao = true;

    $(`.${classe}`).find(":input").each(function () {

        dadosFormulario[$(this).attr('name')] = $(this).val();

        if ($(this).hasClass('input-obrigatorio') && !$(this).val()) {

            $(this).addClass('invalido');

            // verifica se é select2
            if ($(this).next().hasClass('aviso-obrigatorio')) {

                $(this).next().removeClass('d-none');

            } else {
                $(this).next().next().removeClass('d-none');
                $(this).next().addClass('select2-obrigatorio');
            }

            permissao = false;

        } else {

            $(this).removeClass('invalido');

            if ($(this).next().hasClass('aviso-obrigatorio')) {

                $(this).next().addClass('d-none');

            } else {
                $(this).next().next().addClass('d-none');
                $(this).next().removeClass('select2-obrigatorio');

            }
        }

    })

    if (permissao) {

        let url = `${baseUrl}finContasReceber/${idConta ? 'editaConta' : 'cadastraContasReceber'}`;

        $.ajax({
            type: "post",
            url: url,
            data: {
                idConta: idConta,
                dados: dadosFormulario
            }, beforeSend: function () {
                $(".load-form").removeClass("d-none");
                $(".btn-form").addClass("d-none");
            }, success: function (data) {
                $(".load-form").addClass("d-none");
                $(".btn-form").removeClass("d-none");

                avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${baseUrl}finContasReceber`);

            }
        })
    }
}

$(document).on('click', '.novo-lancamento', function () {

    $('.id-editar-conta').val('');
    $('.dados-conta').val('');

    $('.select-micros').attr('disabled', true);
    $('.select-recebido').attr('disabled', true);

    $('.select2').select2({
        dropdownParent: "#modalEntradaContasReceber",
        theme: "bootstrap-5",
    });
})

$(document).on('click', '.editar-lancamento', function () {

    $('.select2').select2({
        dropdownParent: "#modalEditarContasReceber",
        theme: "bootstrap-5",
    });

    $('.input-editar-valor').val($(this).data('valor'));

    let id = $(this).data('id');
    $('.id-editar-conta').val(id);


    $.ajax({
        type: "post",
        url: `${baseUrl}finContasReceber/recebeContaReceber`,
        data: {
            id: id
        }, beforeSend: function () {

            $('.select-micros').attr('disabled', false);
            $('.editando').removeClass('d-none');

        }, success: function (data) {

            let dataVencimento = data['conta'].data_vencimento.split('-');
            dataVencimento = dataVencimento[2] + '/' + dataVencimento[1] + '/' + dataVencimento[0];
            $('.input-data-vencimento').val(dataVencimento);

            let dataEmissao = data['conta'].data_emissao.split('-');
            dataEmissao = dataEmissao[2] + '/' + dataEmissao[1] + '/' + dataEmissao[0];

            $('.input-data-emissao').val(dataEmissao);

            $('.input-observacao').text(data['conta'].observacao);

            $('.select-setor-empresa').val(data['conta'].id_setor_empresa).trigger('change');
        }
    })

})


// Duplica formas de pagamento
function duplicarFormasPagamento() {
    // Clone o último grupo de campos dentro de .teste
    let clone = $(".campos-pagamento .duplica-pagamento").clone();

    // Limpe os valores dos campos clonados
    clone.find("select").val("");
    clone.find("input").val("");
    clone.find("label").remove();

    let btnRemove = `
        <div class="col-md-1 mt-0">            
            <button class="btn btn-phoenix-danger deleta-dicionario" >-</button>
        </div>
    `;
    //por padrão row vem com margin e padding - classes retiram
    let novaLinha = $('<div class="row m-0 p-0"></div>');

    // imprime os elementos dentro da div row
    novaLinha.append(clone);
    novaLinha.append(btnRemove);

    $(novaLinha).find(`.deleta-dicionario`).on('click', function () {

        novaLinha.remove();
    });

    $(".campos-duplicados").append(novaLinha);

    $('.mascara-dinheiro').mask('000.000.000.000.000,00', { reverse: true });


}

$(document).on('click', '.receber-conta', function () {

    $('.id-conta-pagamento').val($(this).data('id'));
    $('.input-valor-recebido').val($(this).data('valor'));
    $('.valor-total-conta').html(`R$ ${$(this).data('valor')}`);
    $('.id-dado-financeiro').val($(this).data('id-dado-financeiro'));
    $('.id-dado-cliente').val($(this).data('id-dado-cliente'));
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


const receberConta = () => {

    let contasBancarias = [];
    let formasPagamento = [];
    let valores = [];
    let obs = $('.obs-pagamento').val();
    let dataRecebimento = $('.input-data-recebimento').val();
    let valorTotal = 0;

    let idConta = $('.id-conta-pagamento').val();
    let idDadoFinanceiro = $('.id-dado-financeiro').val();
    let idDadoCliente = $('.id-dado-cliente').val();

    $('.select-conta-bancaria').each(function () {

        contasBancarias.push($(this).val());
    })

    $('.select-forma-pagamento').each(function () {

        formasPagamento.push($(this).val());
    })

    $('.input-valor-recebido').each(function () {
        // Remove espaços em branco e pontos de milhar e substitui ',' por '.'
        valores.push($(this).val());
        let valorLimpo = $(this).val().replace(/\s|\.|/g, '').replace(',', '.');
        let valorNumerico = parseFloat(valorLimpo); // Converte para float

        if (!isNaN(valorNumerico)) {
            valorTotal += valorNumerico;
        }
    })


    let valorTotalFormatado = valorTotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });


    $.ajax({
        type: "post",
        url: baseUrl + "finContasReceber/receberConta",
        data: {
            contasBancarias: contasBancarias,
            formasPagamento: formasPagamento,
            valores: valores,
            obs: obs,
            idConta: idConta,
            valorTotal: valorTotal,
            idDadoFinanceiro: idDadoFinanceiro,
            idDadoCliente: idDadoCliente,
            dataRecebimento: dataRecebimento
        }, beforeSend: function () {
            $(".load-form").removeClass("d-none");
            $(".btn-form").addClass("d-none");
        }, success: function (data) {

            $(".load-form").addClass("d-none");
            $(".btn-form").removeClass("d-none");

            atualizaFrontDadosFinanceiro();

            if (data.success) {

                $('#modalReceberConta').modal('hide');

                // atualiza o front

                $(`.btn-editar-${idConta}`).remove();
                $(`.btn-excluir-${idConta}`).remove();
                $(`.btn-receber-pagamento-${idConta}`).remove();

                $(`.status-pagamento-table-${idConta}`).removeClass('cursor-pointer');
                $(`.status-pagamento-table-${idConta}`).removeAttr('data-bs-target');
                $(`.valor-recebido-${idConta}`).html(valorTotalFormatado);
                $(`.data-recebimento-${idConta}`).html(dataRecebimento);
                $(`.tipo-status-conta-${idConta}`).removeClass('badge-phoenix-danger');
                $(`.tipo-status-conta-${idConta}`).addClass('badge-phoenix-success');
                $(`.icone-status-conta-${idConta}`).remove();
                $(`.status-pagamento-table-${idConta}`).html('Recebido');
                $(`.tipo-status-conta-${idConta}`).append(`<span class="uil-check ms-1 icone-status-conta-${idConta}" style="height:12.8px;width:12.8px;"></span>`);

                avisoRetorno("Sucesso!", `${data.message}`, `${data.type}`, `#`);

            }


        }

    })
}

$('.select-setor').on('change', function () {

    $('#nomeSetor').val($(this).find('option:selected').text());

});

const atualizaFrontDadosFinanceiro = () => {

    let totalRecebidoFront = $('.total-recebido-front').html();
    let totalRecebido = formatarValorMoeda(totalRecebidoFront);

    let totalCaixaFront = $('.total-caixa-front').html();
    let totalCaixa = formatarValorMoeda(totalCaixaFront);


    let totalAbertoFront = $('.total-aberto-front').html();
    let totalAberto = formatarValorMoeda(totalAbertoFront);

    let valorSetorFront = $('.total-setor-front').html();
    valorSetorFront = formatarValorMoeda(valorSetorFront);

    let valorTotalRecebidoCompleto = $('.valor-total-conta').html().replace('R$', ''); // uso pra fazer conta e exibir o total a receber
    valorTotalRecebidoCompleto = formatarValorMoeda(valorTotalRecebidoCompleto);

    let valorTotalRecebido = 0;
    $('.input-valor-unic').each(function () {
        let valorNumerico = parseFloat($(this).val().replace('.', '').replace(',', '.'));
        valorTotalRecebido += valorNumerico;
    });

    let totalRecebidoAtualizado = totalRecebido + valorTotalRecebido;

    let valorSetorFrontAtualizado = valorSetorFront - totalAbertoFront;

    let totalCaixaAtualizado = totalCaixa + valorTotalRecebido;

    let totalAbertoAtualizado = totalAberto - valorTotalRecebidoCompleto;

    let valorSetorFrontAtualizadoFormatado = formatarValorExibicao(valorSetorFrontAtualizado);

    // Formatar os valores para exibição
    function formatarValorExibicao(valor) {
        return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }).replace('R$', '');
    }

    let totalRecebidoAtualizadoFormatado = formatarValorExibicao(totalRecebidoAtualizado);
    let totalCaixaAtualizadoFormatado = formatarValorExibicao(totalCaixaAtualizado);
    let totalAbertoAtualizadoFormatado = formatarValorExibicao(totalAbertoAtualizado);

    // Atualiza os valores no front
    $('.total-recebido-front').html(totalRecebidoAtualizadoFormatado);
    $('.total-caixa-front').html(totalCaixaAtualizadoFormatado);
    $('.total-aberto-front').html(totalAbertoAtualizadoFormatado < 0 ? '0,00' : totalAbertoAtualizadoFormatado);
    $('.total-setor-front').html(valorSetorFrontAtualizadoFormatado < 0 ? '0,00' : valorSetorFrontAtualizadoFormatado);
};



function formatarValorMoeda(valor) {
    return parseFloat(valor.replace(/\./g, '').replace(',', '.').replace('&nbsp;', ''));
}

// Formatar os valores para exibição
function formatarValorExibicao(valor) {
    return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }).replace('R$', '');
}

const visualizarConta = (idConta) => {
    
    $.ajax({
        type: "post",
        url: `${baseUrl}finContasReceber/visualizarConta`,
        data: {
            idConta: idConta
        }, beforeSend: function () {
            $('.html-clean').html('');
        }, success: function (data) {
            
            let dataEmissao = formatarDatas(data['conta'].data_emissao);
            let dataVencimento = formatarDatas(data['conta'].data_vencimento);
            let valorConta = formatarValorExibicao(parseFloat(data['conta'].valor));
            let valorRecebido = formatarValorExibicao(parseFloat(data['conta'].valor_recebido));

            if (data['conta'].RECEBIDO) {
                $('.nome-empresa').html(data['conta'].RECEBIDO);
            } else {
                $('.nome-empresa').html(data['conta'].CLIENTE);
            }

            $('.setor-empresa').html(data['conta'].SETOR);
            $('.data-vencimento').html(dataVencimento);
            
            $('.data-emissao').html(data['conta'].data_emissao != '1969-12-31' ? dataEmissao : "");
            $('.valor-conta').html(valorConta);
            $('.obs-conta').html(data['conta'].observacao ? data['conta'].observacao : '-');

            if (data['conta'].valor_recebido) {
                let dataRecebimento = formatarDatas(data['conta'].data_recebimento);
                $('.div-valor-recebido').removeClass('d-none');
                $('.valor-recebido').html(valorRecebido);
                $('.div-data-recebimento').removeClass('d-none');
                $('.data-recebimento').html(dataRecebimento);

            } else {
                $('.div-valor-recebido').addClass('d-none');
            }


        }
    })

}

const deletaContaReceber = (idConta) => {

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
                type: "post",
                url: `${baseUrl}finContasReceber/deletarConta`,
                data: {
                    idConta: idConta
                }, success: function (data) {

                    let redirect = data.type != 'error' ? `${baseUrl}finContasReceber` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                }
            })

        }
    })


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

    new DataTable('#table-contas-receber', {
        layout: {
            topStart: {
                buttons: [
                    { extend: 'copy', filename: 'contas-a-receber-copia', text: '<span class="fas fa-copy me-2"></span> Copy', className: 'btn-phoenix-secondary' },
                    { extend: 'excel', filename: function () { return obterNomeArquivo('contas-a-receber-excel', $('#data_inicio').val(), $('#data_fim').val()); }, text: '<span class="fas fa-file-excel me-2"></span> Excel', className: 'btn-phoenix-secondary' },
                    { extend: 'pdf', filename: function () { return obterNomeArquivo('contas-a-receber-pdf', $('#data_inicio').val(), $('#data_fim').val()); }, text: '<span class="fas fa-file-pdf me-2"></span> PDF', className: 'btn-phoenix-secondary' },
                    { extend: 'print', filename: 'contas-a-receber-print', text: '<span class="fas fa-file me-2"></span> Print', className: 'btn-phoenix-secondary' }
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

$('#exportarBtn').on('click', function(e) {
    e.preventDefault(); // Evita o comportamento padrão de enviar o formulário e recarregar a página

    let $btn = $(this);
    let originalContent = $btn.html(); // Armazena o conteúdo original do botão

    let formData = new FormData($('#filtroForm')[0]);
    let urlExportar = `${baseUrl}finContasReceber/geraExcelContasReceber`; // Defina o caminho correto para a sua rota

    $.ajax({
        url: urlExportar,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        xhrFields: {
            responseType: 'blob' // Indica que a resposta deve ser tratada como um blob
        },
        beforeSend: function() {
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'); // Substitui o conteúdo por um spinner
        },
        success: function(blob, status, xhr) {
            let contentDisposition = xhr.getResponseHeader('Content-Disposition');
            let fileName = contentDisposition ? contentDisposition.split('filename=')[1].replace(/"/g, '') : 'RelatorioContasReceber.xlsx';

            let url = window.URL.createObjectURL(blob);
            let a = document.createElement('a');
            a.href = url;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            a.remove();

            $btn.prop('disabled', false).html(originalContent); // Reativa o botão e restaura o conteúdo original
        },
        error: function(xhr, status, error) {
            console.error('Erro ao exportar:', error);
            $btn.prop('disabled', false).html(originalContent); // Reativa o botão e restaura o conteúdo original
        }
    });
});





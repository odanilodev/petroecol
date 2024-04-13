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

const cadastraContasReceber = () => {

    let dadosFormulario = {};
    let permissao = true;

    $(".form-entrada-receber").find(":input").each(function () {

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

        $.ajax({
            type: "post",
            url: `${baseUrl}finContasReceber/cadastraContasReceber`,
            data: {
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

    $('.select2').select2({
        dropdownParent: "#modalEntradaContasReceber",
        theme: "bootstrap-5",
    });

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
            <button type="button" class="btn btn-phoenix-danger deleta-dicionario" >
                <span class="fas fa-minus"></span>
            </button>
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
    $('.id-dado-financeiro').val($(this).data('id-dado-financeiro'));
})

$(document).on('change', '.select-grupo-recebidos', function () {

    let grupo = $(this).val();

    if (grupo == "clientes") {

        $.ajax({
            type: "post",
            url: `${baseUrl}finContasPagar/recebeTodosClientesAll`
            , beforeSend: function () {
                $('.select-recebido').attr('disabled');
                $('.select-recebido').html('<option value="">Carregando...</option>');
            }, success: function (data) {
                $('.select-recebido').attr('disabled', false);
                $('.select-recebido').html('<option value="">Selecione</option>');

    
                for (i = 0; i < data.clientes.length; i++) {
    
                    $('.select-recebido').append(`<option value="${data.clientes[i].id}">${data.clientes[i].nome}</option>`);
                }
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

    $('.select-conta-bancaria').each(function () {

        contasBancarias.push($(this).val());
    })

    $('.select-forma-pagamento').each(function () {

        formasPagamento.push($(this).val());
    })

    $('.input-valor-recebido').each(function () {

        valores.push($(this).val());

        // soma o valor total
        let valorNumerico = parseFloat($(this).val().replace(',', '.')); // Substitui ',' por '.' e converte para float

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
            dataRecebimento: dataRecebimento
        }, beforeSend: function () {
            $(".load-form").removeClass("d-none");
            $(".btn-form").addClass("d-none");
        }, success: function (data) {

            $(".load-form").addClass("d-none");
            $(".btn-form").removeClass("d-none");

            if (data.success) {

                $('#modalReceberConta').modal('hide');

                // atualiza o front
                $(`.valor-pago-${idConta}`).html(valorTotalFormatado);
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

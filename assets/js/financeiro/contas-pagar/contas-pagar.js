var baseUrl = $(".base-url").val();

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

$(document).on('click', '.realizar-pagamento', function () {

    $('.id-conta-pagamento').val($(this).data('id'));
})


const realizarPagamento = () => {

    let contasBancarias = [];
    let formasPagamento = [];
    let valores = [];
    let obs = $('.obs-pagamento').val();
    let valorTotal = 0;

    let idConta = $('.id-conta-pagamento').val();

    $('.select-conta-bancaria').each(function () {

        contasBancarias.push($(this).val());
    })

    $('.select-forma-pagamento').each(function () {

        formasPagamento.push($(this).val());
    })

    $('.input-valor').each(function () {

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
        url: baseUrl + "finContasPagar/realizarPagamento",
        data: {
            contasBancarias: contasBancarias,
            formasPagamento: formasPagamento,
            valores: valores,
            obs: obs,
            idConta: idConta,
            valorTotal:  valorTotal
        }, beforeSend: function () {
            $(".load-form").removeClass("d-none");
            $(".btn-form").addClass("d-none");
        }, success: function (data) {

            $(".load-form").addClass("d-none");
            $(".btn-form").removeClass("d-none");

            if (data.success) {

                $('#modalPagarConta').modal('hide');

                // atualiza o front
                $(`.valor-pago-${idConta}`).html(valorTotalFormatado); 
                $(`.tipo-status-conta-${idConta}`).removeClass('badge-phoenix-danger');
                $(`.tipo-status-conta-${idConta}`).addClass('badge-phoenix-success');
                $(`.icone-status-conta-${idConta}`).remove();
                $(`.tipo-status-conta-${idConta}`).append(`<span class="uil-check ms-1 icone-status-conta-${idConta}" style="height:12.8px;width:12.8px;"></span>`);
                $(`.status-pagamento-${idConta}`).html('Pago');

                avisoRetorno("Sucesso!", `${data.message}`, `${data.type}`, `#`);

            }


        }

    })
}
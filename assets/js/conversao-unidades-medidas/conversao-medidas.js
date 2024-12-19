$(function () {
    $(`.select2`).select2({
        theme: "bootstrap-5",
    });
})

const cadastraConversao = () => {
    
    let nomeResiduo = $('.select-residuo option:selected').html();
    let residuo = $('.select-residuo').val();
    let medidaInicial = $('.select-medida-inicial').val();
    let valor = $('.input-valor').val();
    let operador = $('.select-operador').val();
    let simbolo = $('.select-operador option:selected').html();
    let medidaFinal = $('.select-medida-final').val();
    let id = $('.input-id').val();

    let permissao = verificaCamposObrigatorios('input-obrigatorio');

    if (permissao) {
        $.ajax({
            method: 'POST',
            url: `${baseUrl}conversaoUnidadeMedida/cadastraConversao`,
            data: {
                id: id,
                residuo: residuo,
                medida_inicial: medidaInicial,
                valor: valor,
                operador: operador,
                simbolo: simbolo,
                medida_final: medidaFinal,
                nome_residuo: nomeResiduo
            }, beforeSend: function () {
                $(".load-form").removeClass("d-none");
                $(".btn-form").addClass("d-none");
            },
            success: function(data) {

                $(".load-form").addClass("d-none");
                $(".btn-form").removeClass("d-none");

                let redirect = data.type != 'error' ? `${baseUrl}conversaoUnidadeMedida` : '#';

                avisoRetorno(data.title, `${data.message}`, `${data.type}`, redirect);
                
            },
            error: function(xhr, status, error) {
                console.error('Erro ao cadastrar conversão:', error);
            }
        });
    }
    
}

const exemploConversaoMedidas = (nomeMedidaOrigem, tipoOperacao, valor, nomeMedidaDestino, residuo) => {

    $('.residuo').val(residuo);
    $('.nome-medida-origem').val(nomeMedidaOrigem);
    $('.tipo-operacao').val(tipoOperacao);
    $('.valor').val(valor);
    $('.nome-medida-destino').val(nomeMedidaDestino);
    $('.quantidade-converter').val('');
    $('.exemplo-conversao').html('')

    $('.label-converter').html(`Converter ${nomeMedidaOrigem} de ${residuo} para ${nomeMedidaDestino}`)
    $('.quantidade-converter').attr('placeholder', `Quantidade em ${nomeMedidaOrigem} para converter em ${nomeMedidaDestino}`);
}

$(document).on('input', '.quantidade-converter', function () {

    let residuo = $('.residuo').val();
    let nomeMedidaOrigem = $('.nome-medida-origem').val();
    let tipoOperacao = $('.tipo-operacao').val();
    let valor = $('.valor').val();
    let nomeMedidaDestino = $('.nome-medida-destino').val();
    let quantidade = $(this).val();

    $.ajax({
        type: 'post',
        url: `${baseUrl}conversaoUnidadeMedida/exemploConversaoMedidas`,
        data: {
            medidaOrigem: nomeMedidaOrigem,
            tipoOperacao: tipoOperacao,
            valor: valor,
            medidaDestino: nomeMedidaDestino,
            quantidade: quantidade,
            residuo: residuo
        }, success: function (data) {

            $('.exemplo-conversao').html(data)
        }
    })

})

const deletarConversao = (idConversao) => {

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
                url: `${baseUrl}conversaoUnidadeMedida/deletarConversao`,
                data: {
                    idConversao: idConversao
                }, success: function (data) {

                    let redirect = data.type != 'error' ? `${baseUrl}conversaoUnidadeMedida` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                }
            })

        }
    })


}

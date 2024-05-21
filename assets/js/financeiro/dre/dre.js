const visualizarDre = (id) => {

    $.ajax({
        type: "post",
        url: `${baseUrl}finDre/visualizarMicrosDre`,
        data: {
            id: id
        }, beforeSend: function () {
            $('.html-clean').html('');
        }, success: function (data) {

            $('.tipo-despesa').html(data['retorno'][0].MACRO);

            for (i = 0; i < data['retorno'].length; i++) {
                buscaValoresMicros(data['retorno'][i].id_micro);
            }

        }
    })
}


function buscaValoresMicros(idMicro) {

    $.ajax({
        type: "post",
        url: `${baseUrl}finDre/recebeValoresMicros`,
        data: {
            idMicro: idMicro
        }, beforeSend: function () {
            $('.html-clean').html('');
        }, success: function (data) {

            let valorFaturamento = $('.valor-faturamento').val(); 

            let micros = '';

            for (i = 0; i < data['retorno'].length; i++) {

                let valor = formatarValorMoeda(data['retorno'][i].VALOR_TOTAL_MICRO);

                let porcentagemFatura = (data['retorno'][i].VALOR_TOTAL_MICRO - valorFaturamento) / valorFaturamento * 100;
                porcentagemFatura = 100 - porcentagemFatura;

                let porcentagemFaturaFormatada = porcentagemFatura.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + '%';

                micros += `
                    <tr class="html-clean">
                        <td class="text-center nomes-micros html-clean">${data['retorno'][i].nome}</td>
                        <td class="text-center valor-micro">${valor}</td>
                        <td class="text-center">${porcentagemFaturaFormatada}</td>
                    </tr>
                `;
            }

            $('.tabela-micros').append(micros);

        }
    })

}
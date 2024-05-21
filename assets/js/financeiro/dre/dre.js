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

            let micros = data['retorno'].map(item => item.nome);
            micros = micros.join(', ');

            $('.nomes-micros').html(micros);

        }
    })
}
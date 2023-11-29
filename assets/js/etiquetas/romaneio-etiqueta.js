var baseUrl = $('.base-url').val();

const gerarRomaneioEtiqueta = (idEtiqueta) => {

    $.ajax({
        type: "POST",
        url: `${baseUrl}romaneios/gerarRomaneioEtiqueta`,
        data: {
            idEtiqueta: idEtiqueta
        }, beforeSend: (function () {
            console.log('carregando...');
        }),
        success: function (data) {
            
            alert(data);
        }
    })

}
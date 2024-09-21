$(document).on('click', '.btn-finalizar-afericao', function () {

    let codRomaneio = $('.codigo-romaneio').val();
    let dadosResiduos = [];
    $('.input-aferido').each(function () {

        if ($(this).val()) {
            dadosResiduos.push({
                idResiduo: $(this).data('id-residuo'),
                qtdColetada: $(this).data('qtd-coletada'),
                setorEmpresa: $(this).data('id-setor-empresa'),
                aferido: $(this).val()
            });
        }

    });
   
    $.ajax({
        type: "post",
        url: `${baseUrl}afericao/salvarAfericao`,
        data: {
            dadosResiduos: dadosResiduos,
            codRomaneio: codRomaneio
        }, beforeSend: function () {
            
        }, success: function (data) {

            let redirect = '#';
            if (data.success) {
                redirect = `${baseUrl}afericao`;
            }

            avisoRetorno(data.title, data.message, data.type, redirect);

        }, error: function (xhr, status, error) {

            if (xhr.status === 403) {
              avisoRetorno('Algo deu errado!', `Você não tem permissão para realizar essa operação!`, 'error', '#');
            }
          }
    })

})


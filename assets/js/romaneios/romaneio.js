var baseUrl = $('.base-url').val();

const filtrarClientesRomaneio = () => {

    let data_coleta = $('.input-coleta').val();

    if (!data_coleta) {

        $('.input-coleta').addClass('invalido');
        return;

    } else {

        $('.input-coleta').removeClass('invalido');

    }

    let etiquetas = $('#select-etiquetas').val();

    let cidades = $('#select-cidades').val();

    $.ajax({
        type: "POST",
        url: `${baseUrl}romaneios/filtrarClientesRomaneio`,
        data: {
            cidades: cidades,
            ids_etiquetas: etiquetas,
            data_coleta: data_coleta
        },
        beforeSend: function () {
            $('.clientes-modal-romaneio').html('');
            $('.load-form-romaneio').removeClass('d-none');
            $('.btn-envia-romaneio').addClass('d-none');

        }, success: function (data) {

            $('.load-form-romaneio').addClass('d-none');
            $('.btn-envia-romaneio').removeClass('d-none');

            if (data.registros < 1) {

                avisoRetorno('Algo deu errado!', 'Não foi encontrado nada com essas informações!', 'error', '#');

            } else {
                $('#modalRomaneio').modal('show');
            }

            for (i = 0; i < data.registros; i++) {

                let clientes = `
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                        <td class="align-middle white-space-nowrap">
                            ${data.retorno[i].CLIENTE}
                        </td>

                        <td class="align-middle white-space-nowrap">
                            ${data.retorno[i].ETIQUETA} / ${data.retorno[i].cidade}
                        </td>

                        <td class="align-middle white-space-nowrap pt-3">
                            <div class="form-check">
                                <input class="form-check-input check-clientes-modal" checked name="clientes" type="checkbox" value="${data.retorno[i].ID_CLIENTE}" style="cursor: pointer">
                            </div>
                        </td>
                    </tr>
                `;

                $('.clientes-modal-romaneio').append(clientes);
            }

        }
    })
}

const gerarRomaneio = () => {

    let clientes = [];
    $('.check-clientes-modal').each(function () {

        if ($(this).is(':checked')) {

            clientes.push($(this).val());

        }

    })

    let motorista = $('#select-motorista').val();

    if (!motorista) {

        $('#select-motorista').addClass('invalido');
        return;

    } else {

        $('#select-motorista').removeClass('invalido');

    }

    let data_coleta = $('.input-coleta').val();

    $.ajax({
        type: "POST",
        url: `${baseUrl}romaneios/gerarRomaneioEtiqueta`,
        data: {
            clientes: clientes,
            motorista: motorista,
            data_coleta: data_coleta
        },
        beforeSend: function () {
            $('.load-form-modal-romaneio').removeClass('d-none');
            $('.btn-salva-romaneio').addClass('d-none');

        }, success: function (data) {
            if (data.success) {
                avisoRetorno('Sucesso!', data.message, 'success', `${baseUrl}romaneios/`);
            }else{
                avisoRetorno('Erro!', data.message, 'error', `${baseUrl}romaneios/formulario/`);

            }
        }

    })

}

$(document).on('click', '.add-cliente', function () {

    $('.div-select-modal').removeClass('d-none');

})

$('#select-cliente-modal').change(function () {

    let cliente = $('#select-cliente-modal option:selected').text();

    let valSelectClienteModal = $('#select-cliente-modal option:selected').val().split('|');

    let idCliente = valSelectClienteModal[0];

    let cidade = valSelectClienteModal[1];

    let etiqueta = valSelectClienteModal[2]

    $('.div-select-modal').addClass('d-none');

    let clientes = `
        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
            <td class="align-middle white-space-nowrap">
                ${cliente}
            </td>

            <td class="align-middle white-space-nowrap">
                ${etiqueta} / ${cidade}
            </td>

            <td class="align-middle white-space-nowrap pt-3">
                <div class="form-check">
                    <input class="form-check-input check-clientes-modal" checked name="clientes" type="checkbox" value="${idCliente}" style="cursor: pointer">
                </div>
            </td>
        </tr>
    `;

    if(idCliente.trim()){
        $('.clientes-modal-romaneio').append(clientes);
    }
 

})
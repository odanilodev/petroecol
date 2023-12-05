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

        }, success: function (data) {

            if (data.registros < 1) {

                avisoRetorno('Algo deu errado!', 'Não há nada para exibir aqui', 'error', '#');

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

            console.log('carregando...');

        }, success: function (data) {

            alert('deu bao')
        }
    })

}


const acrescentarCliente = () => {

    $('.div-select-modal').removeClass('d-none');

    $('#select-cliente-modal').select2({
        dropdownParent: "#modalRomaneio",
        theme: 'bootstrap-5' // Aplicar o tema Bootstrap 4
    });

}

$(document).ready(function () {
    $('.select2').select2({
        theme: 'bootstrap-5' // Aplicar o tema Bootstrap 4
    });
})


$('#select-cliente-modal').change(function () {

    let cliente = $('#select-cliente-modal option:selected').text();
    let idCliente = $('#select-cliente-modal option:selected').val();
    let cidade = $('#select-cliente-modal option:selected').data('cidade');

    $('.div-select-modal').addClass('d-none');

    let clientes = `
        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
            <td class="align-middle white-space-nowrap">
                ${cliente}
            </td>

            <td class="align-middle white-space-nowrap">
                 / ${cidade}
            </td>

            <td class="align-middle white-space-nowrap pt-3">
                <div class="form-check">
                    <input class="form-check-input check-clientes-modal" checked name="clientes" type="checkbox" value="${idCliente}" style="cursor: pointer">
                </div>
            </td>
        </tr>
    `;

    $('.clientes-modal-romaneio').append(clientes);

})
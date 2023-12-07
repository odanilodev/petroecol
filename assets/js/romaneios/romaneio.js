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
            } else {
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

    if (idCliente.trim()) {
        $('.clientes-modal-romaneio').append(clientes);
    }


})


const concluirRomaneio = (codRomaneio, idMotorista) => {

    $('#modalConcluirRomaneio').modal('show');

    $('.id_motorista').val(idMotorista);
    $('.code_romaneio').val(codRomaneio);

    if (codRomaneio) {

        $.ajax({
            type: 'post',
            url: `${baseUrl}romaneios/recebeClientesRomaneios`,
            data: {
                codRomaneio: codRomaneio

            }, beforeSend: function () {

                $('.dados-clientes-div').html('');

            }, success: function (data) {

                exibirDadosClientes(data.retorno, data.registros, data.residuos);
            }
        })

    }

}

function exibirDadosClientes(clientes, registros, residuos) {

    for (let i = 0; i < registros; i++) {

        let dadosClientes = `

            <div class="accordion-item ">

                <h2 class="accordion-header" id="heading${i}">
                    <button class="accordion-button ${i != 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${i}" aria-expanded="true" aria-controls="collapse${i}">
                        ${clientes[i].nome}
                    </button>
                </h2>

                <div class="accordion-collapse collapse ${i == 0 ? 'show' : ''}" id="collapse${i}" aria-labelledby="headingOne" data-bs-parent="#accordionExample">

                    <input type="hidden" value="${clientes[i].id}" class="input-id-cliente">

                    <div class="accordion-body pt-0 row">

                        <div class="col-md-3 mb-2">

                            <label class="form-label">Endereço</label>
                            <input class="form-control input-endereco input-obrigatorio" type="text" placeholder="Digite o nome do resíduo" value="${clientes[i].rua} - ${clientes[i].numero} / ${clientes[i].cidade}">
                        </div>

                        <div class="col-md-3 mb-2">

                            <label class="form-label">Telefone</label>
                            <input class="form-control input-telefone input-obrigatorio" type="text" placeholder="Digite o nome do resíduo" value="${clientes[i].telefone}">

                        </div>

                        <div class="col-md-3 mb-2">

                            <label class="form-label">Forma de Pagamento</label>
                            <input class="form-control input-pagamento input-obrigatorio" type="text" placeholder="Digite o nome do resíduo" value="">
                        </div>

                        <div class="col-md-3 mb-2">

                            <label class="form-label">Valor Pago</label>
                            <input class="form-control input-valor-pago input-obrigatorio" type="text" placeholder="Digite o nome do resíduo" value="">
                        </div>

                        <div class="col-md-4 mb-2 div-residuos">

                            <label class="form-label">Resíduo Coletado</label>
                            
                            <select class="form-select select-residuo w-100" id="select-residuo" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}'>

                                <option disabled selected value="">Selecione residuos</option>
                                
                            </select>

                        </div>

                        <div class="col-md-4 mb-2">

                            <label class="form-label">Quantidade Coletado</label>
                            <input class="form-control input-qtd-coletado input-obrigatorio" type="text" placeholder="Digite o nome do resíduo" value="">
                        </div>

                        <div class="col-md-4 mb-2 mt-4 row">

                            <button class="btn btn-info duplicar-residuo w-25">+</button>

                        </div>

                        <div class="div-obs antiga-obs">

                            <div class="col-12">
                                <label class="form-label">Observação</label>
                                <textarea class="form-control input-obs" id="exampleTextarea" rows="3"> </textarea>
                                <div class="text-danger d-none aviso-msg">Preencha este campo.</div>
                            </div>

                            <div class="col-12 mt-4">
                                
                                <div class="form-check mb-0 fs-0">
                                    <input title="Preencha este campo caso não tenha coletado no cliente" class="form-check-input nao-coletado" id="checkbox-bulk-members-select" type="checkbox" data-bulk-select='{"body":"members-table-body"}' style="cursor: pointer"/>
                                    Não Coletado
                                </div>

                            </div>

                        </div>

                        <div class="nova-obs row div-obs"></div>

                    </div>
                </div>
            </div>
        `;

        $('.dados-clientes-div').append(dadosClientes);

        // residuos do cliente no select
        
        let optionResiduos = `<option value="${residuos[i].id_residuo}">${residuos[i].nome}</option>`;

        $('.select-residuo').append(optionResiduos);


    }
}


$(document).on('click', '.duplicar-residuo', function () {
    // Pega os options do select
    let optionsResiduo = $(this).closest('.accordion-item').find('.select-residuo').html();

    let divObs = $(this).closest('.accordion-item').find('.div-obs').html();

    let selectResiduos = `
        <div class="col-md-4 mb-2 div-residuos">
            <label class="form-label">Resíduo Coletado</label>
            <select class="form-select select-residuo w-100" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}'>
                <option disabled selected value="">Selecione resíduos</option>
                ${optionsResiduo}
            </select>
        </div>
    `;

    let qtdResiduos = `
        <div class="col-md-4 mb-2">
            <label class="form-label">Quantidade Coletada</label>
            <input class="form-control input-qtd-coletado input-obrigatorio" type="text" placeholder="Digite a quantidade" value="">
        </div>
    `;

    // Cria uma nova div com a classe 'row' para cada conjunto de elementos duplicados
    let newRow = $('<div class="row"></div>');

    // Adiciona os novos elementos dentro da nova div
    newRow.append(selectResiduos);
    newRow.append(qtdResiduos);

    // Identifica o elemento pai do botão clicado (accordion-item)
    let parentAccordionItem = $(this).closest('.accordion-item');

    // Adiciona a nova div dentro do accordion-item
    parentAccordionItem.find('.accordion-body').append(newRow);

    $(this).closest('.accordion-item').find('.div-obs').remove();

    let novaObs = `<div class="div-obs">${divObs}</div>`;
    
    parentAccordionItem.find('.accordion-body').append(novaObs);

});




$(document).on('click', '.nao-coletado', function () {

    if ($(this).is(':checked')) {

        $('.aviso-msg').removeClass('d-none');
        $('.aviso-msg').html('Preencha este campo');
        $('.accordion-button').attr('disabled', true);
        $('.btn-finaliza-romaneio').attr('disabled', true);

    } else {

        $('.aviso-msg').addClass('d-none');
        $('.accordion-button').attr('disabled', false);
        $('.btn-finaliza-romaneio').attr('disabled', false);

    }

})

$(document).on('input', '.input-obs', function () {

    if ($(this).val().length > 1 && $(this).val().length < 10) {

        $('.aviso-msg').removeClass('d-none');
        $('.aviso-msg').html('Este campo precisa ter no mínimo 10 caracteres');
        $('.btn-finaliza-romaneio').attr('disabled', true);
        $('.accordion-button').attr('disabled', true);


    } else {

        $('.aviso-msg').addClass('d-none');
        $('.btn-finaliza-romaneio').attr('disabled', false);

    }
})

function finalizarRomaneio() {

    let dadosClientes = [];

    let idMotorista = $('.id_motorista').val();
    let codRomaneio = $('.code_romaneio').val();

    $('.accordion-item').each(function () {

        let residuosSelecionados = [];

        $(this).find('.select-residuo option:selected').each(function () {
            residuosSelecionados.push($(this).val());
        });

        let qtdResiduos = [];

        $(this).find('.input-qtd-coletado').each(function () {
            qtdResiduos.push($(this).val());
        });

        let dadosCliente = {
            idCliente: $(this).find('.input-id-cliente').val(),
            endereco: $(this).find('.input-endereco').val(),
            pagamento: $(this).find('.input-pagamento').val(),
            ultimaColeta: $(this).find('.input-ultima-coleta').val(),
            valorPago: $(this).find('.input-valor-pago').val(),
            residuos: residuosSelecionados,
            qtdColetado: qtdResiduos,
            obs: $(this).find('.input-obs').val()
        };

        dadosClientes.push(dadosCliente);
    });

    
    $.ajax({
        type: "POST",
        url: `${baseUrl}coletas/cadastraColeta`,
        data: {
            clientes: dadosClientes,
            idMotorista: idMotorista,
            codRomaneio: codRomaneio
        }, success: function () {
            alert('deu bom')
        } 

    })

}

var baseUrl = $('.base-url').val();

const filtrarClientesRomaneio = () => {

    let data_coleta = $('.input-coleta').val();

    if (!data_coleta) {

        $('.input-coleta').addClass('invalido');
        return;

    } else {

        $('.input-coleta').removeClass('invalido');

    }

    var dataColeta = new Date(data_coleta + "T00:00:00");
    var hoje = new Date();
   
    if (dataColeta < new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate())) {
        avisoRetorno('Algo deu errado!', 'A data selecionada é anterior à data de hoje!', 'error', '#');
        return;
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
                            ${data.retorno[i].ETIQUETA ?? "Sem etiqueta"} / ${data.retorno[i].cidade}
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

    let permissao = true;

    $(".input-obrigatorio").each(function () {

		// Verifica se o valor do input atual está vazio
		if ($(this).val() === "" || $(this).val() === null) {

            $(this).addClass('invalido');
            $(this).next().removeClass('d-none');

			permissao = false;

		} else {

            $(this).removeClass('invalido');
            $(this).next().addClass('d-none');
        }
	});

    // novo clientes para gerar romaneio
    let clientes = [];
    $('.check-clientes-modal').each(function () {

        if ($(this).is(':checked')) {

            clientes.push($(this).val());

        }

    })

    let responsavel = $('#select-responsavel').val();
    let veiculo = $('#select-veiculo').val();
    let data_coleta = $('.input-coleta').val();

    if (permissao) { 
 
        $.ajax({
            type: "POST",
            url: `${baseUrl}romaneios/gerarRomaneioEtiqueta`,
            data: {
                clientes: clientes,
                responsavel: responsavel,
                veiculo: veiculo,
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


const concluirRomaneio = (codRomaneio, idResponsavel, dataRomaneio) => {

    $('#modalConcluirRomaneio').modal('show');

    $('.id_responsavel').val(idResponsavel);
    $('.code_romaneio').val(codRomaneio);
    $('.data_romaneio').val(dataRomaneio);

    if (codRomaneio) {

        $.ajax({
            type: 'post',
            url: `${baseUrl}romaneios/recebeClientesRomaneios`,
            data: {
                codRomaneio: codRomaneio

            }, beforeSend: function () {

                $('.dados-clientes-div').html('');

            }, success: function (data) {

                exibirDadosClientes(data.retorno, data.registros, data.residuos, data.pagamentos);
            }
        })

    }

}

function exibirDadosClientes(clientes, registros, residuos, pagamentos) {

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

                        <div class="col-md-6 mb-2">

                            <label class="form-label">Endereço</label>
                            <input class="form-control input-endereco input-obrigatorio campos-form-${clientes[i].id}" type="text" placeholder="Endereço do cliente" value="${clientes[i].rua} - ${clientes[i].numero} / ${clientes[i].cidade}">
                        </div>

                        <div class="col-md-6 mb-2">

                            <label class="form-label">Telefone</label>
                            <input class="form-control input-telefone input-obrigatorio campos-form-${clientes[i].id}" type="text" placeholder="Telefone" value="${clientes[i].telefone}">

                        </div>

                        <div class="col-md-4 mb-2 div-pagamento">

                            <label class="form-label">Forma de Pagamento</label>
                            <select class="form-select select-pagamento w-100 input-obrigatorio campos-form-${clientes[i].id}" id="select-pagamento" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}'>

                                <option disabled selected value="">Selecione</option>
                                
                            </select>
                        </div>

                        <div class="col-md-4 mb-2 div-pagamento">

                            <label class="form-label">Valor Pago</label>
                            <input class="form-control input-pagamento campos-form-${clientes[i].id}" type="text" placeholder="Digite valor pago" value="">
                        </div>

                        <div class="col-md-4 mb-2 mt-4 row">

                            <button class="btn btn-info duplicar-pagamento w-25">+</button>

                        </div>

                        <div class="pagamentos-duplicados"></div>

                        <div class="col-md-4 mb-2 div-residuo">

                            <label class="form-label">Resíduo Coletado</label>
                            
                            <select class="form-select select-residuo w-100 input-obrigatorio campos-form-${clientes[i].id}" id="select-residuo" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}'>

                                <option disabled selected value="">Selecione</option>
                                
                            </select>

                        </div>

                        <div class="col-md-4 mb-2">

                            <label class="form-label">Quantidade Coletada</label>
                            <input class="form-control input-residuo input-obrigatorio campos-form-${clientes[i].id}" type="text" placeholder="Digite quantidade coletada" value="">
                        </div>

                        <div class="col-md-4 mb-2 mt-4 row">

                            <button class="btn btn-info duplicar-residuo w-25">+</button>

                        </div>

                        <div class="residuos-duplicados"></div>

                        <div class="div-obs">

                            <div class="col-12">
                                <label class="form-label">Observação</label>
                                <textarea class="form-control input-obs input-ons-${clientes[i].id}" id="exampleTextarea" rows="3"> </textarea>
                                <div class="text-danger d-none aviso-msg">Preencha este campo.</div>
                            </div>

                            <div class="col-12 mt-4">
                                
                                <div class="form-check mb-0 fs-0">
                                    <input data-id="${clientes[i].id}" title="Preencha este campo caso não tenha coletado no cliente" class="form-check-input nao-coletado" type="checkbox" data-bulk-select='{"body":"members-table-body"}' style="cursor: pointer"/>
                                    Não Coletado
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        `;

        $('.dados-clientes-div').append(dadosClientes);

    }

    // residuos no select
    for (c = 0; c < residuos.length; c++) {

        var optionResiduos = `<option value="${residuos[c].id}">${residuos[c].nome}</option>`;
        $('.select-residuo').append(optionResiduos);
    }

    // formas de pagamento no select
    for (c = 0; c < pagamentos.length; c++) {

        var optionPagamentos = `<option value="${pagamentos[c].id}">${pagamentos[c].forma_pagamento}</option>`;
        $('.select-pagamento').append(optionPagamentos);
    }
}


// duplica forma de pagamento e residuos
function duplicarElemento(btnClicado, novoElemento, novoInput, classe) {

    // Pega os options do select
    let options = $(btnClicado).closest('.accordion-item').find('.select-' + novoElemento).html();

    let selectHtml = `
        <div class="col-md-4 mb-2 div-${novoElemento}">
            <select class="form-select select-${novoElemento} w-100 input-obrigatorio" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}'>
                ${options}
            </select>
        </div>
    `;

    let inputHtml = `
        <div class="col-md-4 mb-2 div-${novoElemento}">
            <input class="form-control input-${novoElemento} input-obrigatorio" type="text" placeholder="Digite ${novoInput}" value="">
        </div>
    `;

    let btnRemove = $(`
    <div class="col-md-4 mb-2 mt-1 row">

        <button class="btn btn-danger remover-${novoElemento} w-25">-</button>

    </div>`);

    // div com row para cada grupo ficar em row diferente
    let novaLinha = $('<div class="row"></div>');

    // imprime os elementos dentro da div row
    novaLinha.append(selectHtml);
    novaLinha.append(inputHtml);
    novaLinha.append(btnRemove);
    
    //remove a linha duplicada
    btnRemove.find(`.remover-${novoElemento}`).on('click', function () {
        
        novaLinha.remove();
    });

    $(btnClicado).closest('.accordion-item').find(`.${classe}`).append(novaLinha);

}

$(document).on('click', '.duplicar-residuo', function () {

    duplicarElemento(this, 'residuo', 'quantidade coletada', 'residuos-duplicados');

});

$(document).on('click', '.duplicar-pagamento', function () {

    duplicarElemento(this, 'pagamento', 'valor pago', 'pagamentos-duplicados');

});


$(document).on('click', '.nao-coletado', function () {

    let idCliente = $(this).data('id');

    if ($(this).is(':checked')) {

        $('.campos-form-' + idCliente).removeClass('input-obrigatorio');
        $('.campos-form-' + idCliente).removeClass('invalido');

        $('.aviso-msg').removeClass('d-none');
        $('.aviso-msg').html('Preencha este campo');
        $('.accordion-button').attr('disabled', true);
        $('.btn-finaliza-romaneio').attr('disabled', true);

    } else {

        $('.campos-form-' + idCliente).addClass('input-obrigatorio');
        $('.aviso-msg').addClass('d-none');
        $('.accordion-button').attr('disabled', false);
        $('.btn-finaliza-romaneio').attr('disabled', false);

    }

})

$(document).on('input', '.input-obs', function () {

    if ($(this).val().length < 10 && $('.nao-coletado').is(':checked')) {

        $('.aviso-msg').removeClass('d-none');
        $('.aviso-msg').html('Este campo precisa ter no mínimo 10 caracteres');
        $('.accordion-button').attr('disabled', true);
        $('.btn-finaliza-romaneio').attr('disabled', true);

    } else {

        $('.aviso-msg').addClass('d-none');
        $('.accordion-button').attr('disabled', false);
        $('.btn-finaliza-romaneio').attr('disabled', false);

    }
})

function finalizarRomaneio() {

    var permissao = true;

    $('.input-obrigatorio').each(function () {

        if (!$(this).val()) {

            avisoRetorno('Algo deu errado.', 'Você precisa preencher todos os campos para concluir o romaneio', 'error', '#');

            $(this).addClass('invalido');

            permissao = false;

        } else {
            $(this).removeClass('invalido');

        }

    })

    let dadosClientes = [];

    let idResponsavel = $('.id_responsavel').val();
    let codRomaneio = $('.code_romaneio').val();
    let dataRomaneio = $('.data_romaneio').val();

    $('.accordion-item').each(function () {

        if ($(this).find('.nao-coletado').is(':checked')) {

            var coletado = 0;

        } else {
            var coletado = 1;
        }

        // valores resíduos 
        let residuosSelecionados = [];

        $(this).find('.select-residuo option:selected').each(function () {
            residuosSelecionados.push($(this).val());
        });

        let qtdResiduos = [];

        $(this).find('.input-residuo').each(function () {
            qtdResiduos.push($(this).val());
        });

        // valores pagamentos
        let formaPagamentoSelecionados = [];

        $(this).find('.div-pagamento .select-pagamento option:selected').each(function () {
            formaPagamentoSelecionados.push($(this).val());
        });

        let valorPagamento = [];

        $(this).find('.div-pagamento .input-pagamento').each(function () {

            valorPagamento.push($(this).val());
        });

        let dadosCliente = {
            idCliente: $(this).find('.input-id-cliente').val(),
            endereco: $(this).find('.input-endereco').val(),
            residuos: residuosSelecionados,
            qtdColetado: qtdResiduos,
            pagamento: formaPagamentoSelecionados,
            valor: valorPagamento,
            coletado: coletado,
            obs: $(this).find('.input-obs').val()
        };

        dadosClientes.push(dadosCliente);
        
    });

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}coletas/cadastraColeta`,
            data: {
                clientes: dadosClientes,
                idResponsavel: idResponsavel,
                codRomaneio: codRomaneio,
                dataRomaneio: dataRomaneio

            }, beforeSend: function () {

                $('.btn-finaliza-romaneio').addClass('d-none');
                $('.load-form-modal-romaneio').removeClass('d-none');

            }, success: function (data) {

                $('.btn-finaliza-romaneio').removeClass('d-none');
                $('.load-form-modal-romaneio').addClass('d-none');

                if (data.success) {
                    avisoRetorno('Sucesso!', 'O romaneio foi concluído com sucesso', 'success', `${baseUrl}romaneios`);
                } else {
                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');
                }

            }, error: function (xhr, status, error) {

                $('.btn-finaliza-romaneio').removeClass('d-none');
                $('.load-form-modal-romaneio').addClass('d-none');
                if (xhr.status === 403) {
                    avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação..`, 'error', '#');
                }
            }

        })
    }

}

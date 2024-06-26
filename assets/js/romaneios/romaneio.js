var baseUrl = $('.base-url').val();

let filtrarClientesRomaneio = () => {

    $('.select2').select2({
        dropdownParent: "#modalRomaneio",
        theme: 'bootstrap-5'
    });

    let clientesModalRomaneio = $('.clientes-modal-romaneio');
    let checkTodos = `<tr class="hover-actions-trigger btn-reveal-trigger position-static clientes-romaneio">
                <td class="align-middle white-space-nowrap">
                    <input class="form-check-input check-clientes-modal cursor-pointer check-all-element" type="checkbox" style="margin-right:8px;">
                    Clientes
                </td>
            </tr>`;
    $('#select-cliente-modal').val('').trigger('change');

    let permissao = false;
    let filtrarData = null;

    if (!$('#select-setor').val()) {
        avisoRetorno('Algo deu errado!', 'Selecione um setor!', 'error', '#');
        return;
    }

    if ($('#filtrar-data').prop('checked')) {
        filtrarData = true;
        permissao = true;

    }

    $('.input-filtro-romaneio').each(function () {

        if ($(this).val() != "") {
            permissao = true;
        }
    })

    if ($('.input-coleta').val() == '') {
        avisoRetorno('Algo deu errado!', 'Preencha a data de agendamento!', 'error', '#');
        return;
    }

    let data_coleta = $('.input-coleta').val();
    let dataColeta = new Date(data_coleta + "T00:00:00");
    let hoje = new Date();

    if (dataColeta < new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate())) {
        avisoRetorno('Algo deu errado!', 'A data selecionada é anterior à data de hoje!', 'error', '#');
        return;
    }

    let etiquetas = $('#select-etiquetas').val();
    let cidades = $('#select-cidades').val();
    let setorEmpresa = $('#select-setor').val();

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}romaneios/filtrarClientesRomaneio`,
            data: {
                cidades: cidades,
                ids_etiquetas: etiquetas,
                data_coleta: data_coleta,
                filtrar_data: filtrarData,
                setorEmpresa: setorEmpresa
            },
            beforeSend: function () {
                clientesModalRomaneio.html(checkTodos);
                $('.load-form-romaneio').removeClass('d-none');
                $('.btn-envia-romaneio').addClass('d-none');

            }, success: function (data) {

                $('.load-form-romaneio').addClass('d-none');
                $('.btn-envia-romaneio').removeClass('d-none');

                $('.id-setor-empresa').val(setorEmpresa);

                if (data.registros < 1) {
                    avisoRetorno('Algo deu errado!', 'Não foi encontrado nada com essas informações!', 'error', '#');

                } else {
                    $('#modalRomaneio').modal('show');
                }

                let todosNomesClientes = [];
                let clientesHTML = '';
                for (let i = 0; i < data.registros; i++) {
                    let clienteHTML = `
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static clientes-romaneio">
                        <td class="align-middle white-space-nowrap nome-cliente" data-id="${data.retorno[i].ID_CLIENTE}">
                            <input class="form-check-input check-clientes-modal cursor-pointer check-element" style="margin-right:8px;" name="clientes" type="checkbox" value="${data.retorno[i].ID_CLIENTE}">
                            ${data.retorno[i].CLIENTE}
                        </td>
                    </tr>
                    `;
                    clientesHTML += clienteHTML;
                    todosNomesClientes.push(clienteHTML);
                }

                clientesModalRomaneio.append(clientesHTML);
                $('.todos-clientes').val(todosNomesClientes);
            }
        })
    } else {
        avisoRetorno('Algo deu errado!', 'Escolha uma etiqueta ou uma cidade!', 'error', '#');
        return;
    }
}




// Função para atualizar a lista de clientes
function atualizarListaClientes(nomeDigitado) {

    let clientesSelecionados = $('.ids-selecionados').val().split(','); // array com todos os ids que foram selecionados
    let todosNomesClientes = $('.todos-clientes').val().split(','); // array com todos os nomes dos clientes

    let clientesEncontrados = `
    <tr class="hover-actions-trigger btn-reveal-trigger position-static clientes-romaneio">
        <td class="align-middle white-space-nowrap">
            <input class="form-check-input check-clientes-modal cursor-pointer check-all-element" type="checkbox" style="margin-right:8px;">
            Clientes
        </td>
    </tr>`;



    // Usa o filter para encontrar o nome digitado no array, ignorando o caso
    let clientesFiltrados = todosNomesClientes.filter(function (cliente) {
        return cliente.toLowerCase().includes(nomeDigitado.toLowerCase());
    });

    clientesFiltrados.forEach(function (cliente) {

        clientesEncontrados += cliente

    });

    $('.clientes-modal-romaneio').html(clientesEncontrados);

    clientesSelecionados.forEach(function (idCliente) {
        $('.check-clientes-modal[value="' + idCliente + '"]').prop('checked', true);
    });
}




$('#searchInput').on('input', function () {
    var query = $(this).val();
    atualizarListaClientes(query);
});

const gerarRomaneio = () => {

    let permissao = true;

    $('#select-cliente-modal').val('').trigger('change');

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
    let clientes = $('.ids-selecionados').val().split(',');


    if (!$('.ids-selecionados').val()) {
        avisoRetorno('Algo deu errado', 'Você precisa selecionar algum cliente para gerar o romaneio.', 'error', '#');
        permissao = false;

    }

    let responsavel = $('#select-responsavel').val();
    let veiculo = $('#select-veiculo').val();
    let data_coleta = $('.input-coleta').val();
    let setorEmpresa = $('.id-setor-empresa').val();

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}romaneios/gerarRomaneioEtiqueta`,
            data: {
                clientes: clientes,
                responsavel: responsavel,
                veiculo: veiculo,
                data_coleta: data_coleta,
                setorEmpresa: setorEmpresa
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

    $('#select-cliente-modal').val('').trigger('change');
    $('.div-select-modal').removeClass('d-none');

    $('.select2').select2({
        dropdownParent: "#modalRomaneio",
        theme: 'bootstrap-5'
    });


})

$('#select-cliente-modal').change(function () {

    let cliente = $('#select-cliente-modal option:selected').text(); // cliente que será adicionado

    let valSelectClienteModal = $('#select-cliente-modal option:selected').val().split('|');

    let idClienteNovo = parseInt(valSelectClienteModal[0]); // passa pra inteiro pra fazer a verificação no inArray

    let clientesAdicionados = []; // clientes que já está no modal

    $('.clientes-romaneio').each(function () {

        let idCliente = $(this).find('.nome-cliente').data('id');

        clientesAdicionados.push(idCliente)
    })

    // verifica se o cliente novo já foi adicionado
    if ($.inArray(idClienteNovo, clientesAdicionados) !== -1) {

        avisoRetorno('Algo deu errado.', 'Este cliente já está existe', 'error', '#');
        return;
    }


    $('.div-select-modal').addClass('d-none');

    let clientes = `

        <tr class="hover-actions-trigger btn-reveal-trigger position-static clientes-romaneio">
                    
            <td class="align-middle white-space-nowrap nome-cliente" data-id="${idClienteNovo}">
                <input class="form-check-input check-clientes-modal cursor-pointer check-element" style="margin-right:8px;" name="clientes" type="checkbox" value="${idClienteNovo}">
                ${cliente}
            </td>
        
        </tr>
    `;

    if (idClienteNovo) {

        let todosNomesClientes = $('.todos-clientes').val();


        $('.todos-clientes').val(`${todosNomesClientes} , ${clientes}`);


        $('.clientes-modal-romaneio').append(clientes);
    }


})

const concluirRomaneio = (codRomaneio, idResponsavel, dataRomaneio, idSetorEmpresa) => {

    $('.btn-adicionar-clientes-romaneio').addClass('d-none');

    $('#modalConcluirRomaneio').modal('show');

    $('.id_responsavel').val(idResponsavel);
    $('.code_romaneio').val(codRomaneio);
    $('.data_romaneio').val(dataRomaneio);

    if (codRomaneio) {

        $.ajax({
            type: 'post',
            url: `${baseUrl}romaneios/recebeClientesRomaneios`,
            data: {
                codRomaneio: codRomaneio,
                idSetorEmpresa: idSetorEmpresa

            }, beforeSend: function () {

                $('.dados-clientes-div').html('');

            }, success: function (data) {

                exibirDadosClientes(data.retorno, data.registros, data.residuos, data.pagamentos, data.id_cliente_prioridade);
            }
        })

    }


}


// formata um obj para um array
function formatarArray(obj) {

    var idClientes = [];

    for (var key in obj) {

        if (obj.hasOwnProperty(key)) {

            idClientes.push(obj[key].id_cliente);
        }
    }

    return idClientes;
}


function exibirDadosClientes(clientes, registros, residuos, pagamentos, id_cliente_prioridade, editar = false) {


    var idPrioridades = formatarArray(id_cliente_prioridade); // idsPrioridade formatado

    $('.input-id-setor-empresa').val(clientes[0].id_setor_empresa);

    let codRomaneio = $('.code_romaneio').val();

    $('.nome-setor').val(`${clientes[0].SETOR}`);

    for (let i = 0; i < registros; i++) {

        let dadosClientes = `

        <div class="accordion-item accordion-${i}">

            <h2 class="accordion-header" id="heading${i}">
                <button class="accordion-button accordion-button-${i} ${i != 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${i}" aria-expanded="true">
                    ${clientes[i].nome} (${clientes[i].SETOR})
                    
                    <span class="cliente-${clientes[i].id}">

                    ${idPrioridades.includes(clientes[i].id) ? '*' : ''}
                      
                    </span>
                </button>
            </h2>

            ${editar ? `
                <div class="accordion-collapse collapse ${i == 0 ? 'show' : ''}" id="collapse${i}" aria-labelledby="headingOne" data-bs-parent="#accordionEditar">
                    <div class="form-check mb-0 fs-0 d-flex justify-content-start mt-3">
                        
                        <span title="Remover Cliente" class="cursor-pointer" onclick="deletaClienteRomaneio(${codRomaneio}, ${clientes[i].id})">
                            <span class="fas fa-trash"></span> Remover Cliente
                        </span>
                    </div>
                </div>
            ` : `

            <div class="accordion-collapse collapse ${i == 0 ? 'show' : ''}" id="collapse${i}" aria-labelledby="headingOne" data-bs-parent="#accordionConcluir">

                <input type="hidden" value="${clientes[i].id}" class="input-id-cliente">


                <div class="accordion-body pt-0 row">

                    <div class="col-md-6 mb-2">

                        <label class="form-label">Endereço</label>
                        <input class="form-control input-endereco campos-form-${clientes[i].id}" type="text" placeholder="Endereço do cliente" value="${clientes[i].rua} - ${clientes[i].numero} / ${clientes[i].cidade}">
                    </div>

                    <div class="col-md-6 mb-2">

                        <label class="form-label">Telefone</label>
                        <input class="form-control input-telefone campos-form-${clientes[i].id}" type="text" placeholder="Telefone" value="${clientes[i].telefone}">

                    </div>

                    <div class="col-md-4 mb-2 div-pagamento">

                        <label class="form-label">Forma de Pagamento</label>
                        <select class="form-select select-pagamento w-100 pagamento-${clientes[i].id} campos-form-${clientes[i].id}" id="select-pagamento">

                            <option disabled selected value="">Selecione</option>
                            
                        </select>
                    </div>

                    <div class="col-md-4 mb-2 div-pagamento">

                        <label class="form-label">Valor Pago</label>
                        <input class="form-control input-pagamento pagamento-${clientes[i].id} campos-form-${clientes[i].id}" type="text" placeholder="Digite valor pago" value="">
                    </div>

                    <div class="col-md-4 mb-2 mt-4 row">

                        <button class="btn btn-info duplicar-pagamento w-25">+</button>

                    </div>

                    <div class="pagamentos-duplicados"></div>

                    <div class="col-md-4 mb-2 div-residuo">

                        <label class="form-label">Resíduo Coletado</label>
                        
                        <select class="form-select select-residuo input-obg-${clientes[i].id} w-100 campos-form-${clientes[i].id} ${idPrioridades.includes(clientes[i].id) ? 'input-obrigatorio' : ''}" data-collapse="${i}" id="select-residuo" >

                            <option disabled selected value="">Selecione</option>
                            
                        </select>

                    </div>

                    <div class="col-md-4 mb-2">

                        <label class="form-label">Quantidade Coletada</label>
                        <input class="form-control input-residuo input-obg-${clientes[i].id} campos-form-${clientes[i].id} ${idPrioridades.includes(clientes[i].id) ? 'input-obrigatorio' : ''}" data-collapse="${i}" type="text" placeholder="Digite quantidade coletada" value="">
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
                                <input data-id="${clientes[i].id}" title="Preencha este campo caso não tenha coletado no cliente" class="form-check-input nao-coletado nao-coletado-${clientes[i].id} ${idPrioridades.includes(clientes[i].id) ? 'cliente-prioridade' : ''}" type="checkbox" data-bulk-select='{"body":"members-table-body"}' style="cursor: pointer"/>
                                Não Coletado
                            </div>

                        </div>

                    </div>
                    

                </div>
            </div>
            
            `}

            
        </div>
    `;

        // imprime no modal de editar
        if (editar) {
            $('.dados-clientes-div-editar').append(dadosClientes);

        } else {

            $('.dados-clientes-div').append(dadosClientes);
        }


    }


    // residuos no select
    for (c = 0; c < residuos.length; c++) {

        var optionResiduos = `<option value="${residuos[c].id}">${residuos[c].nome}</option>`;
        $('.select-residuo').append(optionResiduos);
    }

    // formas de pagamento no select
    for (c = 0; c < pagamentos.length; c++) {

        var optionPagamentos = `<option data-id-tipo-pagamento="${pagamentos[c].id_tipo_pagamento}" value="${pagamentos[c].id}">${pagamentos[c].forma_pagamento}</option>`;
        $('.select-pagamento').append(optionPagamentos);
    }
}

// duplica forma de pagamento e residuos
function duplicarElemento(btnClicado, novoElemento, novoInput, classe) {

    // Pega os options do select
    let options = $(btnClicado).closest('.accordion-item').find('.select-' + novoElemento).html();

    let selectHtml = `
        <div class="col-md-4 mb-2 div-${novoElemento}">
            <select class="form-select select-${novoElemento} w-100 ${novoElemento == "residuo" ? 'input-obrigatorio' : ''} " data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}'>
                ${options}
            </select>
        </div>
    `;

    let inputHtml = `
        <div class="col-md-4 mb-2 div-${novoElemento}">
            <input class="form-control input-${novoElemento} ${novoElemento == "residuo" ? 'input-obrigatorio' : ''}" type="text" placeholder="Digite ${novoInput}" value="">
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


// verifica qual é o tipo da forma de pagamento para aplicar mascara
$(document).on('change', '.select-pagamento', function () {

    let valorPagamento = $(this).closest('.div-pagamento').next('.div-pagamento').find('.input-pagamento');

    if ($('option:selected', this).data('id-tipo-pagamento') == "1") {

        valorPagamento.attr('type', 'text');

        valorPagamento.mask('000000000000000.00', { reverse: true });

        valorPagamento.val('');


    } else {

        valorPagamento.attr('type', 'number');
        valorPagamento.unmask();

    }

});



$(document).on('click', '.nao-coletado', function () {

    let idCliente = $(this).data('id');

    if ($(this).is(':checked')) {

        // remove os valores caso tenha sido preenchido
        $('.input-obg-' + idCliente).val('');
        $('.pagamento-' + idCliente).val('');

        $('.input-obg-' + idCliente).removeClass('input-obrigatorio');
        $('.input-obg-' + idCliente).removeClass('invalido');

        if ($(this).hasClass('cliente-prioridade')) {
            $('.aviso-msg').removeClass('d-none');
            $('.aviso-msg').html('Preencha este campo');
            $('.accordion-button').attr('disabled', true);
            $('.btn-finaliza-romaneio').attr('disabled', true);
        }

    } else {

        $('.aviso-msg').addClass('d-none');
        $('.accordion-button').attr('disabled', false);
        $('.btn-finaliza-romaneio').attr('disabled', false);

        if ($(this).hasClass('cliente-prioridade')) {

            $('.input-obg-' + idCliente).addClass('input-obrigatorio');

        }
    }

})

$(document).on('input', '.input-obs', function () {

    if ($(this).val().length < 1 && $('.nao-coletado').is(':checked')) {

        $('.aviso-msg').removeClass('d-none');
        $('.aviso-msg').html('Este campo precisa ser preenchido');
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

    let accordionAberto = false;
    $('.input-obrigatorio').each(function () {

        if (!$(this).val()) {

            let collapse = $(this).data('collapse');

            // abre o accordion com o input vazio
            if (!accordionAberto) {

                if (!$(`#collapse${collapse}`).hasClass('show')) {

                    $(`.accordion-button-${collapse}`).trigger('click');
                }
                accordionAberto = true;
            }

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

        let salvarDados = false; // uso para dar permissao para salvar os valores no array e mandar pro back

        if ($(this).find('.nao-coletado').is(':checked')) {

            var coletado = 0;
            salvarDados = true;

        } else {
            var coletado = 1;
        }

        // valores resíduos 
        let residuosSelecionados = [];

        $(this).find('.select-residuo option:selected').each(function () {

            if ($(this).val() != '') {

                residuosSelecionados.push($(this).val());
            }
        });

        let qtdResiduos = [];

        $(this).find('.input-residuo').each(function () {

            if ($(this).val() != '') {

                qtdResiduos.push($(this).val());
                salvarDados = true;
            }
        });

        // valores pagamentos
        let formaPagamentoSelecionados = [];

        $(this).find('.div-pagamento .select-pagamento option:selected').each(function () {

            if ($(this).val() != '') {

                formaPagamentoSelecionados.push($(this).val());
            }

        });

        let valorPagamento = [];

        $(this).find('.div-pagamento .input-pagamento').each(function () {

            if ($(this).val() != '') {

                valorPagamento.push($(this).val());
            }

        });

        // salva somente os dados dos clientes que foram preenchidos
        if (salvarDados) {

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
        }

    });

    var idSetorEmpresa = $('.input-id-setor-empresa').val();

    if (permissao) {
        $.ajax({
            type: "POST",
            url: `${baseUrl}coletas/cadastraColeta`,
            data: {
                clientes: dadosClientes,
                idResponsavel: idResponsavel,
                codRomaneio: codRomaneio,
                dataRomaneio: dataRomaneio,
                idSetorEmpresa: idSetorEmpresa,
                verificaAgendamentosFuturos: true

            },
            beforeSend: function () {
                $('.btn-finaliza-romaneio').addClass('d-none');
                $('.load-form-modal-romaneio').removeClass('d-none');
            },
            success: function (data) {
                $('.btn-finaliza-romaneio').removeClass('d-none');
                $('.load-form-modal-romaneio').addClass('d-none');

                if (data.proximosAgendamentos && data.success) {

                    let agendamentosFuturos = data.agendamentos.flatMap(array => array.map(item => ({
                        data_agendamento: item.data_coleta,
                        id_cliente: item.ID_CLIENTE,
                        id_setor_empresa: item.id_setor_empresa
                    })));

                    let nomesClientes = data.agendamentos
                        .filter(subArray => subArray && subArray[0] && subArray[0].nome)
                        .map(subArray => subArray[0].nome);

                    Swal.fire({
                        html: `
                            <p>Agendamentos futuros encontrados para os seguintes clientes:</p>
                            <ul style="list-style-position: inside; padding-left: 0;">
                                ${nomesClientes.map(nome => `<li><strong>${nome}</strong></li>`).join('')}
                            </ul>
                            <p>Gostaria de remover os próximos agendamentos e continuar com um novo agendamento?</p>
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Não',
                        confirmButtonText: 'Sim, remover'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'post',
                                url: `${baseUrl}coletas/cancelaProximosAgendamentosCliente`,
                                data: {
                                    agendamentosFuturos: agendamentosFuturos,
                                    dataRomaneio: dataRomaneio,
                                    codRomaneio: codRomaneio,

                                },
                                success: function () {
                                    avisoRetorno(`Sucesso!`, `O romaneio foi concluído com sucesso`, `success`, `${baseUrl}romaneios`);
                                }
                            });
                            // salva os agendamentos sem cancelar os próximos
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            $.ajax({
                                type: 'post',
                                url: `${baseUrl}coletas/cadastraColeta`,
                                data: {
                                    clientes: dadosClientes,
                                    idResponsavel: idResponsavel,
                                    codRomaneio: codRomaneio,
                                    dataRomaneio: dataRomaneio,
                                    idSetorEmpresa: idSetorEmpresa
                                },
                                success: function () {
                                    avisoRetorno(`Sucesso!`, `O romaneio foi concluído com sucesso sem remover os agendamentos`, `success`, `${baseUrl}romaneios`);
                                }
                            });
                        }
                    });
                } else if (data.success && !data.proximosAgendamentos) {
                    avisoRetorno('Sucesso!', 'O romaneio foi concluído com sucesso', 'success', `${baseUrl}romaneios`);
                } else {
                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');
                }
            },
            error: function (xhr, status, error) {
                $('.btn-finaliza-romaneio').removeClass('d-none');
                $('.load-form-modal-romaneio').addClass('d-none');
                if (xhr.status === 403) {
                    avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação..`, 'error', '#');
                }
            }
        })
    }


}

// carrega o select2
$(document).ready(function () {

    $('.select2').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
    });
})


// busca as cidades dos clientes por setor
function recebeCidadeClientesSetor(idSetor) {

    $.ajax({
        type: 'POST',
        url: `${baseUrl}romaneios/recebeCidadeClientesSetor`,
        data: {
            id_setor: idSetor
        }, success: function (data) {

            $('#select-cidades').html('');

            for (let i = 0; i < data.cidades.length; i++) {

                $('#select-cidades').append(`<option value="${data.cidades[i]['cidade']}">${data.cidades[i]['cidade']}</option>`);

            }

        }

    })

}

// busca os clientes por etiqueta e setor
function recebeClientesEtiquetaSetor(idSetor) {

    $.ajax({
        type: 'POST',
        url: `${baseUrl}setoresEmpresaCliente/recebeClientesEtiquetaSetor`,
        data: {
            id_setor: idSetor
        }, success: function (data) {

            $('#select-etiquetas').html('');

            for (let i = 0; i < data.clientesEtiquetaSetor.length; i++) {

                $('#select-etiquetas').append(`<option value="${data.clientesEtiquetaSetor[i]['id_etiqueta']}">${data.clientesEtiquetaSetor[i]['nome']}</option>`);

            }

        }

    })

}

// busca os clientes por setor
function recebeClientesSetor(idSetor) {

    $.ajax({
        type: 'POST',
        url: `${baseUrl}setoresEmpresaCliente/recebeClientesSetor`,
        data: {
            id_setor: idSetor
        }, success: function (data) {

            $('#select-cliente-modal').html('<option selected disabled value="">Selecione o cliente</option>');

            let options = data.clientesSetor.map(cliente => {
                return `<option value="${cliente['ID_CLIENTE']}">${cliente['CLIENTE']}</option>`;
            });

            // Adicionando as options ao select de uma vez
            $('#select-cliente-modal').append(options);

            $('.div-select-cliente').removeClass('d-none');

        }

    })

}

// seleciona os clientes por setor
$(".select-setor").change(function () {

    if ($(this).val() != null) {

        $('#id-setor-empresa').val($(this).val());

        recebeClientesSetor($(this).val());
        recebeCidadeClientesSetor($(this).val());
        recebeClientesEtiquetaSetor($(this).val());

        $('#select-cidades').attr('disabled', false); // habilita o select de clientes
        $('#select-etiquetas').attr('disabled', false); // habilita o select de etiquetas
        $('#select-etiquetas').attr('disabled', false); // habilita o select de etiquetas

    }

});

const deletarRomaneio = (id) => {

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
                type: 'post',
                url: `${baseUrl}romaneios/deletaRomaneio`,
                data: {
                    id: id
                }, success: function (data) {

                    let redirect = data.redirect ? `${baseUrl}romaneios` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                }
            })

        }
    })


}

const novoClienteRomaneio = () => {

    $('.btn-adicionar-clientes-romaneio').attr('disalbed', true);

    $('.select2-edita').select2({
        dropdownParent: "#modalEditarRomaneio",
        theme: 'bootstrap-5'
    });

    let idSetorEmpresa = $('.input-id-setor-empresa').val();

    recebeClientesSetor(idSetorEmpresa);
}

$(document).on('click', '.adicionar-cliente', function () {

    if (!$('.add-novo-cliente-romaneio').val()) {

        $('.aviso-novo-cliente-romaneio').removeClass('d-none');
        $('.aviso-novo-cliente-romaneio').html('Escolha um cliente.');

        return;
    } else {
        $('.aviso-novo-cliente-romaneio').addClass('d-none');

    }

    let codRomaneio = $('.code_romaneio').val();
    let idCliente = $('.add-novo-cliente-romaneio option:selected').val();

    let nomeSetor = $('.nome-setor').val();


    $.ajax({
        type: 'post',
        url: `${baseUrl}romaneios/adicionaNovoClienteRomaneio`,
        data: {
            romaneio: codRomaneio,
            cliente: idCliente

        }, success: function (data) {

            $('.div-select-cliente').addClass('d-none');


            if (data.success) {

                $('.aviso-novo-cliente-romaneio').addClass('d-none');

                let cliente = $('.add-novo-cliente-romaneio option:selected').text();

                let dadosClientes = `

                    <div class="accordion-item accordion-${idCliente}">

                        <h2 class="accordion-header" id="heading${idCliente}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${idCliente}" aria-expanded="true" aria-controls="collapse${idCliente}">
                                ${cliente} (${nomeSetor})
                                
                                <span class="cliente-${idCliente}">
                                    
                                </span>
                            </button>
                        </h2>


                        

                        <div class="accordion-collapse collapse" id="collapse${idCliente}" aria-labelledby="headingOne" data-bs-parent="#accordionConcluir">

                            <input type="hidden" value="${idCliente}" class="input-id-cliente">

                            <div class="form-check mb-0 fs-0 d-flex justify-content-start mt-3">
                        
                                <span title="Remover Cliente" class="cursor-pointer" onclick="deletaClienteRomaneio(${codRomaneio}, ${idCliente})">
                                    <span class="fas fa-trash"></span> Remover Cliente
                                </span>
                            </div>
                            
                        </div>
                    </div>
                `;

                $('.dados-clientes-div-editar').append(dadosClientes);
                avisoRetorno(`Sucesso!`, `O cliente foi adicionado ao romaneio com sucesso!`, `success`, `#`);

            } else {
                avisoRetorno(`Algo deu errado!`, `Este cliente já faz parte do romaneio!`, `error`, `#`);


            }


        }
    })


})


const editarRomaneio = (codRomaneio, idResponsavel, dataRomaneio, idSetorEmpresa) => {

    $('#select-cliente-modal').val('').trigger('change');

    $('.div-select-cliente').addClass('d-none');

    $('#modalEditarRomaneio').modal('show');
    $('.btn-adicionar-clientes-romaneio').removeClass('d-none');

    carregaSelect2('select2', 'modalEditarRomaneio');

    $('#select-editar-motorista').val(idResponsavel).trigger('change');

    $('.id_responsavel').val(idResponsavel);
    $('.code_romaneio').val(codRomaneio);
    $('.data_romaneio').val(dataRomaneio);

    if (codRomaneio) {

        $.ajax({
            type: 'post',
            url: `${baseUrl}romaneios/recebeClientesRomaneios`,
            data: {
                codRomaneio: codRomaneio,
                idSetorEmpresa: idSetorEmpresa

            }, beforeSend: function () {

                $('.dados-clientes-div-editar').html('<div class="spinner-border text-primary load-clientes" role="status"></div>');

            }, success: function (data) {

                $('.load-clientes').addClass('d-none');

                exibirDadosClientes(data.retorno, data.registros, data.residuos, data.pagamentos, data.id_cliente_prioridade, true);

            }
        })

    }

}

$(document).on('click', '.btn-salva-edicao-romaneio', function () {

    let idMotorista = $('#select-editar-motorista').val();
    let codRomaneio = $('.code_romaneio').val();

    if (idMotorista != $('.id_responsavel').val()) {
        $.ajax({
            type: 'post',
            url: `${baseUrl}romaneios/editaMotoristaRomaneio`,
            data: {
                idMotorista: idMotorista,
                codRomaneio: codRomaneio

            }, beforeSend: function () {

                $('.load-form-modal-romaneio').removeClass('d-none');
                $('.btn-salva-edicao-romaneio').addClass('d-none');

            }, success: function (data) {

                $('.load-form-modal-romaneio').addClass('d-none');
                $('.btn-salva-edicao-romaneio').removeClass('d-none');


                avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${baseUrl}romaneios`);


            }
        })
    } else {
        $('#modalEditarRomaneio').modal('hide');
    }



})

const deletaClienteRomaneio = (romaneio, cliente) => {

    if (romaneio) {

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
                    url: `${baseUrl}romaneios/deletaClienteRomaneio`,
                    data: {
                        romaneio: romaneio,
                        cliente: cliente
                    }, success: function (data) {

                        $('.accordion-' + cliente).remove();

                        if (data.redirect) {

                            avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${baseUrl}romaneios`);
                        }
                    }
                })

            }
        })
    } else {
        $('.accordion-' + cliente).remove();
    }

}

const buscarRomaneioPorData = (dataRomaneio, idRomaneio) => {


    if (!$('.btn-accordion-' + idRomaneio).hasClass('collapsed')) {

        $.ajax({
            type: "post",
            url: `${baseUrl}romaneios/recebeRomaneioPorData`,
            data: {
                dataRomaneio: dataRomaneio
            }, beforeSend: function () {
                $('.head-romaneio').addClass('d-none');
                $('.accortion-' + idRomaneio).html('');
                $('.load-' + idRomaneio).removeClass('d-none');
            }, success: function (data) {

                $('.head-romaneio').removeClass('d-none');
                $('.load-' + idRomaneio).addClass('d-none');

                let htmlClientes = data.romaneios.map((romaneio, index) => {

                    // separando a data e hora
                    let partesDataHora = romaneio.criado_em.split(" ");
                    let data = partesDataHora[0]; //só a data
                    let hora = partesDataHora[1]; // só a hora

                    // separar partes para formatar br
                    let partesData = data.split("-");
                    let dataCompleta = `${partesData[2]}/${partesData[1]}/${partesData[0]} ${hora}`; // data e hora formatado

                    return `
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">

                        <td class="email align-middle white-space-nowrap">
                            ${romaneio.codigo}
                        </td>
            
                        <td class="mobile_number align-middle white-space-nowrap">
                            ${romaneio.RESPONSAVEL}
                        </td>
            
                        <td class="mobile_number align-middle white-space-nowrap">
                            ${dataCompleta}
                        </td>
            
                        <td class="align-middle white-space-nowrap">
                            <i class="fas fa-check-circle ${romaneio.status == 1 ? 'text-success' : ''}"></i>
                        </td>
                        
                        <td>
                            <div class="font-sans-serif btn-reveal-trigger position-static">
                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2">
            
                                    <a target="_blank" class="dropdown-item" href="${baseUrl}romaneios/gerarromaneio/${romaneio.codigo}" title="Gerar Romaneio">
                                        <span class="fas fa-download ms-1"></span> Gerar
                                    </a>

                                    ${romaneio.status == 0 ? `
                                        <a class="dropdown-item" href="#" title="Concluir Romaneio" onclick="concluirRomaneio('${romaneio.codigo}', ${romaneio.ID_RESPONSAVEL}, '${romaneio.data_romaneio}', ${romaneio.id_setor_empresa})">
                                            <span class="ms-1 fas fa-check-circle"></span> Concluir
                                        </a>
                                    ` : ''}

                                    ${romaneio.status == 1 ? `
                                        <a class="dropdown-item" href="${baseUrl}romaneios/detalhes/${romaneio.codigo}" title="Visualizar Romaneio">
                                            <span class="ms-1" data-feather="eye"></span> Visualizar
                                        </a>
                                    ` : ''}

                                    ${romaneio.status == 0 ? `
                                        <a class="dropdown-item" href="#" title="Editar Romaneio" onclick='editarRomaneio(${romaneio.codigo}, ${romaneio.ID_RESPONSAVEL}, "${romaneio.data_romaneio}", ${romaneio.id_setor_empresa})'>
                                            <span class="ms-1 fas fa-pencil"></span> Editar
                                        </a>
                                    ` : ''}

                                    ${romaneio.status == 0 ? `
                                        <a class="dropdown-item" href="#" title="Deletar Romaneio" ${romaneio.status == 0 ? 'disabled' : ''} onclick='deletarRomaneio(${romaneio.ID_ROMANEIO})'>
                                            <span class="fas fa-trash ms-1"></span> Deletar
                                        </a>
                                    ` : ''}

                                </div>
                            </div>
                    
                        </td>
                    </tr>
                `;
                }).join('');



                $('.accortion-' + idRomaneio).html(htmlClientes);

            }
        })
    }
}



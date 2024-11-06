var baseUrl = $('.base-url').val();

let filtrarClientesRomaneio = () => {




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

    $('.select2').select2({
        dropdownParent: "#modalRomaneio",
        theme: 'bootstrap-5'
    });
}


$('#modalRomaneio').on('hide.bs.modal', function (e) {
    $('.select2').select2({
        theme: 'bootstrap-5'
    });
});



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


$(document).on('click', '.btn-salva-romaneio', function () {

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


    if (!$('.ids-selecionados').val()) {
        avisoRetorno('Algo deu errado', 'Você precisa selecionar algum cliente para gerar o romaneio.', 'error', '#');
        permissao = false;
    }

    if (permissao) {

        $('#modalSaldoMotoristaRomaneio').modal('show');
        $('#modalRomaneio').modal('hide');
        carregaSelect2('select2', 'modalSaldoMotoristaRomaneio');
        $('.mascara-dinheiro').mask('000.000.000.000.000,00', { reverse: true });
    }


})

const gerarRomaneio = () => {

    let permissao = true;

    $('#select-cliente-modal').val('').trigger('change');

    // novo clientes para gerar romaneio
    let clientes = $('.ids-selecionados').val().split(',');

    let responsavel = $('#select-responsavel').val();
    let veiculo = $('#select-veiculo').val();
    let data_coleta = $('.input-coleta').val();
    let setorEmpresa = $('.id-setor-empresa').val();

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}romaneios/gerarRomaneio`,
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

                    adicionarVerbasResponsavel(data.codigo_romaneio, data.data_romaneio)
                } else {
                    avisoRetorno('Erro!', data.message, 'error', `${baseUrl}romaneios/formulario/`);

                }
            }

        })
    }

}

$(document).on('click', '.btn-salva-verba-responsavel', function () {

    gerarRomaneio();

})

function adicionarVerbasResponsavel(codRomaneio, dataRomaneio) {

    let permissao = true;

    let setorEmpresa = $('.id-setor-empresa').val();

    let dadosFormulario = {};
    if (permissao) {

        $(`.form-verba-responsavel-coleta`).find("select, input").each(function () {

            let inputName = $(this).attr('name');
            let inputValue = $(this).val();

            if (!dadosFormulario[inputName]) {
                dadosFormulario[inputName] = [];
            }

            // Adiciona o valor ao array
            dadosFormulario[inputName].push(inputValue);

            if (!$('.check-sem-verba').is(':checked')) {
                permissao = verificaCamposObrigatorios('input-obrigatorio-verba');
            }

        });

        let responsavel = $('#select-responsavel').val();

        if (permissao) {

            $.ajax({
                type: 'post',
                url: `${baseUrl}finFluxoCaixa/insereMovimentacaoRomaneioFluxo`,
                data: {
                    dadosFluxo: dadosFormulario,
                    responsavel: responsavel,
                    codRomaneio: codRomaneio,
                    setorEmpresa: setorEmpresa,
                    dataRomaneio: dataRomaneio


                }, beforeSend: function () {

                    $('.load-form-pagamento').removeClass('d-none');
                    $('.btn-salva-verba-responsavel').addClass('d-none');

                }, success: function (data) {

                    $('.load-form-pagamento').addClass('d-none');
                    $('.btn-salva-verba-responsavel').removeClass('d-none');

                }
            })
        }


    }
}

$(document).on('click', '.check-sem-verba', function () {

    if ($(this).is(':checked')) {

        $('.duplicar-pagamento').prop('disabled', true);
        $('.duplicar-pagamento').addClass('text-success');

        $('.input-obrigatorio-verba').each(function () {
            $(this).removeClass('invalido');
            $(this).next().removeClass('select2-obrigatorio');
            $(this).val('').trigger('change');
            $(this).val('');
            $(this).attr('disabled', true);
        })

        $('.aviso-obrigatorio').each(function () {
            $(this).addClass('d-none');
        })

        $('.campos-duplicados').html('');
    } else {

        $('.duplicar-pagamento').prop('disabled', false);
        $('.duplicar-pagamento').removeClass('text-success');

        $('.input-obrigatorio-verba').each(function () {
            $(this).attr('disabled', false)
        })

    }
})

$(document).on('click', '.duplicar-pagamento', function () {

    duplicarElementos('romaneio');

});

$(document).on('click', '.duplicar-verbas-pagamento', function () {

    duplicarElementos('verbas');

});


async function recebeFormasTransacao() {
    let optionsFormaPagamento = "<option selected disabled value=''>Selecione</option>";

    try {
        let response = await $.ajax({
            type: "post",
            url: `${baseUrl}finContaBancaria/recebeFormasTransacao`
        });

        for (let c = 0; c < response.length; c++) {
            optionsFormaPagamento += `<option data-id-tipo-pagamento="1" value="${response[c].id}">${response[c].nome}</option>`;
        }
    } catch (error) {
        console.error('Erro ao obter formas de transação:', error);
    }

    return optionsFormaPagamento;
}


// duplica forma de pagamento e residuos
async function duplicarElementos(nomeModal) {

    // Pega os options do select
    let optionsContaBancaria = $('.select-conta-bancaria').html();
    let optionsFormaPagamento = await recebeFormasTransacao();

    let contaBancaria = `
        <div class="col-md-4 mb-2 mt-2">
            <select class="select2 form-select select-conta-bancaria w-100" name="conta-bancaria">
                ${optionsContaBancaria}
            </select>
            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
        </div>
    `;

    let formaPagamento = `
        <div class="col-md-4 mb-2 mt-2">
            <select class="select2 form-select select-forma-pagamento w-100" name="forma-pagamento">
                ${optionsFormaPagamento}
            </select>
            <div class="d-none aviso-obrigatorio">Preencha este campo</div>
        </div>
    `;

    let inputValor = `
        <div class="col-md-3 mb-2">
            <input class="form-control mt-2 input-valor mascara-dinheiro" type="text" placeholder="Valor" name="valor">
        </div>
        <div class="d-none aviso-obrigatorio">Preencha este campo</div>
    `;

    let btnRemove = $(`
    <div class="col-md-1 mb-2 mt-1">

        <button class="btn btn-phoenix-danger remover-inputs">-</button>

    </div>`);

    // div com row para cada grupo ficar em row diferente
    let novaLinha = $('<div class="row"></div>');

    // imprime os elementos dentro da div row
    novaLinha.append(contaBancaria);
    novaLinha.append(formaPagamento);
    novaLinha.append(inputValor);
    novaLinha.append(btnRemove);
    let idMacro = $('.select-macros option:selected').val();
    let idMicro = $('.select-micros option:selected').val();
    novaLinha.append(`<input type="hidden" name="id_macro" value="${idMacro}"><input type="hidden" name="id_micro" value="${idMicro}">`); // macro Custo Operacional micro insumo de produção

    //remove a linha duplicada
    btnRemove.find(`.remover-inputs`).on('click', function () {

        novaLinha.remove();
    });

    $(`.campos-duplicados`).append(novaLinha);

    $('.mascara-dinheiro').mask('000.000.000.000.000,00', { reverse: true });

    if (nomeModal == "verbas") {
        $(`.select2`).select2({
            dropdownParent: `.modal-verbas-select2`,
            theme: "bootstrap-5",
        });
    } else {

        $(`.select2`).select2({
            dropdownParent: `.modal-romaneio-select2`,
            theme: "bootstrap-5",
        });
    }


}

$(document).on('click', '.add-cliente', function () {

    $('#select-cliente-modal').val('').trigger('change');
    $('.div-select-modal').removeClass('d-none');
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

                $('.responsavel').html(`${data.responsavel}`);

                exibirDadosClientes(data.retorno, data.registros, data.residuos, data.pagamentos, data.id_cliente_prioridade);
                carregaSelect2('select2', 'modalConcluirRomaneio');
            }
        })
    }


}

const verificaPrestacaoContasFuncionario = (codRomaneio, idResponsavel, dataRomaneio, idSetorEmpresa) => {

    $.ajax({
        type: "post",
        url: `${baseUrl}finPrestacaoContas/verificaPrestacaoContasFuncionario`,
        data: {
            codRomaneio: codRomaneio,
            idResponsavel: idResponsavel,
            dataRomaneio: dataRomaneio
        },
        success: function (response) {

            if (response) {
                avisoRetorno(`Pendências de Romaneios`, `Para concluir este romaneio, é necessário prestar contas do romaneio anterior vinculado a este funcionário. Por favor, regularize as pendências para prosseguir.`, 'error', `#`);
            } else {
                concluirRomaneio(codRomaneio, idResponsavel, dataRomaneio, idSetorEmpresa)
            }
        },
        error: function (xhr, status, error) {
            avisoRetorno(`Erro ${xhr.status}`, `Entre em contato com o administrador.`, 'error', `${baseUrl}`);
        }

    });

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

                    <div class="col-md-3 mb-2 div-pagamento">

                        <label class="form-label">Tipo de Pagamento</label>
                        <select data-collapse="${i}" class="select2 form-select select-tipo-pagamento w-100 tipo-pagamento-${clientes[i].id} campos-form-${clientes[i].id}" id="select-tipo-pagamento-${i}">

                            <option disabled selected value="">Selecione</option>
                            <option value="0">Pagamento no ato</option>
                            <option value="1">Pagamento a prazo</option>
                            
                        </select>
                    </div>

                    <div class="col-md-3 mb-2 div-pagamento d-none div-conta-bancaria">
                        <label class="form-label">Conta bancária</label>
                        <select data-collapse="${i}" class="select2 form-select w-100 select-conta-bancaria">
                            <option disabled selected value="">Selecione</option>
                            
                        </select>
                    </div>

                    <div class="col-md-3 mb-2 div-pagamento div-select-forma-pagamento">

                        <label class="form-label forma">Forma de Pagamento</label>
                        <select data-collapse="${i}" class="select2 form-select select-pagamento w-100 pagamento-${clientes[i].id} campos-form-${clientes[i].id}" id="select-pagamento-${i}">

                            <option disabled selected value="">Selecione</option>
                            
                        </select>
                    </div>

                    <div class="col-md-2 mb-2 div-pagamento">

                        <label class="form-label valor">Valor Pago</label>
                        <input data-collapse="${i}" class="form-control input-pagamento pagamento-${clientes[i].id} campos-form-${clientes[i].id}" type="text" placeholder="Digite valor pago" value="">

                    </div>

                    
                    <div class="col-md-auto mb-2 mt-4">
                    
                        <button class="btn btn-phoenix-success duplicar-pagamento">+</button>
                    
                    </div>

                    <div class="col-md-12 div-checkbox mb-5">
                        <input class="cursor-pointer form-check-input checkbox-funcionario" type="checkbox" value="1">  Pago pelo responsável da coleta
                    </div>

                    <div class="pagamentos-duplicados"></div>

                    <div class="col-md-4 mb-2 div-residuo">

                        <label class="form-label">Resíduo Coletado</label>
                        
                        <select class="select2 form-select select-residuo input-obg-${clientes[i].id} w-100 campos-form-${clientes[i].id} ${idPrioridades.includes(clientes[i].id) ? 'input-obrigatorio' : ''}" data-collapse="${i}" id="select-residuo-${i}" >
                        
                            <option disabled selected value="">Selecione</option>
                            
                        </select>
                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                    </div>

                    <div class="col-md-4 mb-2 div-residuo">

                        <label class="form-label">Quantidade Coletada</label>
                        <input class="form-control input-residuo input-obg-${clientes[i].id} campos-form-${clientes[i].id} ${idPrioridades.includes(clientes[i].id) ? 'input-obrigatorio' : ''}" data-collapse="${i}" type="text" placeholder="Digite quantidade coletada" value="">
                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                    </div>

                    <div class="col-md-3 mb-2 div-residuo">

                        <label class="form-label">Valor do resíduo</label>
                        <input data-id-cliente="${clientes[i].id}" class="mask-valor-residuo form-control input-valor-residuo input-obg-${clientes[i].id} campos-form-${clientes[i].id}" data-collapse="${i}" type="text" placeholder="Digite o valor do resíduo">
                        <div class="d-none aviso-obrigatorio">Preencha este campo</div>

                    </div>

                    <div class="col-md-auto mb-2 mt-4">

                        <button data-id-cliente="${clientes[i].id}" class="btn btn-phoenix-success duplicar-residuo">+</button>

                    </div>

                    <div class="residuos-duplicados"></div>

                    <div class="div-obs">

                        <div class="col-12">
                            <label class="form-label">Observação</label>
                            <textarea class="form-control input-obs input-ons-${clientes[i].id}" id="exampleTextarea" rows="3"></textarea>
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

        let optionPagamentos = `<option data-id-tipo-pagamento="1" value="${pagamentos[c].id}">${pagamentos[c].nome}</option>`;

        for (let i = 0; i < registros; i++) {
            $(`#select-pagamento-${i}`).append(optionPagamentos);

        }
    }


    $('.mask-valor-residuo').mask('000000000000000.00', { reverse: true });

}


// duplica forma de pagamento e residuos
function duplicarElemento(btnClicado, novoElemento, novoInput, classe, idCliente) {

    let selectTipoPagamento = `
        <div class="col-md-3 mb-2 div-pagamento">
            <label class="form-label mt-2">Tipo de pagamento</label>
            <select class="select2 form-select select-tipo-pagamento w-100">
                <option disabled selected value="">Selecione</option>
                <option value="0">Pagamento no ato</option>
                <option value="1">Pagamento a prazo</option>
            </select>
        </div>
    `;

    let selectContaBancaria = `
        <div class="col-md-3 mb-2 div-pagamento div-conta-bancaria d-none">
            <label class="form-label mt-2">Conta bancária</label>
            <select class="select2 form-select w-100 select-conta-bancaria">
                <option disabled selected value="">Selecione</option>
            </select>
        </div>
    `;

    let inputValorResiduo = `
        <div class="col-md-3 mb-2 div-residuo">
            <input data-id-cliente="${idCliente}" class="mask-valor-residuo form-control input-valor-residuo" type="text" placeholder="Digite o valor do resíduo">
        </div>
    `;

    // Pega os options do select
    let options = $(btnClicado).closest('.accordion-item').find('.select-' + novoElemento).html();

    let selectHtml = `

        <div class="${novoElemento == "pagamento" ? 'col-md-3 div-select-forma-pagamento' : 'col-md-4'} mb-2 div-${novoElemento}">
        
            ${novoElemento == "pagamento" ? `
                <label class="form-label mt-2">Forma de pagamento</label>`
            : ''}

            <select class="select2 form-select select-${novoElemento} w-100 ${novoElemento == "residuo" ? 'input-obrigatorio' : ''} ">
                ${options}
            </select>
        </div>
    `;

    let inputHtml = `
        <div class="${novoElemento == "pagamento" ? 'col-md-2' : 'col-md-4'} mb-2 div-${novoElemento}">

            ${novoElemento == "pagamento" ? `
                <label class="form-label mt-2">Valor Pago</label>`
            : ''}

            <input class="form-control input-${novoElemento} ${novoElemento == "residuo" ? 'input-obrigatorio' : ''}" type="text" placeholder="Digite ${novoInput}" value="">
        </div>
    `;

    let checkboxFuncionario = `
        <div class="col-md-12 div-checkbox mb-5">
         <input class="form-check-input checkbox-funcionario" value="1" type="checkbox">  Pago pelo responsável da coleta
        </div>
    `;

    let btnRemove = $(`
    <div class="col-md-auto mb-2 ${novoElemento == "pagamento" ? 'mt-4' : 'mt-1'}">

        <button class="btn btn-phoenix-danger remover-${novoElemento}">-</button>

    </div>`);

    // div com row para cada grupo ficar em row diferente
    let novaLinha = $('<div class="row"></div>');

    // imprime os elementos dentro da div row
    if (novoElemento == "pagamento") {
        novaLinha.append(selectTipoPagamento);
        novaLinha.append(selectContaBancaria);
    }
    novaLinha.append(selectHtml);
    novaLinha.append(inputHtml);


    if (novoElemento == "residuo") {
        novaLinha.append(inputValorResiduo);
    }

    novaLinha.append(btnRemove);

    if (novoElemento == "pagamento") {

        novaLinha.append(checkboxFuncionario);
    }

    //remove a linha duplicada
    btnRemove.find(`.remover-${novoElemento}`).on('click', function () {

        novaLinha.remove();
    });

    $(btnClicado).closest('.accordion-item').find(`.${classe}`).append(novaLinha);

    $('.mask-valor-residuo').mask('000000000000000.00', { reverse: true });

    $(`.select2`).select2({
        dropdownParent: `.modal-romaneio-select2`,
        theme: "bootstrap-5",
    });

}

$(document).on('click', '.duplicar-residuo', function () {

    let idCliente = $(this).data('id-cliente');

    duplicarElemento(this, 'residuo', 'quantidade coletada', 'residuos-duplicados', idCliente);

});

$(document).on('click', '.duplicar-pagamento', function () {

    duplicarElemento(this, 'pagamento', 'valor pago', 'pagamentos-duplicados', null);

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
        $('.input-obg-' + idCliente).val('').trigger('change');
        $('.pagamento-' + idCliente).val('').trigger('change');
        $('.tipo-pagamento-' + idCliente).val('').trigger('change');

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

    let dadosClientes = [];
    let idResponsavel = $('.id_responsavel').val();
    let codRomaneio = $('.code_romaneio').val();
    let dataRomaneio = $('.data_romaneio').val();

    let valorTotal = 0;

    $('.accordion-item').each(function () {

        let formasPagamentosContaBancarias = [];
        let contasBancarias = [];
        let valorContaBancaria = [];


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

        // checkbox
        let checkboxFuncionarios = [];
        $(this).find('.checkbox-funcionario').each(function () {

            let divPagamento = $(this).closest('.col-md-12').prevAll('.div-pagamento');

            let tipoMoedaPagamento = divPagamento.find('.select-pagamento option:selected').data('id-tipo-pagamento');

            let tipoPagamento = divPagamento.find('.select-tipo-pagamento option:selected').val();

            if (tipoPagamento == 1) {
                $(this).prop('checked', false);
            }

            if ($(this).is(':checked')) {

                if (tipoMoedaPagamento == 1 && tipoPagamento == 0) {

                    let inputValorPagamento = divPagamento.find('.input-pagamento').val();

                    // Converta inputValorPagamento para um número
                    let valorNumerico = parseFloat(inputValorPagamento) || 0;

                    valorTotal += valorNumerico;

                    checkboxFuncionarios.push(valorNumerico);
                }

            } else {

                let contaBancaria = divPagamento.find('.select-conta-bancaria option:selected').val();
                contasBancarias.push(contaBancaria);

                let inputValorPagamento = divPagamento.find('.input-pagamento').val();
                valorContaBancaria.push(inputValorPagamento);

                let formaPagamentoContaBancaria = divPagamento.find('.select-pagamento option:selected').val();
                formasPagamentosContaBancarias.push(formaPagamentoContaBancaria)

            }


        });


        let qtdResiduos = [];

        $(this).find('.input-residuo').each(function () {

            if ($(this).val() != '') {

                qtdResiduos.push($(this).val());
                salvarDados = true;
            }
        });

        let valoresResiduos = [];

        $(this).find('.input-valor-residuo').each(function () {

            if ($(this).val() != '') {

                valoresResiduos.push($(this).val());
                salvarDados = true;
            }
        });

        // valores pagamentos
        let formaPagamentoSelecionados = [];

        $(this).find('.div-pagamento .select-pagamento option:selected').each(function () {

            let divPagamento = $(this).closest('.col-md-3').prevAll('.div-pagamento');

            let tipoPagamento = divPagamento.find('.select-tipo-pagamento option:selected').val();

            let checkboxFuncionario = $(this).closest('.col-md-3').siblings().find('.checkbox-funcionario');

            // grava o valor pra exibir no relatorio somente oq foi pago no ato
            if ($(this).val() != '' && tipoPagamento == 0) {

                formaPagamentoSelecionados.push($(this).val());

            }

        });

        let valorPagamento = [];


        $(this).find('.div-pagamento .input-pagamento').each(function () {

            let divPagamento = $(this).closest('.col-md-2').prevAll('.div-pagamento');

            let tipoPagamento = divPagamento.find('.select-tipo-pagamento option:selected').val();

            // grava o valor pra exibir no relatorio somente oq foi pago no ato
            if ($(this).val() != '' && tipoPagamento == 0) {

                valorPagamento.push($(this).val());

            }

        });

        // valores pagamentos
        let tiposPagamentos = [];

        $(this).find('.div-pagamento .select-tipo-pagamento option:selected').each(function () {

            if ($(this).val() != '') {

                tiposPagamentos.push($(this).val());
            }

        });


        // salva somente os dados dos clientes que foram preenchidos
        if (salvarDados) {

            let dadosBancarios = {
                valor: [],
                idContaBancaria: [],
                formaPagamentoContaBancaria: []
            };

            dadosBancarios.valor.push(valorContaBancaria);
            dadosBancarios.idContaBancaria.push(contasBancarias);
            dadosBancarios.formaPagamentoContaBancaria.push(formasPagamentosContaBancarias);


            let dadosCliente = {
                dadosBancarios: dadosBancarios,
                idCliente: $(this).find('.input-id-cliente').val(),
                endereco: $(this).find('.input-endereco').val(),
                residuos: residuosSelecionados,
                valoresResiduos: valoresResiduos,
                qtdColetado: qtdResiduos,
                pagamento: formaPagamentoSelecionados,
                tipoPagamento: tiposPagamentos,
                valor: valorPagamento,
                coletado: coletado,
                obs: $(this).find('.input-obs').val()
            };

            dadosClientes.push(dadosCliente);
        }

    });


    let accordionAberto = false;
    $('.input-obrigatorio').each(function () {

        if (!$(this).val()) {

            let collapse = $(this).data('collapse');

            // verifica se é select2
            if ($(this).hasClass('select2')) {
                $(this).next().next().removeClass('d-none');
                $(this).next().addClass('select2-obrigatorio');
            } else {
                $(this).next().removeClass('d-none');
                $(this).addClass('invalido');
            }

            // abre o accordion com o input vazio
            if (!accordionAberto) {

                if (!$(`#collapse${collapse}`).hasClass('show')) {

                    $(`.accordion-button-${collapse}`).trigger('click');
                }
                accordionAberto = true;
            }


            permissao = false;

        } else {

            // verifica se é select2
            if ($(this).hasClass('select2')) {
                $(this).next().next().addClass('d-none');
                $(this).next().removeClass('select2-obrigatorio');
            } else {
                $(this).removeClass('invalido');
                $(this).next().addClass('d-none');

            }
        }

    })

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
                verificaAgendamentosFuturos: true,
                valorTotal: valorTotal

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
                        } else {
                            avisoRetorno(`Sucesso!`, `O romaneio foi concluído com sucesso sem remover os agendamentos`, `success`, `${baseUrl}romaneios`);
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
$(function () {

    $('.select2').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
    });
})


$(document).on('change', '.select-residuo', function () {

    let inputResiduo = $(this).closest('.div-residuo').nextAll('.div-residuo').find('.input-valor-residuo');
    inputResiduo.addClass('input-obrigatorio');

    let idCliente = inputResiduo.data('id-cliente');

    $.ajax({
        type: 'post',
        url: `${baseUrl}residuoCliente/recebeValorResiduoCliente`,
        data: {
            idResiduo: $(this).val(),
            idCliente: idCliente
        }, success: function (data) {

            if (data && data.valor !== null) {

                inputResiduo.val(data.valor);
            } else {
                inputResiduo.val(0);

            }
        }
    })


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

    let idSetorEmpresa = $('.input-id-setor-empresa').val();

    recebeClientesSetor(idSetorEmpresa);

    $('.select2-edita').select2({
        dropdownParent: "#modalEditarRomaneio",
        theme: 'bootstrap-5'
    });
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
                            <i class="fas fa-check-circle ${romaneio.status == 1 ? (romaneio.prestar_conta == 0 ? 'text-warning' : 'text-success') : ''}"></i>
                        </td>

                        
                        <td>
                            <div class="font-sans-serif btn-reveal-trigger position-static">
                                <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--2"></span></button>
                                <div class="dropdown-menu dropdown-menu-end py-2">
            
                                    <a target="_blank" class="dropdown-item" href="${baseUrl}romaneios/gerarromaneiopdf/${romaneio.codigo}" title="Gerar Romaneio">
                                        <span class="fas fa-download ms-1"></span> Gerar
                                    </a>

                                    ${romaneio.status == 0 ? `
                                        <a class="dropdown-item" href="#" title="Concluir Romaneio" onclick="verificaPrestacaoContasFuncionario('${romaneio.codigo}', ${romaneio.ID_RESPONSAVEL}, '${romaneio.data_romaneio}', ${romaneio.id_setor_empresa})">
                                            <span class="ms-1 fas fa-check-circle"></span> Concluir
                                        </a>
                                    ` : ''}

                                    ${romaneio.status == 1 ? `
                                        <a class="dropdown-item" href="${baseUrl}romaneios/detalhes/${romaneio.codigo}" title="Visualizar Romaneio">
                                            <span class="ms-1 fas fa-eye"></span> Visualizar
                                        </a>
                                    ` : ''}

                                    ${romaneio.status == 1 && romaneio.prestar_conta == 1 ? `
                                        <a onclick="visualizarPrestacaoContas(${romaneio.codigo})" class="dropdown-item" href="#" title="Visualizar Custos" data-bs-toggle="modal" data-bs-target="#modalVisualizarCustosRomaneio">
                                            <span class="ms-1 fas fa-coins"></span> Ver custos
                                        </a>    
                                    ` : ''}

                                    ${romaneio.status == 0 ? `
                                        <a class="dropdown-item" href="#" title="Editar Romaneio" onclick='editarRomaneio(${romaneio.codigo}, ${romaneio.ID_RESPONSAVEL}, "${romaneio.data_romaneio}", ${romaneio.id_setor_empresa})'>
                                            <span class="ms-1 fas fa-pencil"></span> Editar
                                        </a>
                                    ` : ''}

                                    ${romaneio.status == 0 ? `
                                        <a class="dropdown-item" href="#" title="Deletar Romaneio" onclick='deletarRomaneio(${romaneio.ID_ROMANEIO})'>
                                            <span class="fas fa-trash ms-1"></span> Deletar
                                        </a>
                                    ` : ''}

                                    ${romaneio.status == 0 ? `
                                        <div class="dropdown-divider btn-realizar-pagamento-1"></div>
                                        <a data-data-romaneio="${romaneio.data_romaneio}" data-funcionario="${romaneio.RESPONSAVEL}" data-codigo="${romaneio.codigo}" data-saldo="${romaneio.saldo}" data-id-funcionario="${romaneio.ID_RESPONSAVEL}" data-id-setor-empresa="${romaneio.id_setor_empresa}" class="dropdown-item btn-add-verba-romaneio" href="#" title="Adicionar verba para o responsável" data-bs-toggle="modal" data-bs-target="#modalAdicinarVerbaRomaneio">
                                            <span class="fas fa-coins ms-1"></span> Adicionar verba
                                        </a>
                                    ` : ''}

                                    ${romaneio.prestar_conta == 0 && romaneio.status == 1 ? `
                                        <div class="dropdown-divider btn-realizar-pagamento-1"></div>

                                        <a class="dropdown-item btn-prestar-contas" data-bs-toggle="modal" data-bs-target="#modalPrestarConta" href="#" title="Prestar Contas" data-funcionario="${romaneio.RESPONSAVEL}" data-codigo="${romaneio.codigo}" data-saldo="${romaneio.saldo}" data-id-funcionario="${romaneio.ID_RESPONSAVEL}" data-id-setor-empresa="${romaneio.id_setor_empresa}">
                                            <span class="uil-file-check-alt ms-1"></span> Prestar Contas
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

$(document).on('click', '.btn-add-verba-romaneio', function () {

    carregaSelect2('select2', 'modalAdicinarVerbaRomaneio');

    let saldoResponsavel = $(this).data('saldo');
    let nomeResponsavel = $(this).data('funcionario');
    $('.codigo-romaneio').val($(this).data('codigo'));
    $('.id-setor-empresa').val($(this).data('id-setor-empresa'));
    $('.id-responsavel').val($(this).data('id-funcionario'));
    $('.data-romaneio').val($(this).data('data-romaneio'))

    $('.nome-funcionario').html(nomeResponsavel);
    $('.saldo-verba-funcionario').html(formatarValorMoeda(saldoResponsavel));

})

const salvarVerbasAdicionaisRomaneio = () => {

    let codRomaneio = $('.codigo-romaneio').val();
    let setorEmpresa = $('.id-setor-empresa').val();
    let dataRomaneio = $('.data-romaneio').val();
    let permissao = true;

    let dadosFormulario = {};
    if (permissao) {

        $(`.form-verba-adicional-responsavel-coleta`).find("select, input").each(function () {

            let inputName = $(this).attr('name');
            let inputValue = $(this).val();

            if (!dadosFormulario[inputName]) {
                dadosFormulario[inputName] = [];
            }

            // Adiciona o valor ao array
            dadosFormulario[inputName].push(inputValue);

            if (!$('.check-sem-verba').is(':checked')) {
                permissao = verificaCamposObrigatorios('input-obrigatorio-verba');
            }

        });

        let responsavel = $('.id-responsavel').val();

        if (permissao) {

            $.ajax({
                type: 'post',
                url: `${baseUrl}finFluxoCaixa/insereMovimentacaoRomaneioFluxo`,
                data: {
                    dadosFluxo: dadosFormulario,
                    responsavel: responsavel,
                    codRomaneio: codRomaneio,
                    setorEmpresa: setorEmpresa,
                    dataRomaneio: dataRomaneio

                }, beforeSend: function () {

                    $('.load-form-pagamento').removeClass('d-none');
                    $('.btn-salva-verba-responsavel').addClass('d-none');

                }, success: function (data) {

                    $('.load-form-pagamento').addClass('d-none');
                    $('.btn-salva-verba-responsavel').removeClass('d-none');

                    avisoRetorno('Sucesso!', 'Verbas adicionadas com sucesso!', 'success', `${baseUrl}romaneios`)
                }
            })
        }


    }

}

$(document).on('change', '.select-macros', function () {

    let idMacro = $(this).val();

    $.ajax({
        type: "post",
        url: `${baseUrl}finMicro/recebeMicrosMacro`,
        data: {
            idMacro: idMacro
        }, beforeSend: function () {
            $('.select-micros').html('<option disabled>Selecione</option>');
        }, success: function (data) {

            $('.select-micros').attr('disabled', false);

            let options = '<option value="" disabled >Selecione</option>';

            for (i = 0; i < data.microsMacro.length; i++) {

                options += `<option value="${data.microsMacro[i].id}">${data.microsMacro[i].nome}</option>`;
            }

            $('.select-micros').html(options);

            $('.select-micros').val('').trigger('change');

        }
    })
})


$(document).on('change', '.select-grupo-recebidos', function () {

    let grupo = $(this).val();

    if (grupo == "clientes") {

        $.ajax({
            type: "post",
            url: `${baseUrl}finContasPagar/recebeTodosClientesAll`
            , beforeSend: function () {
                $('.select-recebido').attr('disabled', true);
                $('.select-recebido').html('<option disabled>Carregando...</option>');
            }, success: function (data) {
                $('.select-recebido').attr('disabled', false);

                let options = '<option disabled="disabled" value="">Selecione</option>';
                for (let i = 0; i < data.clientes.length; i++) {
                    options += `<option value="${data.clientes[i].id}">${data.clientes[i].nome}</option>`;
                }
                $('.select-recebido').html(options);

                $('.select-recebido').val('').trigger('change');

            }
        })
    } else {

        $.ajax({
            type: "post",
            url: `${baseUrl}finDadosFinanceiros/recebeDadosFinanceiros`,
            data: {
                grupo: grupo
            },
            beforeSend: function () {
                $('.select-recebido').attr('disabled');
                $('.select-recebido').html('<option value="">Carregando...</option>');
            }, success: function (data) {

                $('.select-recebido').attr('disabled', false);
                $('.select-recebido').html('<option value="">Selecione</option>');

                for (i = 0; i < data.dadosFinanceiro.length; i++) {

                    $('.select-recebido').append(`<option value="${data.dadosFinanceiro[i].id}">${data.dadosFinanceiro[i].nome}</option>`);
                }
            }
        })

    }

})



$(document).on('change', '.checkbox-funcionario', function () {

    let divPagamento = $(this).closest('.col-md-12').prevAll('.div-pagamento');

    let tipoPagamento = divPagamento.find('.select-tipo-pagamento option:selected').val();

    if (tipoPagamento == 0 && tipoPagamento != '' && !$(this).is(':checked')) {

        divPagamento.closest('.div-conta-bancaria').removeClass('d-none');

        let selectContaBancaria = divPagamento.closest('.div-conta-bancaria').find('select');

        $.ajax({
            type: "post",
            url: `${baseUrl}finContaBancaria/recebeContasBancarias`,
            success: function (data) {

                let optionsContasBancarias = "<option selected disabled value=''>Selecione</option>";

                for (i = 0; i < data.length; i++) {

                    optionsContasBancarias += `<option value="${data[i].id_conta_bancaria}">${data[i].apelido}</option>`;
                }

                selectContaBancaria.html(optionsContasBancarias);
            }
        })

        let selectFormaPagamento = divPagamento.closest('.div-select-forma-pagamento').find('select');

        $.ajax({
            type: "post",
            url: `${baseUrl}finContaBancaria/recebeFormasTransacao`,
            success: function (data) {

                let optionFormaPagamentos = "<option selected disabled value=''>Selecione</option>";

                for (c = 0; c < data.length; c++) {

                    optionFormaPagamentos += `<option data-id-tipo-pagamento="1" value="${data[c].id}">${data[c].nome}</option>`;

                }

                selectFormaPagamento.html(optionFormaPagamentos);
            }
        })


    } else {

        divPagamento.closest('.div-conta-bancaria').find('select').removeClass('input-obrigatorio');

        let selectFormaPagamentoFuncionario = divPagamento.closest('.div-select-forma-pagamento').find('select');

        $.ajax({
            type: "post",
            url: `${baseUrl}formaPagamento/recebeFormasPagamentos`,
            beforeSend: function () {
                selectFormaPagamentoFuncionario.html('');
            },
            success: function (data) {

                let optionFormaPagamentos = "<option selected disabled value=''>Selecione</option>";

                for (f = 0; f < data.length; f++) {

                    optionFormaPagamentos += `<option data-id-tipo-pagamento="${data[f].id_tipo_pagamento}" value="${data[f].id}">${data[f].forma_pagamento}</option>`;

                }

                selectFormaPagamentoFuncionario.html(optionFormaPagamentos);
            }
        })

        divPagamento.closest('.div-conta-bancaria').addClass('d-none');

    }
})


$(document).on('change', '.select-tipo-pagamento', function () {


    let pagoResponsavel = $(this).closest('.div-pagamento').siblings('.div-checkbox').find('.checkbox-funcionario');

    let divResiduo = $(this).closest('.div-pagamento').siblings('.div-residuo');
    divResiduo.find('.select-residuo').addClass('input-obrigatorio');
    divResiduo.find('.input-residuo').addClass('input-obrigatorio');

    let divPagamento = $(this).closest('.div-pagamento').siblings('.div-pagamento');

    // pago no ato mas não foi pago por responsável
    if ($(this).val() == 0 && !pagoResponsavel.is(':checked')) {

        $(this).closest('.div-pagamento').next().removeClass('d-none');

        let divSelectContaBancaria = $(this).closest('.div-pagamento').next();

        $.ajax({
            type: "post",
            url: `${baseUrl}finContaBancaria/recebeContasBancarias`,
            success: function (data) {

                let optionsContasBancarias = "<option selected disabled value=''>Selecione</option>";

                for (i = 0; i < data.length; i++) {

                    optionsContasBancarias += `<option value="${data[i].id_conta_bancaria}">${data[i].apelido}</option>`;
                }

                divSelectContaBancaria.find('select').html(optionsContasBancarias);
            }
        })


    } else if ($(this).val() == 1 && !pagoResponsavel.is(':checked')) {

        $(this).closest('.div-pagamento').next().addClass('d-none'); // esconde os select de contas bancarias

        // tratamento para campos obrigatorios
        divPagamento.find(':input').removeClass('input-obrigatorio');
        divPagamento.find(':input').removeClass('invalido');
        divPagamento.find('.select2').next().removeClass('select2-obrigatorio');



    } else if ($(this).val() == 0 && pagoResponsavel.is(':checked')) {

        divPagamento.find('.select-conta-bancaria').removeClass('input-obrigatorio');

    }


})
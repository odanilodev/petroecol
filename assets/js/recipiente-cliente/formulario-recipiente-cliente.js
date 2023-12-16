var baseUrl = $('.base-url').val();

const cadastraRecipienteCliente = () => {

    let idCliente = $('.id-cliente').val();

    let idRecipiente = $('#select-recipiente').val();

    let quantidade = $('#quantidade-recipiente').val();

    var nomeRecipiente = $('#select-recipiente option:selected').text();


    permissao = true;

    if (!idRecipiente || !quantidade) {

        permissao = false;

    }

    if (permissao) {

        $.ajax({
            type: "POST",
            url: `${baseUrl}recipienteCliente/cadastraRecipienteCliente`,
            data: {
                id_cliente: idCliente,
                id_recipiente: idRecipiente,
                quantidade: quantidade,
                nome_recipiente: nomeRecipiente
            },
            beforeSend: function () {

                $('.load-form').removeClass('d-none');
                $('.btn-form').addClass('d-none');

            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');

                // editar quantidade que já está cadastrado
                if (data.aviso) {

                    $(`.qtd-${data.idRecipiente}`).text(data.quantidade);

                    $('.edita-recipiente').attr('onclick', `verRecipienteCliente('${nomeRecipiente}', '${data.quantidade}')`);
                    return;
                }

                if (data.success) {

                    $('.div-recipientes').append(data.message);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                }

            }, error: function (xhr, status, error) {

                $('.load-form').addClass('d-none');
                $('.btn-form').removeClass('d-none');
                if (xhr.status === 403) {
                    avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação..`, 'error', '#');
                }
            }
        })
    }

}

$('#select-recipiente').change(function () {

    let idRecipiente = $(this).val();

    let quantidadeRecipiente = $(`.qtd-${idRecipiente}`).text();

    $('#quantidade-recipiente').val(quantidadeRecipiente);
})

$(document).ready(function () {
    $('#single-select-field').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
    });
})

const exibirRecipientesCliente = (idCliente) => {

    $('#select-recipiente').select2({
        dropdownParent: "#modalRecipiente",
        theme: 'bootstrap-5' // Aplicar o tema Bootstrap 4
    });

    $('#select-recipiente').val('');

    $('#quantidade-recipiente').val('');

    $('.id-cliente').val(idCliente);

    $.ajax({
        type: "POST",
        url: `${baseUrl}recipienteCliente/recebeRecipienteCliente`,
        data: {
            id_cliente: idCliente
        },
        beforeSend: function () {
            $('.div-recipientes').html('');
        },
        success: function (data) {

            if (data) {

                $('.div-recipientes').html(data);

            }
        }
    })
}


const deletaRecipienteCliente = (idRecipienteCliente) => {

    $.ajax({
        type: "POST",
        url: `${baseUrl}recipienteCliente/deletaRecipienteCliente`,
        data: {
            id: idRecipienteCliente
        },
        success: function (data) {

            $(`.recipiente-${idRecipienteCliente}`).remove();
        }
    })

}


const verRecipienteCliente = (textoRecipiente, quantidadeRecipiente) => {

    var selectRecipiente = $('#select-recipiente');

    var textoRecipienteLower = textoRecipiente.toUpperCase(); // Converte o texto fornecido para minúsculas

    var optionToSelect = selectRecipiente.find('option').filter(function () {
        return $(this).text().toUpperCase() == textoRecipienteLower;
    });

    optionToSelect.prop('selected', true);

    $('#quantidade-recipiente').val(quantidadeRecipiente);

    $('#select-recipiente').select2({
        dropdownParent: "#modalRecipiente",
        theme: 'bootstrap-5' // Aplicar o tema Bootstrap 4
    });

}

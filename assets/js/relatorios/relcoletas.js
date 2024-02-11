var baseUrl = $('.base-url').val();

// limpa os select para usar clientes ou grupos
$(document).on('click', 'textarea', function () {
    let select = $(this).attr('placeholder');

    if (select == 'Grupos') {
        $('#select-clientes').val('').trigger('change');
    }

    if (select == 'Clientes') {
        $('#select-grupos').val('').trigger('change');
    }

});

const relatorioColetas = () => {

    var permissao = true;

    // verificar campos cliente e grupos
    let grupos = $('#select-grupos').val();
    let clientes = $('#select-clientes').val();
    if (grupos.length === 0 && clientes.length === 0) {
        avisoRetorno('Algo deu errado!', 'Preencha o campo grupos ou clientes!', 'error', '#');
        permissao = false;
        return;
    }

    // verifica se datas estão preenchidas
    let data_inicio = $('.input-data-inicio').val();
    let data_fim = $('.input-data-fim').val();
    if (!data_inicio || !data_fim) {
        avisoRetorno('Algo deu errado!', 'Preencha as datas corretamente!', 'error', '#');
        permissao = false;
        return;
    }

    if (permissao) {

        var form = $('<form>', {
            'action': `${baseUrl}relatorios/gerarRelatorioColetas`,
            'method': 'post',
            'style': 'display: none;',
            'target': '_blank'
        });

        form.append($('<input>', {
            'type': 'hidden',
            'name': 'grupos',
            'value': grupos
        }));

        form.append($('<input>', {
            'type': 'hidden',
            'name': 'clientes',
            'value': clientes
        }));

        form.append($('<input>', {
            'type': 'hidden',
            'name': 'data_inicio',
            'value': data_inicio
        }));

        form.append($('<input>', {
            'type': 'hidden',
            'name': 'data_fim',
            'value': data_fim
        }));

        $('body').append(form);

        form.submit();

    } else {
        avisoRetorno('Algo deu errado!', 'Preenche os filtros corretamente!', 'error', '#');
        return;
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


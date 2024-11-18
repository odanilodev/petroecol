let idsElementosSelecionados = [];
let atributosElementosSelecionados = [];
let quantidadeElementosSelecionados = 0;

function selecionarTodosElementos() {

    if ($('.check-todos-elementos').is(':checked')) {

        $('.check-elemento').prop('checked', true); // ativa os checkbox

        $('.check-elemento').each(function () {
            let elementoId = $(this).val();
            if (!idsElementosSelecionados.includes(elementoId)) {
                idsElementosSelecionados.push(elementoId);
                quantidadeElementosSelecionados++;

                let attrData = {}; 
                $.each(this.attributes, function () {
                    if (this.name.startsWith('data-')) {
                        let nomeAtributo = this.name.slice(5).replace(/-([a-z])/g, function (g) { return g[1].toUpperCase(); });
                        attrData[nomeAtributo] = this.value;
                    }
                });

                atributosElementosSelecionados.push({ id: elementoId, ...attrData }); 
            }
        });

        if (quantidadeElementosSelecionados > 1) {
            $('.btn-acoes-elementos-selecionados').removeClass('d-none');
        }

        $('.contador-elementos-selecionados').html(`(${quantidadeElementosSelecionados})`);
        salvarElementosLocalStorage();

    } else {

        $('.check-elemento').each(function () {
            let elementoId = $(this).val();
            let indexElemento = idsElementosSelecionados.indexOf(elementoId);
            $(this).prop('checked', false);

            if (indexElemento > -1) {
                idsElementosSelecionados.splice(indexElemento, 1);
                atributosElementosSelecionados = atributosElementosSelecionados.filter(attr => attr.id !== elementoId); //remove os atributos pelo id do elemento
                quantidadeElementosSelecionados--;
            }
        });

        $('.contador-elementos-selecionados').html(`(${quantidadeElementosSelecionados})`);
        salvarElementosLocalStorage();

        if (quantidadeElementosSelecionados < 2) {
            $('.btn-acoes-elementos-selecionados').addClass('d-none');
        }
    }
}

$(document).on('click', '.check-elemento', function () {
    let elementoId = $(this).val();
    let indexElemento = idsElementosSelecionados.indexOf(elementoId);

    if (indexElemento > -1) {
        idsElementosSelecionados.splice(indexElemento, 1);
        atributosElementosSelecionados = atributosElementosSelecionados.filter(attr => attr.id !== elementoId);
        quantidadeElementosSelecionados--;
    } else {
        idsElementosSelecionados.push(elementoId);
        quantidadeElementosSelecionados++;

        let attrData = { id: elementoId };
        $.each(this.attributes, function () {
            if (this.name.startsWith('data-')) {
                let nomeAtributo = this.name.slice(5).replace(/-([a-z])/g, function (g) { return g[1].toUpperCase(); });
                attrData[nomeAtributo] = this.value;
            }
        });

        atributosElementosSelecionados.push(attrData);
    }

    if (quantidadeElementosSelecionados > 1) {
        $('.btn-acoes-elementos-selecionados').removeClass('d-none');
    } else {
        $('.btn-acoes-elementos-selecionados').addClass('d-none');
    }

    $('.contador-elementos-selecionados').html(`(${quantidadeElementosSelecionados})`);
    salvarElementosLocalStorage();
});


function carregaElementosLocalStorage() {

    let elementosSalvos = JSON.parse(localStorage.getItem('idsElementosSelecionados')) || [];
    idsElementosSelecionados = elementosSalvos;
    quantidadeElementosSelecionados = elementosSalvos.length;
    atributosElementosSelecionados = JSON.parse(localStorage.getItem('atributosElementosSelecionados')) || [];

    $.each(elementosSalvos, function (index, id) {
        if (quantidadeElementosSelecionados > 1) {
            $(`.check-${id}`).prop('checked', true);
            $('.contador-elementos-selecionados').html(`(${quantidadeElementosSelecionados})`);
            $('.btn-acoes-elementos-selecionados').removeClass('d-none');
        }
    });

}

function salvarElementosLocalStorage() {
    localStorage.setItem('idsElementosSelecionados', JSON.stringify(idsElementosSelecionados));
    localStorage.setItem('atributosElementosSelecionados', JSON.stringify(atributosElementosSelecionados));
}

$(function () {

    let urlAtual = window.location.href;

    if (urlAtual.includes('all')) {

        localStorage.removeItem('idsElementosSelecionados');
        localStorage.removeItem('atributosElementosSelecionados');
    } else {

        carregaElementosLocalStorage();
    }
});

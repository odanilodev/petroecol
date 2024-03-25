// Duplica formas de pagamento
function duplicarFormasPagamento() {
	// Clone o último grupo de campos dentro de .teste
	let clone = $(".campos-pagamento .duplica-pagamento").clone();

	// Limpe os valores dos campos clonados
	clone.find("select").val("");
	clone.find("label").remove();

	let btnRemove = `
        <div class="col-md-1 mt-0">            
            <button type="button" class="btn btn-sm btn-danger deleta-dicionario" >
                <span class="fas fa-minus"></span>
            </button>
        </div>
    `;
    //por padrão row vem com margin e padding - classes retiram
    let novaLinha = $('<div class="row m-0 p-0"></div>');

    // imprime os elementos dentro da div row
    novaLinha.append(clone);
    novaLinha.append(btnRemove);

    $(novaLinha).find(`.deleta-dicionario`).on('click', function () {

        novaLinha.remove();
    });

    $(".campos-duplicados").append(novaLinha);

}
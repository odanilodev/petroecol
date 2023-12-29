var baseUrl = $(".base-url").val();

const cadastraDicionarioGlobal = () => {

	let id = $(".input-id").val();

	let dadosDicionario = $("#form-dicionario").serialize();

	let permissao = true;

	$("#form-dicionario input").each(function () {
		// Verifica se o valor do input atual está vazio
		if ($(this).val().trim() === "") {

            $(this).addClass('invalido');
            $(this).next().removeClass('d-none');

			permissao = false;
		} else {

            $(this).removeClass('invalido');
            $(this).next().addClass('d-none');
        }
	});

	if (permissao) {
		$.ajax({
			type: "post",
			url: `${baseUrl}dicionario/cadastraDicionarioGlobal`,
			data: {
				id: id,
				dadosDicionario: dadosDicionario,
			},
			beforeSend: function () {
				$(".load-form").removeClass("d-none");
				$(".btn-envia").addClass("d-none");
			},
			success: function (data) {
				$(".load-form").addClass("d-none");
				$(".btn-envia").removeClass("d-none");

				if (data.success) {
					avisoRetorno(
						"Sucesso!",
						`${data.message}`,
						"success",
						`${baseUrl}dicionario/chavesGlobais/all`
					);
				} else {
					avisoRetorno("Algo deu errado!", `${data.message}`, "error", "#");
				}
			},
			error: function (xhr, status, error) {
				$(".load-form").addClass("d-none");
				$(".btn-envia").removeClass("d-none");
				if (xhr.status === 403) {
					avisoRetorno(
						"Algo deu errado!",
						`Você não tem permissão para esta ação..`,
						"error",
						"#"
					);
				}
			},
		});
	}
};

const deletarDicionarioGlobal = (id) => {
	Swal.fire({
		title: "Você tem certeza?",
		text: "Esta ação não poderá ser revertida",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		cancelButtonText: "Cancelar",
		confirmButtonText: "Sim, deletar",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				type: "post",
				url: `${baseUrl}dicionario/deletaDicionarioGlobal`,
				data: {
					id: id,
				},
				success: function () {
					avisoRetorno(
						"Sucesso!",
						"Chave deletada com sucesso!",
						"success",
						`${baseUrl}dicionario/chavesGlobais/all`
					);
				},
			});
		}
	});
};

function duplicarDicionario() {
	// Clone o último grupo de campos dentro de .teste
	let clone = $(".campos-dicionario .duplica-dicionario").clone();

	// Limpe os valores dos campos clonados
	clone.find("input").val("");

	let btnRemove = `
        <div class="col-md-2 mt-4">            
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

const editarDicionarioGlobal = (id) => {

	$.ajax({
		type: "POST",
		url: `${baseUrl}dicionario/recebeIdDicionarioGlobal`,
		data: {
			id: id,
		},
		success: function (data) {

			$(".input-chave").val(data["dicionario"].chave);
			$(".input-valor-ptbr").val(data["dicionario"].valor_ptbr);
			$(".input-valor-en").val(data["dicionario"].valor_en);
			$(".input-id").val(id);
		},
	});
};

var baseUrl = $(".base-url").val();

const cadastraDicionarioGlobal = () => {
	let id = $(".input-id").val();
	let chave = $(".input-chave").val();
	let valor_ptbr = $(".input-valor-ptbr").val();
	let valor_en = $(".input-valor-en").val();

	let permissao = false;

	// cadastra um dicionario nova
	if (chave != "" && valor_ptbr != "" && valor_en != "") {
		permissao = true;
	}

	if (permissao) {
		$.ajax({
			type: "post",
			url: `${baseUrl}dicionario/cadastraDicionarioGlobal`,
			data: {
				id: id,
				chave: chave,
				valor_ptbr: valor_ptbr,
				valor_en: valor_en,
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
						`${baseUrl}dicionario/chavesGlobais`
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
						"Dicionario deletado com sucesso!",
						"success",
						`${baseUrl}dicionario/chavesGlobais`
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
    clone.find('input').val('');

    // Adicione o grupo clonado a .teste2
    $(".campos-duplicados").append(clone);
}

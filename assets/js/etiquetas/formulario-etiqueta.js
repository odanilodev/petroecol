var baseUrl = $(".base-url").val();

const cadastraEtiqueta = () => {
	let nome = $(".input-nome").val();
	let id = $(".input-id").val();
	let permissao = false;

	// cadastra uma etiqueta nova
	if (nome != "") {
		permissao = true;
	} else {
		permissao = false;
	}

	if (permissao) {
		$.ajax({
			type: "post",
			url: `${baseUrl}etiquetas/cadastraEtiqueta`,
			data: {
				nome: nome,
				id: id,
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
						`${baseUrl}etiquetas`
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

const deletarEtiqueta = (id) => {
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
				url: `${baseUrl}etiquetas/deletaEtiqueta`,
				data: {
					id: id,
				},
				success: function () {
					avisoRetorno(
						"Sucesso!",
						"Etiqueta deletada com sucesso!",
						"success",
						`${baseUrl}etiquetas`
					);
				},
			});
		}
	});
};

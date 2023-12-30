var baseUrl = $(".base-url").val();

const cadastraFormaPagamento = () => {
	let formaPagamento = $(".input-nome").val();

	let id = $(".input-id").val();
	let permissao = true;

	if (permissao) {
		$.ajax({
			type: "post",
			url: `${baseUrl}formaPagamento/cadastraFormaPagamento`,
			data: {
				formaPagamento: formaPagamento,
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
						`${baseUrl}formaPagamento`
					);
				} else {
					avisoRetorno("Algo deu errado!", `${data.message}`, "error", "#");
				}
			},
		});
	}
};

const deletaFormaPagamento = (id) => {

	$.ajax({
		type: "post",
		url: `${baseUrl}formaPagamento/verificaFormaPagamentoCliente`,
		data: {
			id: id,
		},
		success: function (data) {

            let txtMsg = data.message ?? 'Esta ação não poderá ser revertida';

			Swal.fire({
				title: "Você tem certeza?",
				text: txtMsg,
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				cancelButtonText: "Cancelar",
				confirmButtonText: "Sim, deletar"
                
			}).then((result) => {

				if (result.isConfirmed) {
					$.ajax({
						type: "post",
						url: `${baseUrl}formaPagamento/deletaFormaPagamento`,
						data: {
							id: id,
						},
						success: function (data) {

							let redirect = data.type != 'error' ? `${baseUrl}formaPagamento` : '#';

							avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

					},
					});
				}
			});
		},
	});
};

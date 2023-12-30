var baseUrl = $(".base-url").val();

const cadastraNovoVeiculo = () => {
	let modeloInput = $(".input-modelo").val();
	let placaInput = $(".input-placa").val();
	let id = $(".input-id").val();
	let documentoInput = $("#documentoInput")[0].files[0];
	let fotoCarro = $("#fotoCarro")[0].files[0];
	let formData = new FormData();

	formData.append("documento", documentoInput);
	formData.append("modelo", modeloInput);
	formData.append("placa", placaInput);
	formData.append("fotoCarro", fotoCarro);
	formData.append("id", id);
    //Verificação de campo vazio e permissao para cadastrar
    let permissao = true

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


	if (permissao) {
		$.ajax({
			type: "post",
			url: `${baseUrl}veiculos/cadastraVeiculo`,
			contentType: false,
			processData: false,
			data: formData,
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
						`${baseUrl}veiculos`
					);
				} else {
					avisoRetorno("Algo deu errado!", `${data.message}`, "error", "#");
				}
			},
		});
	}
};

const deletaVeiculo = (id) => {
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
				url: `${baseUrl}veiculos/deletaVeiculo`,
				data: {
					id: id,
				},
				success: function () {
					avisoRetorno(
						"Sucesso!",
						"Veículo deletado com sucesso!",
						"success",
						`${baseUrl}veiculos`
					);
				},
			});
		}
	});
};

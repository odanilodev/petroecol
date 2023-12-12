var baseUrl = $(".base-url").val();

const cadastraNovoVeiculo = () => {
	let modeloInput = $(".input-modelo").val();
	let placaInput = $(".input-placa").val();
	let id = $(".input-id").val();

	let permissao = true;

	// cadastra um veículo novo

	let documentoInput = $("#documentoInput")[0].files[0];
	let fotoCarro = $("#fotoCarro")[0].files[0];
	let formData = new FormData();
	formData.append("documento", documentoInput);
	formData.append("modelo", modeloInput);
	formData.append("placa", placaInput);
	formData.append("fotoCarro", fotoCarro);
	formData.append("id", id);

	$('.input-obrigatorio').each(function(){
		if($(this).val() == "" || $(this).val() == null) {
				$(this).addClass('invalido')
				permissao = false;
		}else{
				$(this).removeClass('invalido')
		}
})

	if (camposVazios.length) {

			permissao = false;

	}

	if (permissao) {
			cadastraCliente(dadosEmpresa, dadosEndereco, dadosResponsavel);
	}

	if (permissao) {
		$.ajax({
			type: "post",
			url: `${baseUrl}cadastroveiculos/cadastraVeiculo`,
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
						`${baseUrl}cadastroveiculos`
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
				url: `${baseUrl}cadastroveiculos/deletaVeiculo`,
				data: {
					id: id,
				},
				success: function () {
					avisoRetorno(
						"Sucesso!",
						"Veículo deletado com sucesso!",
						"success",
						`${baseUrl}cadastroveiculos`
					);
				},
			});
		}
	});
};

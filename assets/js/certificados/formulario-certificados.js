var baseUrl = $(".base-url").val();

const cadastraCertificado = () => {

	let id = $(".input-id").val();
	let modeloCertificado = $(".input-modelo").val();
	let tituloCertificado = $(".input-titulo").val();
	let descricaoCertificado = $(".input-descricao").val();
	let declaracaoCertificado = $(".input-declaracao").val();
	let orientacaoCertificado = $(".select-orientacao").val();
	let logo = $('.input-logo')[0].files[0];
	let carimbo = $('.input-carimbo')[0].files[0];
	let assinatura = $('.input-assinatura')[0].files[0];
	let marcaAgua = $('.input-marca-agua')[0].files[0];


	let formData = new FormData();
    formData.append('id', id);
    formData.append('modeloCertificado', modeloCertificado);
    formData.append('tituloCertificado', tituloCertificado);
    formData.append('descricaoCertificado', descricaoCertificado);
    formData.append('declaracaoCertificado', declaracaoCertificado);
    formData.append('orientacaoCertificado', orientacaoCertificado);
    formData.append('logo', logo);
    formData.append('carimbo', carimbo);
    formData.append('assinatura', assinatura);
    formData.append('marca_agua', marcaAgua);


	let permissao = true;

	$('.input-obrigatorio').each(function () {

		if (!$(this).val()) {

			$(this).addClass('invalido');
			$(this).next().removeClass('d-none');
			permissao = false;

		} else {

			$(this).removeClass('invalido');
			$(this).next().addClass('d-none');

		}

	})

	if (permissao) {
		$.ajax({
			type: "post",
			url: `${baseUrl}certificados/cadastraCertificado`,
			data: formData,
            contentType: false,
            processData: false,
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
						`${baseUrl}certificados`
					);
				} else {
					avisoRetorno("Algo deu errado!", `Não foi possível completar esta ação`, "error", "#");
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

const deletaCertificado = (id) => {
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
				url: `${baseUrl}certificados/deletaCertificado`,
				data: {
					id: id,
				},
				success: function () {
					avisoRetorno(
						"Sucesso!",
						"Certificado deletado com sucesso!",
						"success",
						`${baseUrl}certificados`
					);
				},
			});
		}
	});
};

var baseUrl = $(".base-url").val();

const cadastraMicro = (input) => {

	let idMacro = $(".input-id").val();
	let idMicro = $(".input-id-micro").val();
	let nomeMicro = $(".input-nome-micro").val();
	let nomeMicroModal = $(".input-nome-micro-modal").val();

	let permissao = true;

	if (!$(input).val()) {
		$(input).addClass('invalido');
		$(input).next().removeClass('d-none');
		permissao = false;
	} else {
		$(input).removeClass('invalido');
		$(input).next().addClass('d-none');
	}


	if (permissao) {
		$.ajax({
			type: "post",
			url: `${baseUrl}finMicro/cadastraMicro`,
			data: {
				idMacro: idMacro,
				idMicro: idMicro,
				nomeMicro: nomeMicro,
				nomeMicroModal: nomeMicroModal
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
						`${baseUrl}finMicro/formulario/${idMacro}`
					);
				} else {
					avisoRetorno("Algo deu errado!", `${data.message}`, "error", "#");
				}
			},
		});
	}
};

const deletaMicro = (idMicro, idMacro) => {

	let idsAgrupados = agruparIdsCheckbox();

	if (idsAgrupados.length >= 2) {
		var idMicros = idsAgrupados;
	} else {
		var idMicros = [idMicro];
	}

	idMacro = $('.input-id').val();

	Swal.fire({
		title: 'Você tem certeza?',
		text: "Esta ação não poderá ser revertida",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Sim, deletar'

	}).then((result) => {

		if (result.isConfirmed) {

			$.ajax({
				type: 'post',
				url: `${baseUrl}finMicro/deletaMicro`,
				data: {
					idMicro: idMicros,
					idMacro: idMacro
				}, success: function (data) {

					let redirect = data.type != 'error' ? `${baseUrl}finMicro/formulario/${idMacro}` : '#';

					avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

				}
			})

		}
	})


}

const editarMicro = (idMicro) => {

	$.ajax({
		type: "POST",
		url: `${baseUrl}finMicro/recebeIdMicro`,
		data: {
			idMicro: idMicro,
		},
		success: function (data) {

			$(".input-nome-micro-modal").val(data["micro"].nome);
			$(".input-id-micro").val(idMicro);
		},
	});
};
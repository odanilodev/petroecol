var baseUrl = $(".base-url").val();

const cadastraCertificado = () => {

	let id = $(".input-id").val();
  let modeloCertificado = $(".input-modelo").val();
  
  let permissao = true;

  $('.input-obrigatorio').each(function() {

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
			data: {
				modeloCertificado: modeloCertificado,
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
						`${baseUrl}certificados`
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
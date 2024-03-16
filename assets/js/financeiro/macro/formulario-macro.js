var baseUrl = $(".base-url").val(); 

const cadastraMacro = () => {
  
	let id = $(".input-id").val(); 

	let nomeMacro = $(".input-nome-macro").val();

    //Verificação de campo vazio e permissao para cadastrar
    let permissao = true

	$(".input-obrigatorio").each(function () {
		// Verifica se o valor do input atual está vazio

		if ($(this).val() == "" || $(this).val() == null) {

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
			url: `${baseUrl}finMacro/cadastraMacro`,
			data: {
				id: id,
				nomeMacro: nomeMacro
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
						`${baseUrl}finMacro`
					);
				} else {
					avisoRetorno("Algo deu errado!", `${data.message}`, "error", "#");
				}
			},
		});
	}
};

const deletaMacro = (id) => {

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
							url: `${baseUrl}finMacro/deletaMacro`,
							data: {
									id: id
							}, success: function (data) {

									let redirect = data.type != 'error' ? `${baseUrl}finMacro` : '#';

									avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

							}
					})

			}
	})


}

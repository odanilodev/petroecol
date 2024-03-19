var baseUrl = $(".base-url").val(); 

const cadastraContaBancaria = () => {
  
	let id = $(".input-id").val(); 

	let apelido = $(".input-apelido").val();
	let banco = $(".input-banco").val();
	let agencia = $(".input-agencia").val();
	let conta = $(".input-conta").val();

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
			url: `${baseUrl}finContaBancaria/cadastraContaBancaria`,
			data: {
				id: id,
				apelido: apelido,
        banco: banco,
        agencia: agencia,
        conta: conta
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
						`${baseUrl}finContaBancaria`
					);
				} else {
					avisoRetorno("Algo deu errado!", `${data.message}`, "error", "#");
				}
			},
		});
	}
};

const deletaContaBancaria = (id) => {

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
							url: `${baseUrl}finContaBancaria/deletaContaBancaria`,
							data: {
									id: id
							}, success: function (data) {

									let redirect = data.type != 'error' ? `${baseUrl}finContaBancaria` : '#';

									avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

							}
					})

			}
	})


}

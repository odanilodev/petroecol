var baseUrl = $(".base-url").val(); 

const cadastraTarifaBancaria = () => {
  
	let id = $(".input-id").val(); 

	let nomeTarifa = $(".input-nome-tarifa").val();
	let idContaBancaria = $(".input-conta-bancaria").val();
	let idFormaTransacao = $(".input-forma-transacao").val();
	let tipoTarifa = $(".input-tipo-tarifa").val();
	let valorMinimoTarifa = $(".input-valor-minimo-tarifa").val();
	let valorTarifa = $(".input-valor-tarifa").val();

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
			url: `${baseUrl}finTarifasBancarias/cadastraTarifaBancaria`,
			data: {
				id: id,
				nomeTarifa: nomeTarifa,
				idContaBancaria: idContaBancaria,
				idFormaTransacao: idFormaTransacao,
				tipoTarifa: tipoTarifa,
				valorMinimoTarifa: valorMinimoTarifa,
				valorTarifa: valorTarifa
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
						`${baseUrl}finTarifasBancarias`
					);
				} else {
					avisoRetorno("Algo deu errado!", `${data.message}`, "error", "#");
				}
			},
		});
	}
};

const deletaTarifaBancaria = (id) => {

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
							url: `${baseUrl}finTarifasBancarias/deletaTarifaBancaria`,
							data: {
									id: id
							}, success: function (data) {

									let redirect = data.type != 'error' ? `${baseUrl}finTarifasBancarias` : '#';

									avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

							}
					})

			}
	})


}

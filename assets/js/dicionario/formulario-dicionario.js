var baseUrl = $(".base-url").val();

const cadastraDicionarioGlobal = () => {
    let id = $(".input-id").val();

    let dadosDicionario = $("#form-dicionario").serialize();

    let permissao = true;

    // Array para armazenar chaves duplicadas
    let duplicadas = [];

    $("#form-dicionario input[name='chave']").each(function () {
        // Verifica se o valor do input atual está vazio
        if ($(this).val().trim() === "") {
            permissao = false;
            avisoRetorno(
                "Algo deu errado!",
                "Preencha todos os campos!",
                "error",
                "#"
            );
            return false; // Encerra o loop se houver campo vazio
        }

        // Verifica se a chave já existe no array duplicadas
        if (duplicadas.includes($(this).val())) {
            permissao = false;
            avisoRetorno(
                "Algo deu errado!",
                "Chave duplicada encontrada!",
                "error",
                "#"
            );
            return false; // Encerra o loop se houver chave duplicada
        }

        duplicadas.push($(this).val());
    });

    if (permissao) {
        $.ajax({
            type: "post",
            url: `${baseUrl}dicionario/cadastraDicionarioGlobal`,
            data: {
                id: id,
                dadosDicionario: dadosDicionario,
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
                        `${baseUrl}dicionario/chavesGlobais/all`
                    );
                } else {
                    avisoRetorno(
                        "Algo deu errado!",
                        `${data.message}`,
                        "error",
                        "#"
                    );
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

const deletarDicionarioGlobal = (id) => {
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
				url: `${baseUrl}dicionario/deletaDicionarioGlobal`,
				data: {
					id: id,
				},
				success: function () {
					avisoRetorno(
						"Sucesso!",
						"Chave deletada com sucesso!",
						"success",
						`${baseUrl}dicionario/chavesGlobais/all`
					);
				},
			});
		}
	});
};

function duplicarDicionario() {
	// Clone o último grupo de campos dentro de .teste
	let clone = $(".campos-dicionario .duplica-dicionario").clone();

	// Limpe os valores dos campos clonados
	clone.find("input").val("");

	// Adicione o grupo clonado a .teste2
	$(".campos-duplicados").append(clone);
}

const editarDicionarioGlobal = (id) => {
	$.ajax({
		type: "POST",
		url: `${baseUrl}dicionario/recebeIdDicionarioGlobal`,
		data: {
			id: id,
		},
		success: function (data) {
			$(".input-chave").val(data["dicionario"].chave);
			$(".input-valor-ptbr").val(data["dicionario"].valor_ptbr);
			$(".input-valor-en").val(data["dicionario"].valor_en);
			$(".input-id").val(id);
		},
	});
};

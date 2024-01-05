var baseUrl = $('.base-url').val();

const atualizaPermissoesComponente = (id) => {

    var permissoesSelecionadas = $('input[name="permissao"]:checked').map(function () {
        return this.value;
    }).get();

    $.ajax({
        type: "POST",
        url: `${baseUrl}permissao/atualizaPermissoes`,
        data: { permissoes: permissoesSelecionadas, id_componente: id },
        success: function (data) {

            $('.load-form').addClass('d-none');
            $('.btn-envia').removeClass('d-none');

            if (data.success) {
                avisoRetorno('Sucesso!', 'Permissão atualizada com sucesso!', 'success', `${baseUrl}permissao/permissaoComponentes/${id}`);
            } else {
                avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');
            }

        },
        error: function (error) {
            console.error("Erro ao enviar dados:", error);
        }
    });
}


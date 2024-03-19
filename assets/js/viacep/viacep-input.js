function preencherEnderecoPorCEP(cep, callback) {
    $.ajax({
        url: 'https://viacep.com.br/ws/' + cep + '/json/',
        dataType: 'json',
        success: function (data) {
            if (!data.erro) {
                callback(data);
            } else {
                avisoRetorno('Erro ao buscar CEP', 'Por favor, tente novamente mais tarde', 'error', '');
            }
        },
        error: function (xhr, status, error) {
            console.error(status, error);
        }
    });
}
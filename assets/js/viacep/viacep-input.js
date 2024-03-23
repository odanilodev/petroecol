function preencherEnderecoPorCEP(cep, callback) {
    $.ajax({
        url: 'https://viacep.com.br/ws/' + cep + '/json/',
        dataType: 'json',
        success: function (data) {
            if (!data.erro) {
                callback(data);
            } else {
                callback({
                    'titulo' : 'Erro ao buscar CEP',
                    'mensagem' : 'Por favor, tente novamente mais tarde',
                    'type' : 'error',
                    'erro' : true
                });
            }
        },
        error: function (xhr, status, error) {
            console.error(status, error);
        }
    });
}
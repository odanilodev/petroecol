function preencherEnderecoPorCEP(cepInputSelector, ruaSelector, bairroSelector, cidadeSelector, estadoSelector, avisoRetornoFunction) {
  $(cepInputSelector).on('blur', function () {
      var cep = $(this).val().replace(/\D/g, '');

      if (cep.length !== 8) {
          avisoRetornoFunction('CEP inválido', 'Verifique se digitou corretamente!', 'error', '#');
          return;
      }

      $.ajax({
          url: 'https://viacep.com.br/ws/' + cep + '/json/',
          dataType: 'json',
          success: function (data) {
              if (!data.erro) {
                  $(ruaSelector).val(data.logradouro);
                  $(bairroSelector).val(data.bairro);
                  $(cidadeSelector).val(data.localidade);
                  $(estadoSelector).val(data.uf);
              } else {
                  avisoRetornoFunction('CEP não encontrado', 'Verifique se digitou corretamente', 'error', '#');
              }
          }
      });
  });
}

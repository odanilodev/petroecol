var baseUrl = $('.base-url').val();

const cadastraDadosFinanceiros = () => {

  let id = $('.input-id').val();
  
  let idGrupo = $('.input-id-grupo').val();
  let nome = $('.input-nome').val();
  let nomeContato = $('.input-nome-contato').val();
  let telefone = $('.input-telefone').val();
  let cnpj = $('.input-cnpj').val();
  let cpf = $('.input-cpf').val();
  let estado = $('.input-estado').val();
  let cidade = $('.input-cidade').val();
  let bairro = $('.input-bairro').val();
  let rua = $('.input-rua').val();
  let contaBancaria = $('.input-conta-bancaria').val();
  let razaoSocial = $('.input-razao-social').val();
  let tipoCadastro = $('.input-tipo-cadastro').val();

  //Verificação de campo vazio e permissao para cadastrar
  let permissao = true

  $(".input-obrigatorio").each(function () {
    // Verifica se o valor do input atual está vazio
    if ($(this).val().trim() === "") {

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
      url: `${baseUrl}finDadosFinanceiros/cadastraDadosFinanceiros`,
      data: {
        id: id,
        idGrupo: idGrupo,
        nome: nome,
        razaoSocial: razaoSocial,
        tipoCadastro: tipoCadastro,
        nomeContato: nomeContato,
        cpf: cpf,
        telefone: telefone,
        cnpj: cnpj,
        estado: estado,
        bairro: bairro,
        cidade: cidade,
        rua: rua,
        contaBancaria: contaBancaria
      },
      beforeSend: function () {
        $('.load-form').removeClass('d-none');
        $('.btn-envia').addClass('d-none');
      },
      success: function (data) {

        $('.load-form').addClass('d-none');
        $('.btn-envia').removeClass('d-none');

        if (data.success) {

          avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}finDadosFinanceiros`);

        } else {

          avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

        }
      }
    });
  }
}

const deletaDadosFinanceiros = (id) => {

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
        url: `${baseUrl}finDadosFinanceiros/deletaDadosFinanceiros`,
        data: {
          id: id
        }, success: function (data) {

          let redirect = data.type != 'error' ? `${baseUrl}finDadosFinanceiros` : '#';

          avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

        }
      })

    }
  })


}

$(document).ready(function () {
    
  $('.select-grupo').val('').trigger('change');

  $('.select2').select2({
      theme: "bootstrap-5",
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
  });
})

// preenche todos os campos de endereço depois de digitar o cep
$(document).ready(function () {
  $('.input-cep').on('blur', function () {
      var cep = $(this).val().replace(/\D/g, '');

      if (cep.length >= 1 && cep.length < 8) {
          avisoRetorno('CEP inválido', 'Verifique se digitou corretamente!', 'error', '#');
          return;
      }

      $.ajax({
          url: 'https://viacep.com.br/ws/' + cep + '/json/',
          dataType: 'json',
          success: function (data) {

              if (!data.erro) {
                  $('#rua').val(data.logradouro);
                  $('#bairro').val(data.bairro);
                  $('#cidade').val(data.localidade);
                  $('#estado').val(data.uf);
              } else {
                  avisoRetorno('CEP não encontrado', 'Verifique se digitou corretamente', 'error', '#');
              }
          }
      });
  });
});
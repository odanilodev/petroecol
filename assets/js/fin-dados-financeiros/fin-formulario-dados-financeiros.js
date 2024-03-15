var baseUrl = $('.base-url').val();

const cadastraDadosFinanceiros = () => {

  let id = $('.input-id').val();

  let nome = $('#input-nome').val();
  let idGrupo = $('#input-id-grupo').val();
  let cnpj = $('#input-cnpj').val();
  let razaoSocial = $('#input-razao-social').val();
  let telefone = $('#input-telefone').val();
  let tipoCadastro = $('#input-tipo-cadastro').val();
  let contaBancaria = $('#input-conta-bancaria').val();
  let email = $('#input-email').val();

  let cep = $('#input-cep').val();
  let rua = $('#input-rua').val();
  let numero = $('#input-numero').val();
  let bairro = $('#input-bairro').val();
  let estado = $('#input-estado').val();
  let cidade = $('#input-cidade').val();
  let complemento = $('#input-complemento').val();

  let nomeIntermedio = $('#input-nome-intermedio').val();
  let emailIntermedio = $('#input-email-intermedio').val();
  let cpfIntermedio = $('#input-cpf-intermedio').val();
  let telefoneIntermedio = $('#input-telefone-intermedio').val();

  //Verificação de campo vazio e permissao para cadastrar
  let permissao = true

  $(".input-obrigatorio").each(function () {

    // Verifica se o valor do input atual está vazio
    if (!$(this).val()) {

      $(this).addClass('invalido');

      // verifica se é select2
      if ($(this).next().hasClass('aviso-obrigatorio')) {

        $(this).next().removeClass('d-none');

      } else {
        $(this).next().next().removeClass('d-none');
        $(this).next().addClass('select2-obrigatorio');
      }

      permissao = false;

    } else {

      $(this).removeClass('invalido');

      if ($(this).next().hasClass('aviso-obrigatorio')) {

        $(this).next().addClass('d-none');

      } else {
        $(this).next().next().addClass('d-none');
        $(this).next().removeClass('select2-obrigatorio');

      }
    }
  });


  if (permissao) {

    $.ajax({
      type: "post",
      url: `${baseUrl}finDadosFinanceiros/cadastraDadosFinanceiros`,
      data: {
        id: id,
        nome: nome,
        idGrupo: idGrupo,
        cnpj: cnpj,
        razaoSocial: razaoSocial,
        telefone: telefone,
        tipoCadastro: tipoCadastro,
        contaBancaria: contaBancaria,
        email: email,

        cep: cep,
        rua: rua,
        numero: numero,
        bairro: bairro,
        estado: estado,
        cidade: cidade,
        complemento: complemento,

        nomeIntermedio: nomeIntermedio,
        emailIntermedio: emailIntermedio,
        cpfIntermedio: cpfIntermedio,
        telefoneIntermedio: telefoneIntermedio
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
  
  $('.select2').select2({
    theme: "bootstrap-5",
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    placeholder: $(this).data('placeholder'),
  });
})

// preenche todos os campos de endereço depois de digitar o cep
$(document).ready(function () {
  $('#input-cep').on('blur', function () {
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
          $('#input-rua').val(data.logradouro);
          $('#input-bairro').val(data.bairro);
          $('#input-cidade').val(data.localidade);
          $('#input-estado').val(data.uf);
        } else {
          avisoRetorno('CEP não encontrado', 'Verifique se digitou corretamente', 'error', '#');
        }
      }
    });
  });
});
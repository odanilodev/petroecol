var baseUrl = $('.base-url').val();

$('#input-dia-faturamento').on('input', function () {

  let valor = $(this).val().replace(/\D/g, '');

  valor = Math.min(Math.max(parseInt(valor, 10) || 0, ''), 31);

  $(this).val(valor === 0 ? '' : valor);
});

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
  let dia_faturamento = $('#input-dia-faturamento').val();

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
        dia_faturamento: dia_faturamento,

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

  $('#input-cep').on('blur', function () {
    var cep = $(this).val().replace(/\D/g, '');

    if (cep.length !== 8 && cep.length >= 1) {

      avisoRetorno('CEP inválido', 'Verifique se digitou corretamente!', 'error', '#');
      return;

    } else {
      preencherEnderecoPorCEP(cep, function (retornoViaCep) {

        if (retornoViaCep.erro) {

          avisoRetorno(`${retornoViaCep.titulo}`, `${retornoViaCep.mensagem}`, `${retornoViaCep.type}`, '#');

        }

        $('#input-rua').val(retornoViaCep.logradouro);
        $('#input-bairro').val(retornoViaCep.bairro);
        $('#input-cidade').val(retornoViaCep.localidade);
        $('#input-estado').val(retornoViaCep.uf);
      });
    }
  });
});

const visualizarDadosFinanceiros = (idDadoFinanceiro) => {
  $.ajax({
    type: "post",
    url: `${baseUrl}finDadosFinanceiros/visualizarDadosFinanceiros`,
    data: {
      idDadoFinanceiro: idDadoFinanceiro
    },
    beforeSend: function () {
      $('.html-clean').html('');

      // Reset navbar
      $('.nav-wizard .nav-link').removeClass('active');
      $('.nav-wizard .nav-link').attr('aria-selected', 'false');
      $('.nav-wizard .nav-link:first').addClass('active');
      $('.nav-wizard .nav-link:first').attr('aria-selected', 'true');

      // Reset tab content
      $('.tab-pane').removeClass('active');
      $('.tab-pane:first').addClass('active');
    },
    success: function (data) {
      if (data.success) {
        // Transação
        $('.nome-transacao').html(data['dadoFinanceiro'].nome ? data['dadoFinanceiro'].nome : '<i>Não cadastrado</i>');
        $('.grupo-transacao').html(data['dadoFinanceiro'].NOME_GRUPO ? data['dadoFinanceiro'].NOME_GRUPO : '<i>Não cadastrado</i>');
        $('.cnpj-transacao').html(data['dadoFinanceiro'].cnpj ? data['dadoFinanceiro'].cnpj : '<i>Não cadastrado</i>');
        $('.razao-social-transacao').html(data['dadoFinanceiro'].razao_social ? data['dadoFinanceiro'].razao_social : '<i>Não cadastrado</i>');
        $('.telefone-transacao').html(data['dadoFinanceiro'].telefone ? data['dadoFinanceiro'].telefone : '<i>Não cadastrado</i>');
        $('.conta-bancaria-transacao').html(data['dadoFinanceiro'].conta_bancaria ? data['dadoFinanceiro'].conta_bancaria : '<i>Não cadastrado</i>');

        if (data['dadoFinanceiro'].email) {
          $('.email-transacao').html('<a href="mailto:' + data['dadoFinanceiro'].email.toLowerCase() + '">' + data['dadoFinanceiro'].email.toLowerCase() + '</a>');
        } else {
          $('.email-transacao').html('<i>Não cadastrado</i>');
        }

        // Localização
        $('.cep-localizacao').html(data['dadoFinanceiro'].cep ? data['dadoFinanceiro'].cep : '<i>Não cadastrado</i>');
        $('.rua-localizacao').html(data['dadoFinanceiro'].rua ? data['dadoFinanceiro'].rua : '<i>Não cadastrado</i>');
        $('.numero-localizacao').html(data['dadoFinanceiro'].numero ? data['dadoFinanceiro'].numero : '<i>Não cadastrado</i>');
        $('.bairro-localizacao').html(data['dadoFinanceiro'].bairro ? data['dadoFinanceiro'].bairro : '<i>Não cadastrado</i>');
        $('.cidade-localizacao').html(data['dadoFinanceiro'].cidade ? data['dadoFinanceiro'].cidade : '<i>Não cadastrado</i>');
        $('.estado-localizacao').html(data['dadoFinanceiro'].estado ? data['dadoFinanceiro'].estado.toUpperCase() : '<i>Não cadastrado</i>');
        $('.complemento-localizacao').html(data['dadoFinanceiro'].complemento ? data['dadoFinanceiro'].complemento : '<i>Não cadastrado</i>');

        // Intermédio
        $('.nome-intermedio').html(data['dadoFinanceiro'].nome_intermedio ? data['dadoFinanceiro'].nome_intermedio : '<i>Não cadastrado</i>');
        $('.telefone-intermedio').html(data['dadoFinanceiro'].telefone_intermedio ? data['dadoFinanceiro'].telefone_intermedio : '<i>Não cadastrado</i>');

        if (data['dadoFinanceiro'].email_intermedio) {
          $('.email-intermedio').html('<a href="mailto:' + data['dadoFinanceiro'].email_intermedio.toLowerCase() + '">' + data['dadoFinanceiro'].email_intermedio.toLowerCase() + '</a>');
        } else {
          $('.email-intermedio').html('<i>Não cadastrado</i>');
        }

        $('.cpf-intermedio').html(data['dadoFinanceiro'].cpf_intermedio ? data['dadoFinanceiro'].cpf_intermedio : '<i>Não cadastrado</i>');

      } else {
        avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');
      }
    },
    error: function (xhr, status, error) {
      avisoRetorno('Algo deu errado!', error, 'error', `#`);
    }
  });
}




var baseUrl = $('.base-url').val();

const verificaEmail = () => {

  let email = $('.input-email');

  if(email.val() == '') {

    Swal.fire({
      title: 'Erro',
      text: 'Digite seu email para recuperar a sua senha',
      icon: 'error',
      confirmButtonText: 'Fechar'
    })

    return;
  }

  $.ajax({
    type: "POST",
    url: `${baseUrl}login/recuperaSenha`,
    data: {
      email: email.val()
    },
    beforeSend: function () {
      $('.load-form').removeClass('d-none');
      $('.btn-envia').addClass('d-none');
    },
    success: function (data) {

      $('.load-form').addClass('d-none');
      $('.btn-envia').removeClass('d-none');

      if (data.success) {

        $('.btn-redefine-senha').attr('data-email', email.val());

        $('.div-email').addClass('d-none');
        $('.div-codigo').removeClass('d-none');

      } else {

        avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

      }

    }

  })

}

const verificaCodigo = () => {

  var codigo = "";

  $('.codigo-input').each(function() {

    codigo += $(this).val();

  })

  $.ajax({
    type: "POST",
    url: `${baseUrl}login/verificaCodigo`,
    data: {
      codigo: codigo
    },
    beforeSend: function () {
      $('.load-form').removeClass('d-none');
      $('.btn-envia').addClass('d-none');
    },
    success: function (data) {

      $('.load-form').addClass('d-none');
      $('.btn-envia').removeClass('d-none');

      if (data.success) {

        $('.div-email').addClass('d-none');
        $('.div-codigo').addClass('d-none');
        $('.div-nova-senha').removeClass('d-none');

      } else {

        avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

      }

    }

  })

}

const redefineSenha = () => {

  let novaSenha = $('.nova-senha').val();
  let repeteSenha = $('.repete-senha').val();

  $('.load-form').removeClass('d-none');
  $('.btn-redefine-senha').addClass('d-none');

  let email = $('.btn-redefine-senha').data('email');

  if (novaSenha != repeteSenha) {
    Swal.fire({
      title: 'Erro',
      text: 'As senhas não combinam',
      icon: 'error',
      confirmButtonText: 'Fechar'
    })
  }

  $.ajax({
    type: "POST",
    url: `${baseUrl}login/redefineSenha`,
    data: {
      senha: novaSenha,
      email: email
    },
    beforeSend: function () {
      $('.load-btn').removeClass('d-none');
    },
    success: function (data) {

      $('.load-form').addClass('d-none');
      $('.btn-envia').removeClass('d-none');

      if (data.success) {

        avisoRetorno('Sucesso!', `${data.message}`, 'success', 'index');

      } else {

        avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

      }

    }

  })

}
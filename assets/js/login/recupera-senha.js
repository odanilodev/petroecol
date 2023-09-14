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
      $('.load-btn').removeClass('d-none');
    },
    success: function (data) {

      if (data == "Token enviado com sucesso") {
        $('.btn-redefine-senha').attr('data-email', email.val());
      }
      $('.div-email').addClass('d-none');
      $('.div-codigo').removeClass('d-none');

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
      $('.load-btn').removeClass('d-none');
    },
    success: function () {

      $('.div-email').addClass('d-none');
      $('.div-codigo').addClass('d-none');
      $('.div-nova-senha').removeClass('d-none');
    }

  })

}

const redefineSenha = () => {

  let novaSenha = $('.nova-senha').val();
  let repeteSenha = $('.repete-senha').val();

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

      alert(data)
    }

  })


}
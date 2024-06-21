var baseUrl = $('.base-url').val();

const cadastraTipoCusto = () => {

  let nome = $('.input-tipo-custo').val();
  let id = $('.input-id').val();

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
      url: `${baseUrl}finTiposCustos/cadastraTipoCusto`,
      data: {
        nome: nome,
        id: id
      },
      beforeSend: function () {
        $('.load-form').removeClass('d-none');
        $('.btn-envia').addClass('d-none');
      },
      success: function (data) {

        $('.load-form').addClass('d-none');
        $('.btn-envia').removeClass('d-none');

        let redirect = data.type != 'error' ? `${baseUrl}finTiposCustos` : '#';

        avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

      }, error: function (xhr, status, error) {
        if (xhr.status === 403) {
          avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação..`, 'error', '#');
        }
      }
    });
  }
}

const deletaTipoCusto = (id) => {

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
        url: `${baseUrl}finTiposCustos/deletaTipoCusto`,
        data: {
          id: id
        }, success: function (data) {

          let redirect = data.type != 'error' ? `${baseUrl}finTiposCustos` : '#';

          avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

        }, error: function (xhr, status, error) {
          if (xhr.status === 403) {
            avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação..`, 'error', '#');
          }
        }
      })

    }
  })


}
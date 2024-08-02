var baseUrl = $('.base-url').val();

const cadastraTipoOrigemCadastro = () => {
  let nome = $('.input-tipo-origem-cadastro').val();
  let id = $('.input-id').val();

  // Verificação de campo vazio e permissão para cadastrar
  let permissao = verificaCamposObrigatorios('input-obrigatorio');

  if (permissao) {
    $.ajax({
      type: "post",
      url: `${baseUrl}tipoOrigemCadastro/cadastraTipoOrigemCadastro`,
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

        let redirect = data.type != 'error' ? `${baseUrl}tipoOrigemCadastro` : '#';

        avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);
      },
      error: function (xhr, status, error) {
        if (xhr.status === 403) {
          avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação..`, 'error', '#');
        }
      }
    });
  }
}

const deletaTipoOrigemCadastro = (id) => {
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
        url: `${baseUrl}tipoOrigemCadastro/deletaTipoOrigemCadastro`,
        data: {
          id: id
        },
        success: function (data) {
          let redirect = data.type != 'error' ? `${baseUrl}tipoOrigemCadastro` : '#';

          avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);
        },
        error: function (xhr, status, error) {
          if (xhr.status === 403) {
            avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação..`, 'error', '#');
          }
        }
      });
    }
  });
}

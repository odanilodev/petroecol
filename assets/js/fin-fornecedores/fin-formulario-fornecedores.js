var baseUrl = $('.base-url').val();

const cadastraFornecedor = () => {

  let id = $('.input-id').val();

  let nomeEmpresa = $('.input-nome-empresa').val();
  let nomeContato = $('.input-nome-contato').val();
  let telefone = $('.input-telefone').val();
  let cnpj = $('.input-cnpj').val();
  let estado = $('.input-estado').val();
  let cidade = $('.input-cidade').val();
  let rua = $('.input-rua').val();
  let contaBancaria = $('.input-conta-bancaria').val();
  
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
      url: `${baseUrl}finFornecedores/cadastraFornecedor`,
      data: {
        id: id,
        nomeEmpresa: nomeEmpresa,
        nomeContato: nomeContato,
        telefone: telefone,
        cnpj: cnpj,
        estado: estado,
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

          avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}finFornecedores`);

        } else {

          avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

        }
      }
    });
  }
}

const deletaFornecedor = (id) => {

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
        url: `${baseUrl}finFornecedores/deletaFornecedor`,
        data: {
          id: id
        }, success: function (data) {

          let redirect = data.type != 'error' ? `${baseUrl}finFornecedores` : '#';

          avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

        }
      })

    }
  })


}
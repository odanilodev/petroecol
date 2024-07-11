var baseUrl = $(".base-url").val();


const deletaDocumentoEmpresa = (id) => {

  let idsAgrupados = agruparIdsCheckbox();

  if (idsAgrupados.length >= 2) {
    var ids = idsAgrupados;
  } else {
    var ids = [id];
  }

  Swal.fire({
    title: "Você tem certeza?",
    text: "Esta ação não poderá ser revertida",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Sim, deletar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "post",
        url: `${baseUrl}documentoEmpresa/deletaDocumentoEmpresa`,
        data: {
          ids: ids,
        },
        success: function () {
          avisoRetorno(
            "Sucesso!",
            "Documento deletado com sucesso!",
            "success",
            `${baseUrl}documentoEmpresa/`
          );
        },
      });
    }
  });
};

function novoDocumento() {
  // Clone o último grupo de campos dentro de .campos-documento
  let clone = $(".campos-documento .duplica-documento").clone();

  // Limpe os valores dos campos clonados
  clone.find("input").val("");
  clone.find("label").html("");

  // Remova classes específicas que não deseja manter
  clone.removeClass('duplica-documento', 'campos-documento'); // Exemplo de remoção de uma classe específica

  let btnRemove = `
      <div class="col-md-1 mt-4 text-center">            
          <button type="button" class="btn btn-sm btn-phoenix-danger deleta-documento">
              <span class="fas fa-minus"></span>
          </button>
      </div>
  `;

  // Crie uma nova linha para envolver o clone e o botão de remoção
  let novaLinha = $('<div class="row m-0 p-0"></div>');

  // Adicione o clone e o botão de remoção à nova linha
  novaLinha.append(clone);
  novaLinha.append(btnRemove);

  // Adicione o evento de remoção ao botão deleta-documento
  novaLinha.find('.deleta-documento').on('click', function () {
    novaLinha.remove();
  });

  // Adicione a nova linha à seção de campos duplicados
  $(".campos-duplicados").append(novaLinha);

  $('.datetimepicker').flatpickr({
    dateFormat: "d/m/Y",
    disableMobile: true
  });
}


const editarDicionarioGlobal = (id) => {

  $('.campos-dicionario input').removeClass('invalido');
  $('.campos-dicionario input').next().addClass('d-none');

  $.ajax({
    type: "POST",
    url: `${baseUrl}dicionario/recebeIdDicionarioGlobal`,
    data: {
      id: id,
    },
    success: function (data) {

      $(".input-chave").val(data["dicionario"].chave);
      $(".input-valor-ptbr").val(data["dicionario"].valor_ptbr);
      $(".input-valor-en").val(data["dicionario"].valor_en);
      $(".input-id").val(id);
    },
  });
};
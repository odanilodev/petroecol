var baseUrl = $(".base-url").val();


const cadastraNovoDocumento = () => {
  let permissao = verificaCamposObrigatorios('input-obrigatorio');

  let id = $('.input-id').val();
  let nome = $('.input-nome-documento').val();
  let dataVencimento = $('.input-data-vencimento').val();
  let documentoEmpresa = $('#documentoEmpresa')[0].files[0];

  let partesData = dataVencimento.split('/');
  let dataSelecionada = new Date(partesData[2], partesData[1] - 1, partesData[0]);
  let dataAtual = new Date(); 

  dataAtual.setHours(0, 0, 0, 0);

  if (dataSelecionada < dataAtual) {
    Swal.fire({
      icon: 'error',
      title: 'Data Inválida',
      text: 'Por favor, selecione uma data igual ou posterior à data atual.',
      confirmButtonText: 'OK'
    });
    return; 
  }

  if (documentoEmpresa && documentoEmpresa.size > 5120 * 1024) { 
    Swal.fire({
      icon: 'error',
      title: 'Arquivo muito grande',
      text: 'O tamanho do arquivo excede o limite de 5 MB. Por favor, selecione um arquivo menor.',
      confirmButtonText: 'OK'
    });
    $('#documentoEmpresa').val('');
    return; 
  }

  let formData = new FormData();
  formData.append('id', id);
  formData.append('nome', nome);
  formData.append('validade', `${partesData[2]}-${partesData[1]}-${partesData[0]}`);
  formData.append('documento', documentoEmpresa);

  if (permissao) {
    $.ajax({
      type: "POST",
      url: `${baseUrl}documentoEmpresa/cadastraDocumentoEmpresa`,
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function () {
        $('.load-form').removeClass('d-none');
        $('.btn-envia').addClass('d-none');
      },
      success: function (data) {
        $('.load-form').addClass('d-none');
        $('.btn-envia').removeClass('d-none');

        if (data.success) {
          avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}documentoEmpresa`);
        } else {
          avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');
        }
      },
      error: function (xhr, status, error) {
        $('.load-form').addClass('d-none');
        $('.btn-envia').removeClass('d-none');
        if (xhr.status === 403) {
          avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação..`, 'error', '#');
        }
      }
    });
  }
};

const deletaDocumentoEmpresa = (id) => {

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
          id: id,
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


function visualizarDocumento(id) {
  $.ajax({
    type: "POST",
    url: `${baseUrl}documentoEmpresa/recebeDocumentoEmpresa`,
    data: { id: id },
    beforeSend: function () {
      $('#imagemDocumento').addClass('d-none');
      $('#downloadDocumento').addClass('d-none');
      $('#avisoDocumento').addClass('d-none');
    },
    success: function (response) {
      if (response) {
        let imagemUrl = `${baseUrl}uploads/2/documentos-empresa/${response.documento}`;
        let extensao = response.documento.split('.').pop().toLowerCase();

        if (['jpg', 'jpeg', 'png'].includes(extensao)) {
          $('#imagemDocumento').attr('src', imagemUrl).removeClass('d-none');
          $('#downloadDocumento').attr('href', imagemUrl).attr('download', response.documento).removeClass('d-none');
        } else {
          $('#avisoDocumento').text('A visualização prévia só está disponível para os formatos JPG, JPEG e PNG.').removeClass('d-none');
          $('#downloadDocumento').attr('href', imagemUrl).attr('download', response.documento).removeClass('d-none');
        }

        $('#modalVisualizarDocumentoLabel').text(`Visualizando Documento (${response.nome})`);
        $('#modalVisualizarDocumento').modal('show');
      } else {
        avisoRetorno('Erro ao carregar o documento. Por favor, tente novamente.');
      }
    },
    error: function () {
      avisoRetorno('Erro ao carregar o documento. Por favor, tente novamente.');
    }
  });
}

function downloadDocumento(id) {
  $.ajax({
    type: "POST",
    url: `${baseUrl}documentoEmpresa/recebeDocumentoEmpresa`,
    data: { id: id },
    success: function (response) {
      if (response && response.documento) {
        let documentoUrl = `${baseUrl}uploads/2/documentos-empresa/${response.documento}`;

        // Criar um link temporário e disparar o download
        let link = document.createElement('a');
        link.href = documentoUrl;
        link.download = response.documento;
        link.click();
      } else {
        avisoRetorno('Documento não encontrado ou erro ao obter o documento.');
      }
    },
    error: function () {
      avisoRetorno('Erro ao carregar o documento. Por favor, tente novamente.');
    }
  });
}








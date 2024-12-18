var baseUrl = $('.base-url').val();

const cadastraFuncionario = () => {

    let id = $('.input-id').val();
    let nome = $('.input-nome').val();
    let telefone = $('.input-telefone').val();
    let cpf = $('.input-cpf').val();
    let dataCnh = $('.input-data').val();
    let data_aso = $('.input-data-aso').val();
    let data_nascimento = $('.input-data-nascimento').val();
    let id_cargo = $('.input-cargo').val();
    let residencia = $('.input-residencia').val();
    let salario_base = $('.input-salario').val();
    let conta_bancaria = $('.input-conta-bancaria').val();

    let fotoPerfil = $('.inputFoto')[0].files[0];
    let fotoCnh = $('.inputCnh')[0].files[0];
    let fotoCpf = $('.inputCpf')[0].files[0];
    let fotoAso = $('.inputAso')[0].files[0];
    let fotoEpi = $('.inputEpi')[0].files[0];
    let fotoRegistro = $('.inputRegistro')[0].files[0];
    let fotoCarteira = $('.inputCarteira')[0].files[0];
    let fotoVacinacao = $('.inputVacinacao')[0].files[0];
    let fotoCertificados = $('.inputCertificados')[0].files[0];
    let fotoOrdem = $('.inputOrdem')[0].files[0];

    // cria um FormData para enviar os dados e a imagem
    let formData = new FormData();
    formData.append('id', id);
    formData.append('nome', nome);
    formData.append('telefone', telefone);
    formData.append('residencia', residencia);
    formData.append('conta_bancaria', conta_bancaria);
    formData.append('salario_base', salario_base);
    formData.append('id_cargo', id_cargo);
    formData.append('cpf', cpf);
    formData.append('data_cnh', dataCnh);
    formData.append('data_aso', data_aso);
    formData.append('data_nascimento', data_nascimento);
    formData.append('foto_cnh', fotoCnh);
    formData.append('foto_perfil', fotoPerfil);
    formData.append('foto_cpf', fotoCpf);
    formData.append('foto_aso', fotoAso);
    formData.append('foto_epi', fotoEpi);
    formData.append('foto_registro', fotoRegistro);
    formData.append('foto_carteira', fotoCarteira);
    formData.append('foto_vacinacao', fotoVacinacao);
    formData.append('foto_certificados', fotoCertificados);
    formData.append('foto_ordem', fotoOrdem);

    var permissao = true;

    // Valida se veio nome
    $('.input-obrigatorio').each(function () {

        if ($(this).val().trim() === "") {

            $(this).addClass('invalido');
            $(this).next().removeClass('d-none');

            permissao = false;

        } else {

            $(this).removeClass('invalido');
            $(this).next().addClass('d-none');
        }
    })

    if (permissao) {

        $.ajax({
            type: "post",
            url: `${baseUrl}funcionarios/cadastraFuncionario`,
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.load-form').removeClass('d-none');
                $('.btn-envia').addClass('d-none');
            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-envia').removeClass('d-none');

                if (data.success) {

                    avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}funcionarios`);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                    if (data.message == 'Já existe um funcionário com este CPF!' || data.message == 'CPF inválido. Por favor, insira um CPF válido.') {
                        $('.input-cpf').addClass('invalido');
                    }

                }

            }, error: function (xhr, status, error) {

                $('.load-form').addClass('d-none');
                $('.btn-envia').removeClass('d-none');
                if (xhr.status === 403) {
                    avisoRetorno('Algo deu errado!', `Você não tem permissão para esta ação..`, 'error', '#');
                }
            }
        });
    }
}

const deletarFuncionario = (id) => {

    Swal.fire({
        title: 'Você tem certeza?',
        text: "Esta ação não poderá ser revertida",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sim, inativar'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                type: 'post',
                url: `${baseUrl}funcionarios/deletaFuncionario`,
                data: {
                    id: id
                }, success: function (data) {

                    let redirect = data.type != 'error' ? `${baseUrl}funcionarios/` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                },

            })

        }
    })


}

const deletaDocumentoFuncionario = (id, coluna) => {

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
                url: `${baseUrl}funcionarios/deletaDocumentoFuncionario`,
                data: {
                    id: id,
                    coluna: coluna
                }, success: function (data) {

                    var redirect = data.type != 'error' ? `${baseUrl}funcionarios/${data.caminho}/${id}` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                }
            })

        }
    })
}


const deletaFotoPerfil = (id, coluna) => {

    deletaDocumentoFuncionario(id, coluna);

}

$(document).ready(function () {

    $('#input-cargo').val('').trigger('change');

    $('.select2').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
    });
})

function reativarFuncionario(id) {
    Swal.fire({
        title: "Tem certeza?",
        text: "Deseja realmente reativar este funcionário?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim, reativar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: `${baseUrl}funcionarios/cadastraFuncionario`,
                data: {
                    id: id,
                    status: 1
                },
                success: function (data) {
                    avisoRetorno(data.title, data.message, data.type, `${baseUrl}funcionarios/inativados`);
                },
                error: function () {
                    avisoRetorno("Erro", "Ocorreu um erro ao tentar reativar o funcionário.", "error", `${baseUrl}funcionarios/inativados`);
                }
            });
        }
    });
}


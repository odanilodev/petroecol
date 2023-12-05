var baseUrl = $('.base-url').val();

const cadastraFuncionario = () => {

    let id = $('.input-id').val();
    let nome = $('.input-nome').val();
    let telefone = $('.input-telefone').val();
    let cpf = $('.input-cpf').val();
    let dataCnh = $('.input-data').val();
    let data_nascimento = $('.input-data-nascimento').val();
    let funcao = $('.input-funcao').val();
    let residencia = $('.input-residencia').val();
    let salario_base = $('.input-salario').val();

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
    formData.append('residencia',residencia);
    formData.append('salario_base',salario_base);
    formData.append('funcao', funcao);
    formData.append('cpf', cpf);
    formData.append('fotoCnh', fotoCnh);
    formData.append('data_cnh', dataCnh);
    formData.append('data_nascimento', data_nascimento);
    formData.append('foto_perfil', fotoPerfil);
    formData.append('foto_cpf', fotoCpf);
    formData.append('foto_aso', fotoAso);
    formData.append('foto_epi', fotoEpi);
    formData.append('foto_registro', fotoRegistro);
    formData.append('foto_carteira', fotoCarteira);
    formData.append('foto_vacinacao', fotoVacinacao);
    formData.append('foto_certificados', fotoCertificados);
    formData.append('foto_ordem', fotoOrdem);

    var permissao = false;
  
    // Valida se veio nome
    if (nome != "") {

        permissao = true;

    }

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

                }
            }
        });
    }
}

const deletarFuncionario= (id) => {

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
                url: `${baseUrl}funcionarios/deletaFuncionario`,
                data: {
                    id: id
                }, success: function () {

                    avisoRetorno('Sucesso!', 'Funcionario deletado com sucesso!', 'success', `${baseUrl}funcionarios`);

                }
            })

        }
    })


}

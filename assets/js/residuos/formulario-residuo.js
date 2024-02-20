var baseUrl = $('.base-url').val();

const cadastraResiduos = () => {

    let residuo = $('.input-nome').val();
    let grupo = $('.input-grupo').val();
    let id = $('.input-id').val();
    let uni = $('.input-medida').val();
    let idSetor = $('.input-setor-residuo').val();

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
            url: `${baseUrl}residuos/cadastraResiduo`,
            data: {
                residuo: residuo,
                grupo: grupo,
                id: id,
                unidade: uni,
                idSetor: idSetor
            },
            beforeSend: function () {
                $('.load-form').removeClass('d-none');
                $('.btn-envia').addClass('d-none');
            },
            success: function (data) {

                $('.load-form').addClass('d-none');
                $('.btn-envia').removeClass('d-none');

                if (data.success) {

                    avisoRetorno('Sucesso!', `${data.message}`, 'success', `${baseUrl}residuos`);

                } else {

                    avisoRetorno('Algo deu errado!', `${data.message}`, 'error', '#');

                }
            }
        });
    }
}


const deletarResiduo = (id) => {

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
                url: `${baseUrl}residuos/deletaResiduo`,
                data: {
                    id: id
                }, success: function (data) {

                    let redirect = data.type != 'error' ? `${baseUrl}residuos` : `${baseUrl}clientes`;

                    if (data.id_vinculado) {

                        avisoRetornoFilter(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`, data.id_vinculado, 'id_residuo', 'Ver Clientes');

                    }else{

                        avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);
                        
                    }


                }
            })

        }
    })


}

$(document).ready(function () {
    
    $('#input-grupo').val('').trigger('change');

    $('.select2').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
    });
})
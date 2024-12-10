const deletarVendaResiduo = (idVenda) => {

		alert(idVenda); return;


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
                url: `${baseUrl}vendas/deletaVendaResiduo`,
                data: {
                    idVenda: idVenda
                }, success: function (data) {

                    let redirect = data.redirect ? `${baseUrl}vendas/residuos` : '#';

                    avisoRetorno(`${data.title}`, `${data.message}`, `${data.type}`, `${redirect}`);

                }
            })

        }
    })

}
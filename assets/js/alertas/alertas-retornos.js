
const avisoRetorno = (titulo, texto, icone, redirect) => {

    Swal.fire({
        title: `${titulo}`,
        text: `${texto}`,
        icon: `${icone}`,
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            window.location.href = `${redirect}`;
        }
    });

}


const avisoRetornoFilter = (titulo, texto, icone, redirect, id_filter, input, txtConfirmarBotao) => {

    Swal.fire({
        title: `${titulo}`,
        text: `${texto}`,
        icon: `${icone}`,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: `${txtConfirmarBotao}`,
        allowOutsideClick: false, 
    }).then((result) => {

        if (result.isConfirmed) {

            var form = $('<form>', {
                'action': `${redirect}`, 
                'method': 'post',
                'style': 'display: none;'
            });

            form.append($('<input>', {
                'type': 'hidden',
                'name': input,
                'value': id_filter
            }));
        
            $('body').append(form);

            form.submit();
        }
    });

}
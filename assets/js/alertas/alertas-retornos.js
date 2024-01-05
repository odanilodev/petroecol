
const avisoRetorno = (titulo, texto, icone, redirect) => {

    Swal.fire({
        title: `${titulo}`,
        text: `${texto}`,
        icon: `${icone}`

    }).then((result) => {

        if (result.isConfirmed) {

            window.location.href = `${redirect}`;
        }
    });

}

const avisoRetornoFilter = (titulo, texto, icone, redirect, id_filter, input) => {

    Swal.fire({
        title: `${titulo}`,
        text: `${texto}`,
        icon: `${icone}`

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
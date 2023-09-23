
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
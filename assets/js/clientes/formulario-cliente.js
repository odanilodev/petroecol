
const verificaCampos = () => {

    let dadosEmpresas = {};

    $('#form-empresa input').each(function () {
        dadosEmpresas[$(this).attr('name')] = $(this).val();
    });


}


$(document).on('change', '.select-tipo-conta', function () {

    if ($(this).val() == 'entrada') {
        $('.label-forma-pagamento').html('Forma de recebimento');
    } else {
        $('.label-forma-pagamento').html('Forma de pagamento');
        
    }
})
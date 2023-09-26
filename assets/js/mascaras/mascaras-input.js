$(document).ready(function () {
    
    $('.mascara-cep').mask('00000-000');
    $('.mascara-tel').mask('(00) 00000-0000');
    $('.mascara-cnpj').mask('00.000.000/0000-00', { reverse: true });
});
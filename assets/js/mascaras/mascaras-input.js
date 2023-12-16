$(document).ready(function () {
    
    $('.mascara-cep').mask('00000-000');
    $('.mascara-placa').mask('AAA-AAAA', { translation: { 'A': { pattern: /[A-Za-z0-9]/ } } });
    $('.mascara-tel').mask('(00) 00000-0000');
    $('.mascara-cnpj').mask('00.000.000/0000-00', { reverse: true });
    $('.mascara-cpf').mask('000.000.000-00', {reverse: true});
    $('.mascara-dinheiro').mask('000.000.000.000.000,00', {reverse: true});
});
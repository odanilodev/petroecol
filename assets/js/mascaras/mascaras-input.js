$(document).ready(function () {

    $('.mascara-cep').mask('00000-000');
    $('.mascara-placa').mask('AAA-AAAA', { translation: { 'A': { pattern: /[A-Za-z0-9]/ } } });
    $('.mascara-tel').mask('(00) 00000-0000');
    $('.mascara-cnpj').mask('00.000.000/0000-00', { reverse: true });
    $('.mascara-conta-bancaria').mask('00000000000000000000', { translation: { '0': { pattern: /[0-9/.-]/ } } });
    $('.mascara-cpf').mask('000.000.000-00', { reverse: true });
    $('.mascara-dinheiro').mask('000.000.000.000.000,00', { reverse: true });
    $('.mascara-agencia').mask('0000-0 / 00');
    $('.mascara-conta-bancaria').mask('00000000000000000000', { translation: { '0': { pattern: /[0-9/.-]/ } } });
});
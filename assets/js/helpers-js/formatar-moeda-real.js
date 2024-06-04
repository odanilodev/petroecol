function formatarValorMoeda(valor) {
    // Converte o valor para um número, se necessário
    const numero = Number(valor);

    // Verifica se o valor convertido é um número válido
    if (isNaN(numero)) {
        throw new Error('O valor fornecido não é um número válido');
    }

    // Retorna o valor formatado como moeda BRL
    return numero.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

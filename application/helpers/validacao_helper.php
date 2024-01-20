<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Função para validar CPF.
// Recebe um parâmetro string|null numérico ($value = CPF a ser validado).
// Retorna um booleano. True se o CPF for válido, caso contrário, retorna False.
if (!function_exists('validarCpf')) {

    function validarCpf($value = null)
    {
        if (empty($value)) {

            return true;
        }

        // Remove caracteres não numéricos do CPF
        $c = preg_replace('/\D/', '', $value);

        // Verifica se o CPF tem 11 dígitos ou se são todos iguais
        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        // Calcula o primeiro dígito verificador do CPF
        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--) {
        }
        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        // Calcula o segundo dígito verificador do CPF
        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--) {
        }
        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        // Se todas as verificações passaram, considera o CPF como válido
        return true;
    }
}

?>

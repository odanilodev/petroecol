<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('verificaArrayVazio')) {
    
    function verificaArrayVazio($array)
    {
        if (empty($array)) {
            return false;
        }

        foreach ($array as $value) {
            if (is_array($value)) {
                // verifica se tem array dentro do array que está vazio
                if (!verificaArrayVazio($value)) {
                    return false;
                }
            } elseif (empty($value)) {
                return false;
            }
        }

        return true;
    }
}

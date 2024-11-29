<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('calcularUnidadeMedidaResiduo')) {
    
    function calcularUnidadeMedidaResiduo($valor, $tipoOperacao, $quantidade)
    {
        switch ($tipoOperacao) {
			case '*': // multiplicação
				$expressao = "$valor $tipoOperacao $quantidade";
				break;
			case '/': // divisão
				$expressao = "$quantidade $tipoOperacao $valor";
				break;
			default:
				$expressao = "$quantidade $tipoOperacao $valor";
				break;
		}

		eval('$resultado = ' . $expressao . ';');

        return $resultado;
    }
}

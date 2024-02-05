<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('contaResiduosColetados')) {
  function contaResiduosColetados($mes = null)
  {
    $CI = &get_instance();
    $CI->load->model('Coletas_model');

    $residuosColetadosMes = $CI->Coletas_model->contaResiduosColetadosMes($mes);

    $quantidadeColetada = 0;
    foreach ($residuosColetadosMes as $residuoColetado) {
      $qtdColetada = json_decode($residuoColetado['quantidade_coletada']);

      // Verifica se $qtdColetada é um array e se a primeira posição está definida
      // para evitar possíveis erros caso o formato do JSON não seja como esperado.
      if (is_array($qtdColetada) && isset($qtdColetada[0])) {
        $quantidadeColetada += intval($qtdColetada[0]);
      }
    }

    return $quantidadeColetada;
  }

  if (!function_exists('clientesPorStatus')) {
    function clientesPorStatus()
    {
      $CI = &get_instance();
      $CI->load->model('Clientes_model');

      $clientesPorStatus = $CI->Clientes_model->contaClientesPorStatus();

      $contagemPorStatus = array();

      foreach ($clientesPorStatus as $v) {
        $contagemPorStatus[$v['status']] = $v['TOTAL_CLIENTES_POR_STATUS'];
      }

      return $contagemPorStatus;
    }
  }
  }

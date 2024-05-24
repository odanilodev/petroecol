<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ResiduosOrdenados
{
  protected $CI;

  public function __construct()
  {
    $this->CI = &get_instance();
    $this->CI->load->model('Coletas_model');
    $this->CI->load->model('Residuos_model');
  }

  public function ordenarResiduos(array $idResiduo, array $qtdResiduo): array
  {
    $arrayIdResiduos = [];
    $arrayQtdResiduos = [];
    $arrayQtdResiduosFinal = [];

    for ($i = 0; $i < count($idResiduo); $i++) {

      if (isset($arrayIdResiduos[$idResiduo[$i]])) {

        $arrayQtdResiduos[$idResiduo[$i]] += $qtdResiduo[$i];
      } else {

        $arrayQtdResiduos[$idResiduo[$i]] = $qtdResiduo[$i];

        $retorno = $this->CI->Residuos_model->recebeResiduo($idResiduo[$i]);

        $arrayIdResiduos[$idResiduo[$i]] = $retorno['nome'];
      }
    }

    asort($arrayIdResiduos);

    foreach ($arrayIdResiduos as $key => $value) {
      $arrayQtdResiduosFinal[] = $arrayQtdResiduos[$key];
    }
    
    $idsResiduos = array_flip($arrayIdResiduos);


    return ["id_residuo" => array_values($idsResiduos), "qtd_residuo" => array_values($arrayQtdResiduosFinal)];
  }
}

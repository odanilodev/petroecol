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

  //Função da library responsavel por ordenar os residuos e suas quantidades respectivas alfabeticamente
  public function ordenarResiduos(array $idResiduo, array $qtdResiduo): array
  {
    //Criamos três arrays vazios para receberem informações
    $arrayIdResiduos = [];
    $arrayQtdResiduos = [];
    $arrayQtdResiduosFinal = [];

    //Passamos no 'for' cada residuo recebido e atrelamos eles ao arrayIdResiduos
    for ($i = 0; $i < count($idResiduo); $i++) {


      if (isset($arrayIdResiduos[$idResiduo[$i]])) {
        //Para a segunda e proximas vezes que um mesmo residuo existir, adicionamos sua quantidade a ele, para não duplicar o residuo
        $arrayQtdResiduos[$idResiduo[$i]] += $qtdResiduo[$i];
      } else {
        //Ao passar pela primeira vez, o resíduo é atrelado a sua quantidade correta, na mesma chave
        $arrayQtdResiduos[$idResiduo[$i]] = $qtdResiduo[$i];

        //Recebemos o nome do residuo com função já existente
        $retorno = $this->CI->Residuos_model->recebeResiduo($idResiduo[$i]);

        //Atrelamos seu 'nome' ao idResiduo que recebemos
        $arrayIdResiduos[$idResiduo[$i]] = $retorno['nome'];
      }
    }

    //Utilizamos esta função do PHP (array sort) para ordenar o array que criamos no for por ordem alfabética
    asort($arrayIdResiduos);

    //Neste foreach utilizamos o array criado para associar residuo a quantidade
    foreach ($arrayIdResiduos as $key => $value) {
      $arrayQtdResiduosFinal[] = $arrayQtdResiduos[$key];
    }
    
    //Invertemos chave com valor do array para retornarmos da maneira correta
    $idsResiduos = array_flip($arrayIdResiduos);

    return ["id_residuo" => array_values($idsResiduos), "qtd_residuo" => array_values($arrayQtdResiduosFinal)];
  }
}

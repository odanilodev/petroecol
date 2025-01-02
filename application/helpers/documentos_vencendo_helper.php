<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('documentosVencendo')) {

    function documentosVencendo()
    {
        $CI = &get_instance();
        $CI->load->model('DocumentoEmpresa_model');

        $hoje = new DateTime();
        $hojeFormatada = $hoje->format('Y-m-d');

        $documentos = $CI->DocumentoEmpresa_model->recebeDocumentosEmpresa();
        $diasAviso = 30;

        $documentos_vencendo = [];
        $documentos_vencidos = [];

        foreach ($documentos as $documento) {
            $dataValidade = new DateTime($documento['validade']);
            $dataAviso = clone $dataValidade;
            $dataAviso->modify("-{$diasAviso} days");

            if ($hojeFormatada > $dataValidade->format('Y-m-d')) {
                $documentos_vencidos[] = $documento;
            } elseif ($hojeFormatada >= $dataAviso->format('Y-m-d')) {
                $documentos_vencendo[] = $documento;
            }
        }

        return [
            'vencendo' => $documentos_vencendo,
            'vencido' => $documentos_vencidos,
        ];
    }
}

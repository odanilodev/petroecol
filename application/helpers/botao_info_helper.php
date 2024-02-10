<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('botao_info')) {
    function botao_info($chaveTextoInformativo) {

        $html = '
                <span class="uil-question-circle cursor-pointer" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="' . htmlspecialchars($chaveTextoInformativo) . '"></span>
                ';

        return $html;
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');


if (!function_exists('formatarData')) {

    function formatarData($data = null)
    {
        return $data ? date('d/m/Y', strtotime($data)) : "--";
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('limparCache')) {
    function limparCache($pasta): void
    {
        $CI = &get_instance();
        $CI->load->driver('cache', array('adapter' => 'file'));

        $caminho_cache = $CI->config->item('cache_path');
        $files = glob($caminho_cache . '/'.$pasta.'/*');

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload_imagem
{
    protected $CI;


    function uploadImagem(array $arrayUpload, string $type = '*', $size = null): array
    {
        $CI = &get_instance();

        if ($arrayUpload) {
            $dados = [];
            foreach ($arrayUpload as $nomeCampo => $option) { //$option[0] => caminho,  $option[1] => Imagem antiga

                if (!empty($_FILES[$nomeCampo]['name'])) {

                    $config['upload_path'] = './uploads/' . $CI->session->userdata('id_empresa') . '/' . $option[0];
                    $config['allowed_types'] = $type;

                    if ($size) {
                        $config['max_size'] = $size;
                    }

                    // Verifica se a pasta existe, se não, cria
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, true);
                    }

                    $CI->load->library('upload', $config);
                    $CI->upload->initialize($config);

                    if ($CI->upload->do_upload($nomeCampo)) {

                        // Deleta a imagem antiga do servidor
                        if ($option[1] && file_exists($config['upload_path'] . '/' . $option[1])) {
                            unlink($config['upload_path'] . '/' . $option[1]);
                        }

                        $dados_imagem = $CI->upload->data();
                        $dados[$nomeCampo] = $dados_imagem['file_name'];
                    } else {
                        echo $CI->upload->display_errors();
                        exit;
                    }
                }
            }
            return $dados;
        }

        return [];
    }
}

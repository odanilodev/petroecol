<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_imagem {
    protected $CI;


    function uploadImagem($nomeCampo, $diretorio)
    {
        if (!empty($_FILES[$nomeCampo]['name'])) {
            $config['upload_path'] = $diretorio;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf|docx';

            $CI = &get_instance(); // Obtém uma referência à instância do CodeIgniter

            $CI->load->library('upload', $config);
            $CI->upload->initialize($config);

            if ($CI->upload->do_upload($nomeCampo)) {
                $dados_imagem = $CI->upload->data();
                return $dados_imagem['file_name'];
            }
        }

        return null;
    }


    function uploadEditarImagem($nomeCampo, $diretorio, $imagemAntiga)
    {
        // Verifica se veio imagem
        if (!empty($_FILES[$nomeCampo]['name'])) {
            $config['upload_path'] = $diretorio;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf|docx';

            $CI = &get_instance(); // Obtém uma referência à instância do CodeIgniter

            $CI->load->library('upload', $config);
            $CI->upload->initialize($config);

            // Deleta a imagem antiga do servidor
            if ($imagemAntiga && file_exists($diretorio . '/' . $imagemAntiga)) {
                unlink($diretorio . '/' . $imagemAntiga);
            }

            if ($CI->upload->do_upload($nomeCampo)) {
                $dados_imagem = $CI->upload->data();
                return $dados_imagem['file_name'];
            }
        } else {
            // Se não veio imagem, mantém a imagem antiga
            return $imagemAntiga;
        }

        return null;
    }

}

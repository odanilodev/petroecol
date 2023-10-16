<?php 
// application/libraries/Menu_library.php

class Menu_library {
    private $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('Menu_model');
    }

    public function load_menu() {
        $data['menus'] = $this->CI->Menu_model->recebeMenus(); // Busque os menus no modelo

        // Carregue a visão do menu
        $this->CI->load->view('menu_view', $data);
    }
}


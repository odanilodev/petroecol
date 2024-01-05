<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Controle_sessao
{
	protected $CI;

	public function controle()
	{

		$CI = get_instance();
		$CI->load->model('Usuarios_model');
		$CI->load->model('Menu_model');

		$c = $CI->router->class; // class atual

		if ($CI->session->userdata('logado') == true) {

			$usuario = $CI->Usuarios_model->recebeUsuario($CI->session->userdata('id_usuario'));
			$perm = $usuario['permissao'] ?? null;
			$permissao = json_decode($perm, true);
			$array_menu[] = '';

			if ($perm) {
				foreach ($permissao as $v) {
					$menu_liberado = $CI->Menu_model->recebeMenu($v);
					$format_link = explode('/', $menu_liberado['link'] ?? '');
					$array_menu[] = $format_link[0];
				}
			}

		
			if (in_array($c, $array_menu)) {
				//liberado
				$CI->session->set_userdata('menu', $CI->Menu_model->recebeMenus());
			} else {
				$result = 'erro';
				return $result;
				exit;
			}
		} else { // erro de acesso

			$link = base_url(uri_string()); // url pagina atual
			$link2 = explode('petroecol/', $link);

			$CI->session->set_flashdata('mensagem', 'Digite seu Login e Senha!');
			$CI->session->set_flashdata('tipo_alerta', 'danger');
			redirect('login/index/' . $link2[1], 'refresh');
		}
	}
}

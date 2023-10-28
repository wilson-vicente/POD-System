<?php
	if (!function_exists("setSesion")) {
		function setSesion($obj, $usr)
		{
			$data = array(
				"pod_usuario" => $usr->getPK(),
				"nombre"      => $usr->nombre,
				"correo"      => $usr->correo
			);

			$obj->set_userdata(["user" => (array) $usr]);
		}
	}

	if (!function_exists("link_script")) {
		function link_script($src, $print = FALSE)
		{
			if ( $print ) {
				$link = "<script type='text/javascript'>\n" . file_get_contents(sys_base($src)) . "\n</script>\n";
			} else {
				$CI =& get_instance();
				$link = '<script type="text/javascript" ';

				if (preg_match('#^([a-z]+:)?//#i', $src))
				{
					$link .= 'src="'.$src.'" ';
				}
				else
				{
					$link .= 'src="'.$CI->config->slash_item('base_url').$src.'" ';
				}

				$link .= "></script>\n";
			}

			return $link;
		}
	}

	if (!function_exists("sys_url")){
		function sys_url($url="")
		{
			return "http://" . $_SERVER['HTTP_HOST'] . "/" . $url;
		}
	}

	if ( ! function_exists(('sys_base'))) {
		# Devuelve la ruta de un archivo o carpeta en disco. Ej.: /home/usuer/documentos/archivo.pdf
		# El parémetro a recibir es igual al formato de base_url
		function sys_base($dir = '') {
			return dirname(dirname('__DIR__')) . "/{$dir}";
			# return dirname(dirname(dirname(__FILE__))) . "/{$dir}";
		}
	}

	if ( ! function_exists("verData") ) {
	/* Verifica que un índice se encuentre dentro de un arreglo. */
	function verData($arr, $dato, $return=FALSE) {
		if (is_array($arr) && array_key_exists($dato, $arr) && !empty($arr[$dato])) {
			return $arr[$dato];
		}
		
		return $return;
	}
}
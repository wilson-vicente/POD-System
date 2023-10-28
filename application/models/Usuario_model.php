<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends Gen_model {
	public $nombre = null;
	public $correo = null;
	public $clave  = null;
	public $activo = 0;

	public function __construct()
	{
		parent::__construct();
		$this->setTabla("usuario");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function iniciarSesion($usuario, $clave)
	{
		$tmp = $this->db
		->where("activo", 1)
		->where("correo", $usuario)
		->where("clave", "md5('{$clave}')", false)
		->get("usuario")
		->row();

		if ($tmp) {
			$this->cargar($tmp->id);
			return $this;
		}

		$this->setMensaje("Usuario o clave incorrecta.");

		return false;
	}

}

/* End of file Usuario_model.php */
/* Location: ./application/models/Usuario_model.php */
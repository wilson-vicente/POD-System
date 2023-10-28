<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->datos = array();

		$this->datos["scripts"][] = (object) array("ruta" => "assets/js/login.min.js", "print" => true);
	}

	public function index()
	{

		if ($this->input->server("REQUEST_METHOD") === "GET") {
			$this->datos["vista"] = "login/form";
			$this->load->view("principal", $this->datos);

		} elseif ($this->input->server("REQUEST_METHOD") === "POST") {
			$res = array("msg" => "¡Error!", "exito" => false);

			if (
				$this->input->post("correo") &&
				$this->input->post("clave")
			) {
				$usr = $this->Usuario_model->usuarioSesion($_POST);

				if ($usr) {
					$_SESSION["enc_usuario"] = $usr->usuario;
					$res["exito"] = true;
				} else {
					$res["msg"] = "Credenciales incorrectas, intente nuevamente";
				}
			} else {
				$res["msg"] = "Faltan datos obligatorios";
			}

			$this->output
				 ->set_content_type('application/json')
				 ->set_output(json_encode($res));
		} else {
			die("forbiden");
		}
	}

	public function registro()
	{
		if ($this->input->server("REQUEST_METHOD") === "GET") {
			$this->datos["menu"] = "menu";
			$this->datos["vista"] = "login/form_registro";

			$this->load->view("principal", $this->datos);
		} elseif ($this->input->server("REQUEST_METHOD") === "POST") {

			$res = array("exito" => false, "msg" => "¡Error!");

			if (
				$this->input->post("nombre") &&
				$this->input->post("correo") &&
				$this->input->post("clave") &&
				$this->input->post("clave1")
			) {
				$clvp = $this->input->post("clave");
				$clvs = $this->input->post("clave1");

				if (strlen($clvp) >= 8 && strlen($clvs) >= 8) {
					if ($clvp == $clvs) {
						$existeCorreo = $this->Usuario_model->usuarioSesion(array("correo" => $_POST["correo"]));
						$existeNombre = $this->Usuario_model->usuarioSesion(array("nombre" => $_POST["nombre"]));

						if ($existeNombre) {
							$res["msg"] = "Ya existe un colaborador con el mismo nombre";
						} else {
							if ($existeCorreo) {
								$res["msg"] = "Ya existe un colaborador con el mismo correo";
							} else {
								$user = new Usuario_model();

								if ($user->guardarUsuario($_POST)) {
									$res["exito"] = true;
								}
								$res["msg"] = $user->getMsg();
							}
						}
					} else {
						$res["msg"] = "Las contraseñas no coinciden";
					}
				} else {
					$res["msg"] = "La contraseña es muy débil";
				}
			} else {
				$res["msg"] = "Faltan datos obligatorios";
			}

			$this->output
				 ->set_content_type('application/json')
				 ->set_output(json_encode($res));
		} else {
			die("forbiden");
		}
	}

	public function cerrar_sesion()
	{
		session_destroy();
		redirect();
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
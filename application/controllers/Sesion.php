<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sesion extends CI_Controller {

	public function index()
	{
		$this->output->set_status_header(403);
	}

	public function login()
	{
		if ($this->input->method() === "post") {
			if ($this->input->post("clave") && $this->input->post("correo")) {
				$usr = new Usuario_model();

				if ($usr->iniciarSesion($_POST["correo"], $_POST["clave"])) {
					$this->load->helper("ayuda");
					setSesion($this->session, $usr);

					redirect("principal");
				} else {
					$this->session->set_userdata(["error_login" => $usr->getMensaje()]);
				}
			} else {
				$this->session->set_userdata(array("error_login" => array("Ingrese credenciales.")));
			}

			redirect("sesion/login");
		} else {
			if ($this->session->has_userdata("user")) {
				redirect("principal");
			} else {
				$this->load->view("principal", array(
					"vista" => "login/form"
				));
			}
		}
	}

	public function salir()
	{
		$this->session->sess_destroy();
		redirect('sesion/login');
	}
}

/* End of file Sesion.php */
/* Location: ./application/controllers/Sesion.php */
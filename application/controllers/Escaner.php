<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Escaner extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array("Articulo_model", "Venta_model"));

		$this->output->set_content_type("application/json");
	}

	public function index()
	{
		$this->output->set_content_type("text/html");

		$this->load->view("header");
		$this->load->view("escaner/base");
		$this->load->view("footer", array(
			"scripts" => array(
				(object) array("ruta" => "assets/js/escaner/base.js", "print" => true)
			)
		));
	}

	public function buscar()
	{
		if ($this->input->method() === "post") {
			$datos   = json_decode(file_get_contents("php://input"), true);
			$errores = array();
			$data    = array();
			
			if (verData($datos, "codigo") ||
				verData($datos, "descripcion")
			) {

				if (verData($datos, "codigo")) {
					$datos["_uno"] = true;
				}

				if (verData($datos, "descripcion")) {
					$datos = array(
						"_like" => $datos
					);
				}

				$datos["activo"] = 1;

				$existe = $this->Articulo_model->buscar($datos);

				if ($existe) {
					$data = $existe;
				} else {

					$tmp = isset($datos["codigo"]) ? $datos["codigo"] : $datos["descripcion"];

					$errores[] = "El código {$tmp} no existe.";
				}
			} else {
				$errores[] = "Faltan datos obligatorios.";
			}

			if (count($errores) === 0) {
				$this->output
				->set_status_header(200)
				->set_output(json_encode($data));
			} else {
				$this->output
				->set_status_header(400)
				->set_output(json_encode(array("errores" => implode(" | ", $errores))));
			}
		} else {
			$this->output->set_status_header(405);
		}
	}

	public function guardar_venta()
	{
		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents("php://input"), true);
			$errores = array();
			$data    = array();
			$mensaje = array();


			if (isset($datos["detalle"]) && count($datos["detalle"]) > 0) {
				$this->load->model(["Detalle_venta_model"]);
				$venta = new Venta_model();
				
				if ($venta->guardar($datos["venta"])) {
					$venta->guardarDetalle($datos["detalle"]);
					
					$data["mensaje"] = "Venta generada con éxito.";
				} else {
					$errores[] = "Error al generar la venta.";
				}

			} else {
				$errores[] = "No tiene producto ingresado para generar la venta.";
			}

			if (count($errores) === 0) {
				$this->output
				->set_status_header(200)
				->set_output(json_encode($data));
			} else {
				$this->output
				->set_status_header(400)
				->set_output(json_encode(array("errores" => implode(" | ", $errores))));
			}
		
		} else {
			$this->output->set_status_header(405);
		}
	}
}

/* End of file Escaner.php */
/* Location: ./application/controllers/Escaner.php */
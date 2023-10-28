<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingreso extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array("Ingreso_model"));
		$this->output->set_content_type("application/json");

	}

	public function index()
	{
		$this->output->set_content_type("text/html");

		
		$this->load->view("header");
		$this->load->view("mante/ingreso/base");

		$this->load->view("footer", array(
			"scripts" => array(
				(object) array("ruta" => "assets/js/mante/ingreso/base.js", "print" => true)
			)
		));
	}


	public function generarIngreso()
	{
		$errores = array();
		$data    = array();

		if ($this->Ingreso_model->cantidadIngresosAbiertos()) {
			
			if ($this->Ingreso_model->guardarIngreso()) {
				$data['mensaje'] = "Salida generado con éxito.";

				$tmp = $this->Ingreso_model->buscarIngresoGenerado();
				
				$data["reg"] = $tmp ? $tmp : array();

			} else {
				$errores[] = $this->Ingreso_model->getMensaje();
			}

		} else {
			$errores[] = "Existe un ingreso generado, por favor verificar.";
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

	}

	public function actualizarIngreso()
	{
		if ($this->input->method() === "post") {

			$datos   = json_decode(file_get_contents('php://input'), true);
			$errores = array();
			$data  	 = array();

			if ($datos["id"] > 0) {
				if ($this->Ingreso_model->actualizarIngresoGenerado($datos)) {
					$data['mensaje'] = "Actualizado con éxito.";
				} else {
					$errores[] = $this->Ingreso_model->getMensaje();
				}
			} else {
				$errores[] = "No existe número de ingreso, por favor de verificar.";
			}
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
	}


	public function buscarIngreso()
	{
		
		if ($this->input->method() === "post") {
			$datos   = json_decode(file_get_contents('php://input'), true);
			$errores = array();
			$data  	 = array();

			$tmp = $this->Ingreso_model->buscarIngreso($datos);
			$data["reg"] = $tmp ? $tmp : array();
			
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
	}

	public function guardarDetalleIngreso()
	{
		if ($this->input->method() === "post") {

			$datos   = json_decode(file_get_contents('php://input'), true);
			$errores = array();
			$data  	 = array();

			if (count($datos) > 0) {

				if (!empty($datos["idDetalleIngreso"]) && $datos["idDetalleIngreso"] > 0) {

					if ($this->Ingreso_model->actualizarDetalleIngreso($datos)) {
					
						$data['mensaje'] = "Detalle actualizado con éxito.";

					} else {
						$errores[] = $this->Ingreso_model->getMensaje();
					}

				} else {

					$xdata = array(
						"id_ingreso" => $datos["id_ingreso"],
						"id_articulo" => $datos["id_articulo"],
						"fecha_vencimiento" => $datos["fecha_vencimiento"],
						"cantidad" => $datos["cantidad"],
						"codigo" => $datos["codigo"]

					);

					if ($this->Ingreso_model->agregarDetalleIngeso($xdata)) {
					
						$data['mensaje'] = "Detalle ingresado con éxito.";

					} else {
						$errores[] = $this->Ingreso_model->getMensaje();
					}

				}

			} else {
				$errores[] = "Faltan datos obligatorios, por favor de verificar.";
			}
			
			
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

	}

	public function obtenerDetalleIngreso()
	{

		if ($this->input->method() === "get") {
			
			$tmp = $this->Ingreso_model->obtenerDetalleIngreso($_GET["id_ingreso"]);
			
			$lista = $tmp ? $tmp : array();

			$this->output->set_output(json_encode($tmp));

		} else {
			$this->output->set_status_header(405);
		}
		
	}

	public function eliminarDetalleIngreso()
	{
		if ($this->input->method() === "post") {
			$datos   = json_decode(file_get_contents('php://input'), true);
			$errores = array();
			$data  	 = array();

			$tmp = new Ingreso_model($datos["idingreso"]);
			$datoIngreso = $tmp->buscarIngresoGenerado();


			if($datoIngreso->estado == 1) {
				
				$errores[] = "No puede eliminar el item, el ingreso ya esta autorizado para descargar.";

			} else {
				
				if ($this->Ingreso_model->eliminarDetalleIngreso($datos["id"])) {
					$data['mensaje'] = "Item eliminado con éxito.";
				} else {
					$errores[] = "Error al eliminar el item.";
				}
			}
			
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
		
	}
}




/* End of file Ingreso.php */
/* Location: ./application/controllers/Ingreso.php */
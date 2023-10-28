<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Venta extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			"Buscar_model"
		]);

		$this->output->set_content_type("application/json");
	}
	public function index()
	{
		$this->output->set_status_header(403);
	}

	public function ganancia()
	{
		if ($this->input->method() === "post") {
			$datos = json_decode(file_get_contents('php://input'), true);
			$items = $this->Buscar_model->getGanancia($datos);
			$lista = [];

			if ($items) {
				$lista = $items;
			}

			$this->output->set_output(json_encode($lista));
		} else {
			$this->output->set_content_type("text/html");

			$this->load->view("header", ["datatable" => true]);
			$this->load->view("reporte/venta/ganancia/base");
			$this->load->view("footer", array(
				"scripts" => array(
					(object) array("ruta" => "assets/js/componentes.js", "print" => true),
					(object) array("ruta" => "assets/js/reporte/venta/ganancia/base.js", "print" => true)
				)
			));
		}
	}

	public function get_datos_ganancia()
	{
		$data = [
			"tipo"       => $this->Conf_model->getTipoArticulo(),
			"sub_tipo"   => $this->Conf_model->getDetalleTipoArticulo(),
			"venta_tipo" => $this->Conf_model->getVentaTipo()
		];

		$this->output->set_output(json_encode($data));
	}
}

/* End of file Venta.php */
/* Location: ./application/controllers/reporte/Venta.php */
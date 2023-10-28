<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articulo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			"Articulo_model"
		));

		$this->output->set_content_type("application/json");
	}

	public function index()
	{
		$this->output->set_content_type("text/html");

		$this->load->view("header");
		$this->load->view("mante/articulo/base");
		$this->load->view("footer", array(
			"scripts" => array(
				(object) array("ruta" => "assets/js/componentes.js", "print" => true),
				(object) array("ruta" => "assets/js/mante/articulo/base.js", "print" => true)
			)
		));
	}

	public function buscar()
	{
		if ($this->input->method() === "get") {

			$busca = [
				"_like" => []
			];

			if (verData($_GET, "codigo")) {
				$busca["_like"]["codigo"] = $_GET["codigo"];
			}

			if (verData($_GET, "descripcion")) {
				$busca["_like"]["descripcion"] = $_GET["descripcion"];
			}
			unset($_GET["codigo"]);
			unset($_GET["descripcion"]);

			$busca = array_merge($_GET, $busca);


			$tmp = $this->Articulo_model->buscar($busca);

			$lista = $tmp ? $tmp : array();

			$this->output->set_output(json_encode($tmp));
		} else {
			$this->output->set_status_header(405);
		}
	}

	public function guardar($id="")
	{
		if ($this->input->method() === "post") {

			$datos   = json_decode(file_get_contents('php://input'), true);
			$errores = array();
			$data    = array();
			
			if (verData($datos, "codigo") && 
				verData($datos, "descripcion") &&
				verData($datos, "precio")
			) {

				$busca = array(
					"codigo" => $datos["codigo"],
					"activo" => 1
				);

				if (!empty($id)) {
					$busca["id <>"] = $id;
				}

				$existe = $this->Articulo_model->buscar($busca);

				if (!$existe) {
					$tmp = new Articulo_model($id);

					if ($tmp->guardar($datos)) {
						if (empty($id)) {
							$data["reg"]     = $this->Articulo_model->buscar(array("id" => $tmp->getPK(), "_uno" => true));
							$data["mensaje"] = "Agregado con éxito.";
						} else {
							$data["mensaje"] = "Actualizado con éxito.";
						}
					} else {
						$errores[] = $tmp->getMensaje();
					}
				} else {
					$errores[] = "El código {$datos['codigo']} ya existe.";
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

	public function get_datos()
	{
		$data = [
			"tipo"     => $this->Conf_model->getTipoArticulo(),
			"sub_tipo" => $this->Conf_model->getDetalleTipoArticulo()
		];

		$this->output->set_output(json_encode($data));
	}
}

/* End of file Articulo.php */
/* Location: ./application/controllers/Articulo.php */
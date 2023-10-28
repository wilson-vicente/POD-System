<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venta_model extends Gen_model {

	public $fecha         = null;
	public $cantidad      = 0;
	public $total         = 0;
	public $efectivo      = 0;
	public $vuelto        = 0;
	public $venta_tipo_id = 1;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("venta");
		$this->setLlave("venta");

		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function guardarDetalle($args=[])
	{
		$id_venta = $this->getPK();
		
		foreach ($args as $key => $value) {

			$tmp = new Detalle_venta_model();
			
			$value["id_venta"]    = $id_venta;
			$value["id_articulo"] = $value["id"];

			$tmp->guardar($value);
		}
	}
}

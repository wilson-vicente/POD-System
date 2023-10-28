<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detalle_venta_model extends Gen_model {

	public $id_venta    = null;
	public $id_articulo = null;
	public $cantidad    = 0;
	public $precio      = 0;
	public $total       = 0;
	public $estatus     = 0;
	public $costo       = 0;


	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("detalle_venta");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}
	}
}

/* End of file Detalle_venta_model.php */
/* Location: ./application/models/Detalle_venta_model.php */
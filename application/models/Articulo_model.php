<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articulo_model extends Gen_model {

	public $codigo      = null;
	public $descripcion = null;
	public $costo       = 0;
	public $precio      = 0;
	public $activo      = 1;
	public $id_detalle_tipo_articulo = 0;
	public $id_tipo_articulo = 0;

	public function __construct($id="")
	{
		parent::__construct();
		$this->setTabla("articulo");
		$this->setLlave("id");

		if (!empty($id)) {
			$this->cargar($id);
		}
	}

	public function tipoArticulos($args = [])
	{
		if (isset($args["id"]) && $args["id"] > 0) {
			$this->db->where("id", $args["id"]);
		}

		$qry = $this->db 
					->select("id, descripcion")
					->from("tipo_articulo")
					->order_by("descripcion asc")
					->get();
					
		if (isset($args["id"]) && $args["id"] > 0) {
			return $qry->row();
		} else {
			return $qry->result();
		}
	}

	public function detalleTipoArticulo($args = [])
	{
		if (isset($args["id"]) && $args["id"] > 0) {
			$this->db->where("id", $args["id"]);
		}

		if (isset($args["id_tipo_articulo"]) && $args["id_tipo_articulo"] > 0) {
			$this->db->where("id_tipo_articulo", $args["id_tipo_articulo"]);
		}

		$qry = $this->db 
					->select("id, id_tipo_articulo, descripcion")
					->from("detalle_tipo_articulo")
					->order_by("descripcion asc")
					->get();

		if (isset($args["id_tipo_articulo"]) && $args["id_tipo_articulo"] > 0) {
			return $qry->result();
		} else {
			return null;
		}

	}

	public function buscarArticulo($args = [])
	{
		if (isset($args["codigo"]) && !empty($args["codigo"])) {
			$this->db->like("a.codigo", $args["codigo"]);
		}

		if (isset($args["descripcion"]) && !empty($args["descripcion"])) {
			$this->db->like("a.descripcion", $args["descripcion"]);
		}


		if (isset($args["id_tipo_articulo"]) && !empty($args["id_tipo_articulo"])) {
			$this->db->where("a.id_tipo_articulo", $args["id_tipo_articulo"]);
		}

		
		return $this->db
					->select("a.id, 
							a.codigo, 
							a.descripcion, 
							a.costo, 
							a.precio, 
							a.activo,
							a.id_tipo_articulo, 
							a.id_detalle_tipo_articulo, 
							b.descripcion as tipo, 
							c.descripcion as detalleTipo")
					->from("articulo a")
					->join("tipo_articulo b", "b.id = a.id_tipo_articulo", "left")
					->join("detalle_tipo_articulo c", "c.id = a.id_detalle_tipo_articulo", "left")
					->order_by("a.descripcion asc, b.descripcion asc, c.descripcion asc")
					->get()
					->result();
	}

}

/* End of file Articulo_model.php */
/* Location: ./application/models/Articulo_model.php */
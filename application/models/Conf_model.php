<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conf_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}
	
	private function getCatalogo($qry, $args)
	{
		if ($qry->num_rows() > 0) {
			return isset($args["_uno"]) ? $qry->row() : $qry->result();
		}

		return false;
	}

	public function getTipoArticulo($args=[])
	{
		$qry = $this->db
		->select("
			id,
			descripcion
		")
		->from("tipo_articulo")
		->order_by("descripcion")
		->get();

		return $this->getCatalogo($qry, $args);
	}

	public function getDetalleTipoArticulo($args=[])
	{
		if (verData($args, "tipo_articulo")) {
			$this->db->where("id_tipo_articulo", $args["tipo_articulo"]);
		}

		$qry = $this->db
		->select("
			id,
			id_tipo_articulo,
			descripcion
		")
		->from("detalle_tipo_articulo")
		->order_by("descripcion")
		->get();

		return $this->getCatalogo($qry, $args);
	}

	public function getVentaTipo($args=[])
	{
		$qry = $this->db
		->select("
			id,
			descripcion
		")
		->from("venta_tipo")
		->order_by("descripcion")
		->get();

		return $this->getCatalogo($qry, $args);
	}
}

/* End of file Conf_model.php */
/* Location: ./application/models/Conf_model.php */
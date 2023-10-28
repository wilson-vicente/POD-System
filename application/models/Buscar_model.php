<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buscar_model extends CI_Model {

	public function getGanancia($args=[])
	{
		if (verData($args, "fdel")) {
			$this->db->where("date(b.fecha) >=", $args["fdel"]);
		}

		if (verData($args, "fal")) {
			$this->db->where("date(b.fecha) <=", $args["fal"]);
		}

		if (verData($args, "articulo")) {
			$this->db->where("a.id_articulo", $args["articulo"]);
		}

		if (verData($args, "tipo")) {
			$this->db->where("d.id_tipo_articulo", $args["tipo"]);
		}

		if (verData($args, "sub_tipo")) {
			$this->db->where("d.id_detalle_tipo_articulo", $args["sub_tipo"]);
		}

		if (verData($args, "venta_tipo")) {
			$this->db->where("b.venta_tipo_id", $args["venta_tipo"]);
		}

		if (isset($args["modo"])) {
			if ($args["modo"] == 2) {
				$this->db->group_by("a.id_articulo");
			} else {
				$this->db->group_by("a.id");
			}
		} else {
			$this->db->group_by("a.id");
		}

		return $this->db
		->select("
			b.venta,
			b.fecha,
			c.descripcion as venta_tipo,
			d.descripcion as articulo,
			e.descripcion as tipo,
			f.descripcion as sub_tipo,
			b.venta_tipo_id,
			sum(ifnull(a.cantidad, 0)*ifnull(a.precio, 0)) as monto_venta,
			sum(ifnull(a.cantidad, 0)*ifnull(a.costo, 0)) as monto_costo,
			sum(ifnull(a.cantidad, 0)*ifnull(a.precio, 0) - ifnull(a.cantidad, 0)*ifnull(a.costo, 0)) as ganancia
		")
		->from("detalle_venta a")
		->join("venta b", "b.venta = a.id_venta")
		->join("venta_tipo c", "c.id = b.venta_tipo_id")
		->join("articulo d", "d.id = a.id_articulo")
		->join("tipo_articulo e", "e.id = d.id_tipo_articulo")
		->join("detalle_tipo_articulo f", "f.id = d.id_detalle_tipo_articulo")
		->get()
		->result();
	}
}

/* End of file Buscar_model.php */
/* Location: ./application/models/Buscar_model.php */
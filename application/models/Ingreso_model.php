<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingreso_model extends CI_Model
{
    protected $idIngreso = 0;
    protected $mensaje = "";

    public function getMensaje()
	{
		return $this->mensaje;
	}
	
	public function setMensaje($mensaje)
	{
		$this->mensaje .= $mensaje;
		return $this;
	}

    public function __construct($id="")
    {
    	
    	parent::__construct();
    	
    	if(!empty($id)) {
    		$this->cargar($id);
    	}
    }

    public function cargar($id='')
    {
    	$this->idIngreso = $this->db
    					->select("id")
    					->from("ingreso")
    					->where("id", $id)
    					->get()
    					->row();
    }


    public function guardarIngreso()
    {
    	$data = array(
    		'estado' => 0
    	);

    	$this->db->insert("ingreso", $data);

    	if ($this->db->affected_rows() > 0) {
    		$this->cargar($this->db->insert_id());
    		return true; 
    	} else {
    		$this->setMensaje("No puede generar el ingreso, por favor intente nuevamente.");
    		return false; 
    	}
    	
    }

	public function cantidadIngresosAbiertos()
	{
		$query = $this->db
						->select("count(*) as cantidad")
						->from("ingreso")
						->where("estado", 0)
						->where("date(fecha) = date(now())")
						->get()
						->row();

		if ($query->cantidad > 0 ) {
			return false;
		} else {
			return true; 
		}
		
	}

	public function buscarIngresoGenerado()
	{
    	return $this->db
    				->select("id, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha, estado")
    				->from("ingreso")
    				->where("id", $this->idIngreso->id)
    				->get()
    				->row();

	}


	public function actualizarIngresoGenerado($args = [])
	{
		if (isset($args["id"]) && !empty($args["id"])) {

			 $data = array(
            	'estado' => $args["estado"]
        	);

			$this->db->where("id", $args["id"]);
			$this->db->update("ingreso", $data);

			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				$this->setMensaje("No puede actualizar el ingreso, por favor intente nuevamente.");
				return false;
			}
		}
	}

	public function buscarIngreso($args = [])
	{
		if (isset($args["id"]) && !empty($args["id"])) {
			$this->db->where("id", $args["id"]);
		}

		if ((isset($args["del"]) && !empty($args["del"])) && (isset($args["al"]) && !empty($args["al"]))) {
			$this->db->where("date(fecha) >=", $args["del"]);
			$this->db->where("date(fecha) <=", $args["al"]);
		}



		return $this->db
    				->select("id, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha, estado")
    				->from("ingreso")
    				->order_by("fecha DESC")
    				->get()
    				->result();
	}

	public function agregarDetalleIngeso($args = [])
	{
    	$this->db->insert("detalle_ingreso", $args);

    	if ($this->db->affected_rows() > 0) {
    		return true; 
    	} else {
    		$this->setMensaje("No puede generar el detalle del ingreso, por favor intente nuevamente.");
    		return false; 
    	}
	}

	public function obtenerDetalleIngreso($idIngreso)
	{

		if (!empty($idIngreso) && $idIngreso > 0) {
			$this->db->where("a.id_ingreso", $idIngreso);
		}

		return $this->db
					->select("a.id, a.id_ingreso, a.id_articulo, c.descripcion, a.fecha_vencimiento, a.cantidad, a.estado, a.codigo")
					->from("detalle_ingreso a")
					->join("ingreso b", "b.id = a.id_ingreso")
					->join("articulo c", "c.id = a.id_articulo")
					->get()
					->result();

	}


	public function eliminarDetalleIngreso($id)
	{
		if(!empty($id) && $id > 0) {

			$this->db->where("id", $id);
			$this->db->delete("detalle_ingreso");

			return true;
		} 

		return false;
	}


	public function actualizarDetalleIngreso($args = [])
	{
		if (isset($args["idDetalleIngreso"]) && !empty($args["idDetalleIngreso"])) {

			 $data = array(
            	'id_articulo' 		=> $args["id_articulo"],
            	'fecha_vencimiento' => $args["fecha_vencimiento"],
            	'cantidad' 			=> $args["cantidad"],
            	'codigo' 			=> $args["codigo"]
        	);

			$this->db->where("id", $args["idDetalleIngreso"]);
			$this->db->update("detalle_ingreso", $data);

			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				$this->setMensaje("No puede actualizar el detalle, por favor intente nuevamente.");
				return false;
			}
		}
	}

}

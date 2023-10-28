<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fpalabra
{
	protected $ci;
	protected $cls;
	protected $reg;
	protected $datos;
	protected $action;

	public function __construct()
	{
		$this->ci    =& get_instance();
		$this->cls   = "form-control form-control-sm";
		$this->datos = array();
	}

	public function setAction($val)
	{
		$this->action = $val;
	}

	public function setReg($val)
	{
		$this->reg = $val;
	}

	private function label($idnom, $titulo, $col=2)
	{
		$this->datos["lab_{$idnom}"] = form_label(
			$titulo,
			"",
			array("class" => "col-form-label-sm", "for" => $idnom)
		);

		return $this->datos;
	}

	private function form()
	{
		$this->datos["form"] = form_open(
			$this->action,
			array(
				"id"           => "formGuardaPalabra",
				"class"        => "form-horizontal",
				"onsubmit"     => "return formGuardar(this);",
				"autocomplete" => "off"
			)
		);

		$this->datos["submit"] = form_button(
			array(
				"id"    => "btnGuardaPalabra",
				"class" => "btn btn-sm btn-info btn-block",
				"type"  => "submit"

			),
			"<span class='oi oi-plus'></span> Agregar"
		);

		$this->datos["form_cierre"] = form_close();
	}

	private function letra()
	{
		$idnom = "letra";

		$this->label($idnom, "<span class='oi oi-tag'></span> Letra");

		$this->datos["inp_{$idnom}"] = form_input(
			array(
				"id"    => $idnom,
				"name"  => $idnom,
				"class" => $this->cls
			),
			($this->reg) ? $this->reg->$idnom : ""
		);
	}

	private function nombre()
	{
		$idnom = "nombre";

		$this->label($idnom, "<span class='oi oi-flag'></span> Palabra");

		$this->datos["inp_{$idnom}"] = form_input(
			array(
				"id"    => $idnom,
				"name"  => $idnom,
				"class" => $this->cls
			),
			($this->reg) ? $this->reg->$idnom : ""
		);
	}

	private function descripcion()
	{
		$idnom = "descripcion";

		$this->label($idnom, "<span class='oi oi-comment-square'></span> Descripción");

		$this->datos["inp_{$idnom}"] = form_textarea(
			array(
				"id"    => $idnom,
				"name"  => $idnom,
				"class" => $this->cls,
				"rows" 	=> 5
			),
			($this->reg) ? $this->reg->$idnom : ""
		);
	}

	public function getForm()
	{
		$this->form();
		$this->letra();
		$this->nombre();
		$this->descripcion();

		return $this->datos;
	}

}

/* End of file Fpalabra.php */
/* Location: ./application/libraries/forms/Fpalabra.php */

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asistente
{
	public $ci;
	public $reg;
	protected $action;
	protected $datos;

	public function __construct()
	{
		$this->ci     =& get_instance();
		$this->datos  = array();
		$this->action = null;
	}

	public function set_action($val)
	{
		$this->action = $val;
	}

	private function label($idnom, $titulo, $col)
	{
		$lab = form_label(
			$titulo,
			"",
			array("class" => "col-sm-{$col} col-form-label col-form-label-sm", "for" => $idnom)
		);

		return $lab;
	}

	private function merge_extra($args, $extra)
	{	
		if (is_array($extra)&& !empty($extra)) {
			$args = array_merge($args, $extra);
		}

		return $args;
	}

	public function set_form($args=[])
	{
		if ($this->action === null && isset($args["action"])) {
			$this->set_action($args["action"]);
		}
		$attr = array(
			"id"    => "formGuardar",
			"class" => "form-horizontal"
		);

		if (isset($args["id"])) {
			$attr["id"] = $args["id"];
		}

		if (isset($args["cls"])) {
			$attr["class"] = $args["cls"];
		}

		if (isset($args["extra"])) {
			$attr = $this->merge_extra($attr, $args["extra"]);
		}

		$this->datos["frm_ini"] = form_open(
			$this->action,
			$attr
		);

		$this->datos["frm_fin"]  = form_close();
	}

	public function set_button($args=[])
	{
		$content = "Guardar";

		$attr = array(
			"id"    => "btnFormGuardar",
			"class" => "btn btn-primary",
			"type"  => "submit"
		);

		if (isset($args["id"])) {
			$attr["id"] = $args["id"];
		}

		if (isset($args["cls"])) {
			$attr["class"] = $args["cls"];
		}

		if (isset($args["cnt"])) {

			$cnt = $args["cnt"]["txt"];

			if (isset($args["cnt"]["icon"])) {
				$cnt = "<span class='".$args["cnt"]["icon"]."'></span> ". $cnt;
			}

			$content = $cnt;
		}

		if (isset($args["extra"])) {
			$attr = $this->merge_extra($attr, $args["extra"]);
		}

		$this->datos["btn_{$args['nom']}"] = form_button(
			$attr,
			$content
		);
	}

	public function set_inp($args=[])
	{
		$attr = array(
			"id"    => $args["idnom"],
			"name"  => $args["idnom"],
			"class" => "form-control"
		);

		if (isset($args["id"])) {
			$attr["id"] = $args["id"];
		}

		if (isset($args["extra"])) {
			$attr = $this->merge_extra($attr, $args["extra"]);
		}

		$col = (isset($args["col"])) ? $args["col"] : 4;

		$inp = "<div class='form-group row'>";
			if (isset($args["lab"])) {
				$inp.= $this->label($args["idnom"], $args["lab"]["txt"], $args["lab"]["col"]);
			}

			$inp.= "<div class='col-sm-{$col}'>";
				$inp.= form_input(
					$attr,
					($this->reg) ? $this->reg->$args["idnom"] : ""
				);
			$inp.= "</div>";
		$inp.= "</div>";

		$this->datos["inp_{$args['idnom']}"] = $inp;
	}

}

/* End of file Asistente.php */
/* Location: ./application/libraries/Asistente.php */

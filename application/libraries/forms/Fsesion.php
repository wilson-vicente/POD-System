<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fsesion extends Asistente
{
	public function getForm()
	{
		$this->set_form(array(
			"action" => base_url("index.php/principal/iniciar"),
			"extra" => [
				"autocomplete" => "off",
				"onsubmit"     => "return formGuardar(this)"
			]
		));

		$this->set_inp([
			"idnom" => "correo",
			"lab"   => [
				"txt" => "Correo",
				"col" => 2
			],
			"extra" => [
				"required" => "required"
			]
		]);

		$this->set_inp([
			"idnom" => "contrasenia",
			"lab" => [
				"txt" => "Contraseña",
				"col" => 2
			],
			"extra" => [
				"type"     => "password",
				"required" => "required"
			]
		]);
		//<span class="oi oi-account-login"></span>

		$this->set_button([
			"nom" => "sub",
			"cls" => "btn btn-sm btn-dark",
			"cnt" => [
				"txt"  => "Ingresar",
				"icon" => "oi oi-account-login"
			]
		]);

		$this->set_button([
			"nom" => "new",
			"cls" => "btn btn-sm btn-secondary",
			"cnt" => [
				"txt"  => "Crear Cuenta",
				"icon" => "oi oi-pencil"
			],
			"extra" => [
				"type"    => "button",
				"onclick" => "crearUsuario()",
				"id"      => "btnGeneraUsuario"
			]
		]);

		return $this->datos;
	}
}

/* End of file Fsesion.php */
/* Location: ./application/libraries/Fsesion.php */

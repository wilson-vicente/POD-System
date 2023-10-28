<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fusuario extends Asistente
{
	public function getForm()
	{
		$this->set_form(array(
			"action" => base_url(),
			"extra" => [
				"autocomplete" => "off",
				"onsubmit"     => "return formGuardar(this)"
			]
		));

		$this->set_inp([
			"idnom" => "primer_nombre",
			"lab" => [
				"txt" => "Primer Nombre",
				"col" => 2
			],
			"extra" => [
				"required" => "required"
			]
		]);

		$this->set_inp([
			"idnom" => "segundo_nombre",
			"lab" => [
				"txt" => "Segundo Nombre",
				"col" => 2
			]
		]);

		$this->set_inp([
			"idnom" => "primer_apellido",
			"lab" => [
				"txt" => "Primer Apellido",
				"col" => 2
			],
			"extra" => [
				"required" => "required"
			]
		]);

		$this->set_inp([
			"idnom" => "segundo_apellido",
			"lab" =>[
				"txt" => "Segundo Apellido",
				"col" => 2
			]
		]);

		$this->set_inp([
			"idnom" => "correo",
			"lab" => [
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
				"required" => "required",
				"onkeyup"  => "tamanioContrasenia(this)"
			]
		]);

		$this->set_inp([
			"idnom" => "confirma",
			"lab" => [
				"txt" => "Confirme contraseña",
				"col" => 2
			],
			"extra" => [
				"type"     => "password",
				"required" => "required"
			]
		]);

		$this->set_button([
			"nom" => "sub",
			"cls" => "btn btn-sm btn-dark",
			"cnt" => [
				"txt"  => "Crear"
			]
		]);

		$this->set_button([
			"nom" => "ing",
			"cls" => "btn btn-sm btn-secondary",
			"cnt" => [
				"txt"  => "Ingresar",
				"icon" => "oi oi-account-login",
			],
			"extra" => [
				"type"    => "button",
				"onclick" => "login()",
				"id"      => "btnLogin"
			]
		]);

		return $this->datos;
	}
}

/* End of file Fusuario.php */
/* Location: ./application/libraries/forms/Fusuario.php */

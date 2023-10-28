<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function test()
	{
		$array1 = array(
			(object) array("uno"  => 1),
			(object) array("dos"  => 2)
		);

		$array2 = array(
			(object) array("dos" => 2),
			(object) array("uno" => 1),
			(object) array("tres" => 3)
		);

		$res = array_unique (array_merge ($array1, $array2));

		echo "<pre>";
		print_r ($res);
		echo "</pre>";
	}
}

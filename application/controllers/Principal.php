<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->datos = array();
	}

	public function index()
	{
		$this->load->view("header");
		$this->load->view("base");
		$this->load->view("footer");
	}

	public function about()
	{
		$this->load->view("extra/about", $this->datos);
	}
}

/* End of file Principal.php */
/* Location: ./application/controllers/Principal.php */
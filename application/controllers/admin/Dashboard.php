<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('auth');

		if (!isAdminLoggedIn()) {
			redirect('admin/login');
		}
	}
	
	public function index()
	{
		$this->load->view('admin/dashboard/index');
	}
}

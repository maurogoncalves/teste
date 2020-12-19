<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	
	function __construct(){
	   parent::__construct();
	   $this->load->library('session');
	   $this->load->library('form_validation');
	   $this->load->helper('url');	 
		
	}
	public function index()
	{
		 redirect('Admin/listar', 'refresh');
	}
	
	

}

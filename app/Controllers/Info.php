<?php 
namespace App\Controllers;

class Info extends BaseController
{
	public function __construct(){
		$this->db = \Config\Database::connect();
	}
	public function index()
	{
		
		return phpinfo();
	}
	
}

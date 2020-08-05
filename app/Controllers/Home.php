<?php 
namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		
		$data = [
			'title' => 'halaman depan'
		];
		return view('welcome_message',$data);
	}

	//--------------------------------------------------------------------

}

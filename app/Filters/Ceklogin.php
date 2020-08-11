<?php 
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Ceklogin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
		// Do something here
		$session = session();
		if(!$session->get('login')){
			return redirect()->to(base_url().'/login');
		}
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
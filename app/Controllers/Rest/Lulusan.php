<?php namespace App\Controllers\Rest;
 
use CodeIgniter\RESTful\ResourceController;
 
class Lulusan extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\Rest\Lulusan_model';
 
    public function index()
    {
        return $this->respond($this->model->findAll(), 200);
    }
}
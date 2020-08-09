<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Models\Msiakad_setting;
use App\Models\Msiakad_prodi;
use App\Models\Msiakad_mahasiswa;
use App\Models\Msiakad_matakuliah;
use App\Models\Msiakad_kurikulum;
use App\Models\Msiakad_kurikulummatakuliah;

use App\Models\Msiakad_riwayatpendidikan;
use App\Models\Mfeeder_akun;
use App\Models\Mfungsi;
use App\Models\Mreferensi;
use App\Models\Mdictionary;
use App\Models\Mfeeder_ws;
use App\Models\Mfeeder_data;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form','url'];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		
		//$this->session 		= \Config\Services::session();
		$this->db      		= \Config\Database::connect();
		$this->msiakad_setting = new Msiakad_setting();
		$this->msiakad_prodi = new Msiakad_prodi();
		$this->msiakad_mahasiswa = new Msiakad_mahasiswa();
		$this->msiakad_matakuliah = new Msiakad_matakuliah();
		$this->msiakad_kurikulum = new Msiakad_kurikulum();
		$this->msiakad_kurikulummatakuliah = new Msiakad_kurikulummatakuliah();
		$this->msiakad_riwayatpendidikan = new Msiakad_riwayatpendidikan();		
		
		$this->mfeeder_akun = new Mfeeder_akun();
		$this->mfeeder_ws	= new Mfeeder_ws();
		$this->mfeeder_data	= new Mfeeder_data();
		$this->mfungsi 		= new Mfungsi();
		$this->mreferensi 	= new Mreferensi();
		$this->mdictionary 	= new Mdictionary();
		
		$this->pengembang 	= "Idik Nursidik";
	}

}

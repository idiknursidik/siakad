<?php 
namespace App\Models;
use CodeIgniter\Model;
 
class Mfungsi extends Model
{
	function object_to_array($data){
		if (is_array($data) || is_object($data)){
			$result = array();
			foreach ($data as $key => $value){
				$result[$key] = $this->object_to_array($value);
			}
			return $result;
		}
		return $data;
	}
	static public function array_to_object(array $array){
		foreach($array as $key => $value)
		{
			if(is_array($value))
			{
				$array[$key] = self::array_to_object($value);
			}
		}
		return (object)$array;
	}
	
	function jenis_semester($val=false){
		$data = array("1"=>"Ganjil","2"=>"Genap");
		if($val){
			$ret = $data[$val];
		}else{
			$ret = $data;
		}
		return $ret;
	}
	function jalur_pendaftaran($val=false){
		$data = array("1"=>"Umum","2"=>"Beasiswa");
		if($val){
			$ret = $data[$val];
		}else{
			$ret = $data;
		}
		return $ret;
	}
	function kelas_pendaftaran($val=false){
		$data = array("reguler"=>"Reguler","karyawan"=>"Karyawan");
		if($val){
			$ret = $data[$val];
		}else{
			$ret = $data;
		}
		return $ret;
	}
	function jenis_kelamin($val=false){
		$data = array("L"=>"Laki - laki","P"=>"Perempuan");
		if($val){
			$ret = $data[$val];
		}else{
			$ret = $data;
		}
		return $ret;
	}
	
	function kewarganegaraan($val=false){
		$data = array("WNI"=>"Warga Negara Indonesia","WNA"=>"Warga Negara Asing");
		if($val){
			$ret = $data[$val];
		}else{
			$ret = $data;
		}
		return $ret;
	}
	function pend_terakhir($val=false){
		$data = array("SMA"=>"Sekolah Menengah Atas (SMA)","SMK"=>"Sekolah Menegah Kejuruan (SMK)","MA"=>"Madrasah Aliah");
		if($val){
			$ret = $data[$val];
		}else{
			$ret = $data;
		}
		return $ret;
	}
}

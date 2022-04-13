<?php
namespace App\Validation;


class OtherRules
{
	public function cekduplicatakm(string $str, string $fields, array $data)
	{
		$db      = \Config\Database::connect();
		$builder = $db->table('siakad_akm');
		$builder->where("nim",$data['nim']);
		$builder->where("id_semester",$data['id_semester']);
		$query = $builder->get();
		if($query->getRowArray() > 0){
			return false;
		} else {
			return TRUE;
		}
	}
}										

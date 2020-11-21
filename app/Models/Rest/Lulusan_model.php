<?php
 
namespace App\Models\Rest;
 
use CodeIgniter\Model;
 
class Lulusan_model extends Model {
 
    protected $table = 'siakad_lulusan';
 
    public function getLulusan($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere(['id_keluar' => $id])->getRowArray();
        }  
    }
     
    public function insertLulusan($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateLulusan($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['category_id' => $id]);
    }
 
    public function deleteLulusan($id)
    {
        return $this->db->table($this->table)->delete(['category_id' => $id]);
    }
} 
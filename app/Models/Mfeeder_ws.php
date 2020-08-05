<?php 
namespace App\Models;
use CodeIgniter\Model;

class Mfeeder_ws extends Model
{
		
   public function runWS($data,$type='json',$url=false){
		//global $url;
		if(!$url){
			$session 	= \Config\Services::session();
			$feeder_akun = $session->get("feeder_akun");
			if($feeder_akun){
				$url = $feeder_akun->url;
			}
		}
		$url = $url."/ws/live2.php";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		$headers = array();
		if ($type == 'xml'){
			$headers[] = 'Content-Type: application/xml';			
		}else{
			$headers[] = 'Content-Type: application/json';				
		}
		
		//echo $url;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		if ($data){
			if ($type == 'xml'){
				/* contoh xml:
				<?xml
				version="1.0"?><data><act>GetToken</act><username>agus</username><passwo
				rd>abcdef</password></data>
				*/
				$data = $this->stringXML($data);
			}else{
				/* contoh json:
				{"act":"GetToken","username":"agus","password":"abcdef"}
				*/
				$data = json_encode($data);
			}				
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
			//var_dump($result);
			//echo $result;
			//print_r($result);
		return $result;	
	}
	
	function stringXML($data){
		$xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
		$this->array_to_xml($data, $xml);
		return $xml->asXML();
	}
	
	function array_to_xml( $data, &$xml_data ){		
		foreach($data as $key => $value){
			if(is_array($value)){
				$subnode = $xml_data->addChild($key);
				$this->array_to_xml($value, $subnode);
			}else{
				//$xml_data->addChild("$key",htmlspecialchars("$value"));
				$xml_data->addChild("$key",$value);
			}
		}
	}
	
	function token($username, $password){		
		$type = 'json'; 
		$data = array('act'=>'GetToken', 'username'=>$username,'password'=>$password);
		$tokenn = $this->runWS($data, $type);
		return 	$tokenn; 	
	}
	
	function getdictionary($token,$act,$fungsi) {
	   $data = array('act'=>$act,'token'=>$token,'fungsi'=>$fungsi);
	   $ret = $this->runWS($data);
	   return json_decode($ret);
	}
	
	function getrecord($token, $table, $filter=false, $ctype='JSON') {
	   $ret = $this->runWS(array('token'=>$token, 'act'=>$table, 'filter'=>$filter),$ctype);
	   return json_decode($ret);
	}	

	function getrecordset($token, $table, $filter=false, $order=false, $limit=false, $offset=false, $ctype='JSON') {
		$ret = $this->runWS(array('token'=>$token,'act'=>$table, 'filter'=>$filter, 'order'=>$order, 'limit'=>$limit, 'offset'=>$offset),$ctype);
		return json_decode($ret);
	}
   
 
	function insertws($token, $table, $records, $ctype='JSON') {
	   return $this->runWS(array('token'=>$token, 'act'=>$table, 'record'=>$records),$ctype);
	}
   
	function updatews($token,$table,$records,$key,$ctype='JSON') {
	   return $this->runWS(array('token'=>$token, 'act'=>$table, 'key'=>$key,'record'=>$records),$ctype);
	}
	function deletews($token,$table,$key,$ctype='JSON') {
	   return $this->runWS(array('token'=>$token, 'act'=>$table,'key'=>$key),$ctype);
	}
	
	
	public function cekkoneksifeeder(){
		$session 		= \Config\Services::session();
		$feeder_akun = $session->get("feeder_akun");
		$dataws = array('act'=>'GetToken','username'=>$feeder_akun->username,'password'=>$feeder_akun->password);
		$returnws = $this->runWS($dataws,false,$feeder_akun->url);
		$returnws = json_decode($returnws);
		if($returnws->error_code != 0){
			return $returnws->error_desc;			
		}else{
			return FALSE;
		}
	}
}

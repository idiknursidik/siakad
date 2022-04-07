<?php 
namespace App\Models;
use CodeIgniter\Model;

class Msiakad_mail extends Model
{
	
	function __construct()
    {
		parent::__construct();
		$this->mfeeder_data	= new Mfeeder_data();
    }
	
	protected $setting_mail = 'setting_mail';
	
	public function getprofile(){
		$kodept = $this->getdata();
		$retkodept = ($kodept)?$kodept->kodept:'0000'; 
		$data = $this->mfeeder_data->getprofilept(false,$retkodept);
		if($data){
			return $data;
		}else{
			return FALSE;
		}
	}
	
	public function getmailsetting(){
		$builder = $this->db->table($this->setting_mail);
		$query = $builder->get();
		if($query->getRowArray() > 0){
			$data = $query->getResultObject();
			$ret = $data[0];
			return $ret;
		}else{
			return FALSE;
		}	
	}
	public function loademailconfig(){
		$email = \Config\Services::email();
		$mailsetting = $this->getmailsetting();
				
		$config['protocol'] = 'smtp';
		$config['SMTPHost'] = $mailsetting->smtp_host;
		$config['SMTPPort'] = $mailsetting->smtp_port;
		$config['SMTPUser'] = $mailsetting->smtp_user;
		$config['SMTPPass'] = $mailsetting->smtp_pass;
		$config['SMTPCrypto'] = $mailsetting->encryption;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['newline'] = "\r\n";
		$config['wordwrap'] = TRUE;
		$config['SMTPTimeout'] = 30;
		$email->initialize($config);

	}
	public function sendmailcoice($from,$to,$content='None',$subjectinfo='Test mail'){
		$email = \Config\Services::email();
		
		$this->loademailconfig();
		
		$email->clear();
		$email->setFrom($from, 'Siakad+');
		$email->setTo($to);

		$email->setSubject($subjectinfo);
		$email->setMessage($content);
		if (!$email->send()) {
			return $email->printDebugger(['headers']); 
		}else{
			return  "sukses send mail";
		}
	}
}

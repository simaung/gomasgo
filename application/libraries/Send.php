<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Send {
	
	var $url = "https://reguler.zenziva.net/apps/smsapi.php?userkey=bxf0y9&passkey=tabstech15";

	function sms($no_tujuan,$isi_pesan) 
	{	
		$ci =& get_instance();
		$ci->load->library("curl");
		
		$uri		= $this->url."&nohp=".$no_tujuan."&pesan=".urlencode($isi_pesan);
		
		$result 	= $ci->curl->get($uri, $uri);
		
		return $result;
	}
	
	function email($to, $subject, $message) {

		$CI =& get_instance();
		$CI->load->library('PHPMailerAutoload');
		
		$mail = new PHPMailer();
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->SMTPSecure = $CI->config->item('smtp_secure');
        $mail->Host       = $CI->config->item('smtp_host'); // setting host as our SMTP server
        $mail->Port       = $CI->config->item('smtp_port'); // SMTP port to connect
        $mail->Username   = $CI->config->item('smtp_user');  // user smtp account
        $mail->Password   = $CI->config->item('smtp_pass');  // password smtp account
        $mail->SetFrom("azkiatour@yahoo.com", "ONLINE TRAVEL AGENT");  //Who is sending the email
        $mail->Subject    = $subject;
        $mail->Body       = $message;
		//$mail->addAttachment('uploads/file.tar.gz');
        $mail->isHTML(true); // Set email format to HTML
        
		$listTo = explode(",",$to);
		for($a=0;$a<count($listTo);$a++):
			$mail->AddAddress($listTo[$a]);
		endfor;
		
        if(!$mail->Send()) {
            $result['rest_no'] 	= "1";
			$result['reason'] 	= "Error: " . $mail->ErrorInfo;
        } else {
            $result['rest_no'] 	= "0";
			$result['reason'] 	= "sukses";
        }

        return $result;
	}

	function emailAttach($to, $subject, $message, $path, $sender_name, $return_address, $auto_send = '1') {
		
		$CI =& get_instance();
		$CI->load->library('PHPMailerAutoload');
		
		$mail = new PHPMailer();
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->SMTPSecure = $CI->config->item('smtp_secure');
        $mail->Host       = $CI->config->item('smtp_host'); // setting host as our SMTP server
        $mail->Port       = $CI->config->item('smtp_port'); // SMTP port to connect
        $mail->Username   = $CI->config->item('smtp_user');  // user smtp account
        $mail->Password   = $CI->config->item('smtp_pass');  // password smtp account
        $mail->SetFrom("azkiatour@yahoo.com", "ONLINE TRAVEL AGENT");  //Who is sending the email
        $mail->Subject    = $subject;
        $mail->Body       = $message;
		$mail->addAttachment($path['pdf']);
        $mail->isHTML(true); // Set email format to HTML               
		//$mail->AddBCC("jackntc@gmail.com", "Didin");
        
		$listTo = explode(",",$to);
		for($a=0;$a<count($listTo);$a++):
			$mail->AddAddress($listTo[$a]);
		endfor;
		
        if(!$mail->Send()) {
            $result['rest_no'] 	= "1";
			$result['reason'] 	= "Error: " . $mail->ErrorInfo;
        } else {
            $result['rest_no'] 	= "0";
			$result['reason'] 	= "sukses";
			unlink($path['pdf']);
        }

        return $result;
	}
}
		
?>

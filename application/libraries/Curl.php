<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Curl {
	
	var $headers;
	var $user_agent;
	var $compression;
	var $cookie_file;
	var $proxy;
	var $proxy1="";
	var $cookies;

	function cURL($cookies=TRUE,$cookie='cookie/cookie.txt',$compression='gzip',$proxy='') 
	{
		$this->headers[] = 'Accept: text/html,application/xhtml+xml,application/xml';
		$this->headers[] = 'Connection: Keep-Alive';
		#$this->headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
		$this->user_agent = 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:55.0) Gecko/20100101 Firefox/55.0';
		#Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13
		$this->compression=$compression;
		$this->proxy=$proxy;
		$this->cookies=$cookies;
	}
	
	function get($url,$url2,$cookie) 
	{	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_REFERER, $url2);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt($ch,CURLOPT_ENCODING , $this->compression);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, '300');
		curl_setopt($ch, CURLOPT_TIMEOUT, 300);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		if ($this->proxy) curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		
		if($result === false)
		{
			$resultData['rest_no']		= curl_errno($ch);
			$resultData['reason']	= curl_error($ch);
		}
		else
		{
			$resultData['rest_no']		= "0";
			$resultData['result']		= $result;
		}
		
		return $resultData;
		curl_close($ch);
	}
		
	function post($url,$url2,$data,$cookie) 
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($ch, CURLOPT_REFERER, $url2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_ENCODING , $this->compression);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, '300');
		curl_setopt($ch, CURLOPT_TIMEOUT , '300' );
		curl_setopt($ch, CURLOPT_MAXREDIRS , '3' );
		//curl_setopt($ch, CURLOPT_FAILONERROR,true);
		
		//for windows
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt($ch, CURLOPT_COOKIESESSION, false);
		 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		if ($this->proxy) curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		$result = curl_exec($ch);
		
		if($result === false)
		{
			$resultData['rest_no']		= curl_errno($ch);
			$resultData['reason']	= curl_error($ch);
		}
		else
		{
			$resultData['rest_no']		= "0";
			$resultData['result']		= $result;
		}
		
		return $resultData;
		curl_close($ch);
	}
}
		
?>

<?php
/*
 * Util class
 * 
 * @author Felipe Volpatto	Feb 17, 2015
 */

class util {
	public static function fileNotFound() {
		echo 'File not found!';
	}
	
	/**
	test ip: 129.82.192.154 (my local's ip)
	test ip: 10.84
	**/
	public static function isIpValid() {
		$ip = $_SERVER['REMOTE_ADDR'];
		
		if ($ip == "::1") return true;
		
		$ipValues = explode('.', $ip);
		
		return (($ipValues[0] == 129 && $ipValues[1] == 82) 
				|| ($ipValues[0] == 10 && $ipValues[1] == 84));
	}
	
	public static function sanitizeData($data) {
		return strip_tags($data);
	}
	
	public static function createUsername($name) {
		$name = preg_replace('/\s*/', '', $name);
		$name = strtolower($name);	
		return $name;	
		
	}
}

?>
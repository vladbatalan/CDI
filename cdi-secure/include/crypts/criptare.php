<?php
	
	define("SALT", md5("xaxofon"));
	define("_KEY", md5("xaxofon"));
	
	function randomstrng($length)
	{
		$chars = "abcdefghijkmnopqrstuvwxyz0123456789";
		srand((double)microtime()*1000000);
		$str = "";
		$i = 0;
		while($i <= $length){
			$num = rand() % strlen($chars);
			$tmp = substr($chars, $num, 1);
			$str = $str . $tmp;
			$i++;
		}
		return $str;
	}

	function generate_new_salt()
	{
		$salt = md5(randomstrng(10));
		return $salt;
	}

	function encrypt($string, $key)
	{
		$string = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB)));
		return $string;
	}
	
	function decrypt($string, $key)
	{
		$string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($string), MCRYPT_MODE_ECB));
		return $string;
	}
	
	function hashword($string, $salt)
	{
		$string = crypt($string, '$1$'.$salt.'$');
		return $string;
	}
?>
<?php
	function verifica($string)
	{
		$string = htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
		return $string;
	}
?>
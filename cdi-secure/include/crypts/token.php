<?php
	class Token{
		public static function generate()
		{
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+=-";
			$token = '';
			for($i = 1; $i<=32; $i++)
			{
				$index = rand() % strlen($chars);
				$token .= $chars[$index];
			}
			return $_SESSION['token'] = $token;
		}

		public static function check($token)
		{
			if(isset($_SESSION['token']) && $token === $_SESSION['token'])
			{
				unset($_SESSION['token']);
				return true;
			}
			return false;
		}

	};


?>
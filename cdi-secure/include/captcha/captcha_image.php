<?php
	session_start();
	header("Content-Type: image/png");
	$im = @imagecreatefromjpeg('bk_for_captcha.jpg')
		or die("Cannot Initialize new GD image stream");
	
	function randomString($length)
	{
		$chars = "abcdefghijkmnopqrstuvwxyz123456789";
		srand((double)microtime()*1000000);
		$str = "";
		$i = 0;
		
			while($i <= $length){
				$num = rand() % 33;
				$tmp = substr($chars, $num, 1);
				$str = $str . $tmp;
				$i++;
			}
		return $str;
	}
	
	function imagettftextSp($image, $size, $angle, $x, $y, $color, $font, $text, $spacing = 0)
	{        
		if ($spacing == 0)
		{
			imagettftext($image, $size, $angle, $x, $y, $color, $font, $text);
		}
		else
		{
			$temp_x = $x;
			for ($i = 0; $i < strlen($text); $i++)
			{
				$bbox = imagettftext($image, $size, $angle, $temp_x, $y, $color, $font, $text[$i]);
				$temp_x += $spacing + ($bbox[2] - $bbox[0]);
			}
		}
	}
		
	$white = imagecolorallocate($im, 255, 255, 255);
	$black = imagecolorallocate($im, 0, 0, 0);
	$grey = imagecolorallocate($im,150,150,150);
	$red = imagecolorallocate($im, 255, 0, 0);
	$pink = imagecolorallocate($im, 200, 0, 150);
	$text_color = imagecolorallocate($im, 233, 14, 91);
	
	$angle = rand(0,10);
	$string = randomString(rand(4, 6));
	$spacing = rand(0, 7);
	$_SESSION['captcha_response'] = $string;
	
	imagettftextSp($im, 25, $angle, 30, 53, $white, "augie.ttf", $string, $spacing);
	imagettftextSp($im, 25, $angle, 30, 50, $black, "augie.ttf", $string, $spacing);
	imagepng($im);
	imagedestroy($im);	
?>	
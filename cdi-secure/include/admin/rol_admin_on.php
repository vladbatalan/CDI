<?php
	if(!isset($_SESSION['login']) || ($_SESSION['login']['rol'] != 'admin' && $_SESSION['login']['rol'] != 'admin_suprem'))
	{
		header("location: ../index.php");
	}

?>
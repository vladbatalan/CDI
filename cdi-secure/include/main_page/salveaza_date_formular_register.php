<?php 
	$r_nume = "";
	$r_prenume = "";
	$r_username = "";
	$r_clasa = "";

	if(isset($_POST['nume']))
		$r_nume = verifica($_POST['nume']);
	if(isset($_POST['prenume']))
		$r_prenume = verifica($_POST['prenume']);
	if(isset($_POST['username']))
		$r_username = verifica($_POST['username']);
	if(isset($_POST['clasa']))
		$r_clasa = verifica($_POST['clasa']);
	

?>
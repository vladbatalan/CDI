<?php

	$titlu = '';
	$autor = '';
	$descriere = '';
	$stoc = 1;
	$imagine = 'default.png';

	if(isset($_POST['titlu']))
		$titlu = verifica($_POST['titlu']);
	if(isset($_POST['autor']))
		$autor = verifica($_POST['autor']);
	if(isset($_POST['descriere']))
		$descriere = verifica($_POST['descriere']);
	if(isset($_POST['stoc']))
		$stoc = verifica($_POST['stoc']);
	if(isset($_POST['change_image']))
		$imagine = verifica($_POST['change_image']);
?>
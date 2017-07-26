<?php
	$form_error = '';
	if(isset($_POST['finiseaza_rezervarea']))
	{	
		if(!empty($_POST['profesor']) && !empty($_POST['motiv']) && !empty($_POST['captcha_value']))
		{
			if(isset($_POST['token']) && Token::check($_POST['token']))
			{
				$profesor = verifica($_POST['profesor']);
				$motiv = verifica($_POST['motiv']);
				$captcha_value = verifica($_POST['captcha_value']);
				$clasa = verifica($_POST['clasa']);
				if($captcha_value == $_SESSION['captcha_response'])
				{
					$sql = "INSERT INTO `rezervari_camere` (`id_rezervare`, `id_user`, `id_room`, `profesor`, `clasa`, `data`, `ora`, `motiv`) VALUES (NULL, '".$_SESSION['login']['id_user']."', '".$_GET['room']."', '".$profesor."', '".$clasa."', '".$_GET['date']."', '".$_GET['ora']."', '".$motiv."');";
					$res = mysqli_query($conn, $sql);
					$sql = "SELECT * FROM rooms WHERE id_room = '".$_GET['room']."'";
					$rezult = mysqli_query($conn, $sql);
					$camera = mysqli_fetch_assoc($rezult);
					$MESAJ = "Rezervarea camerei ".$camera['nume']." a fost realizata pentru data de ".$_GET['date'].", ora ".$_GET['ora'].", de catre $profesor!";
				}
				else
				{
					$form_error = "Captcha nu a fost completata corect!";
				}
			}
			else
			{
				$form_error = "A intervenit o eroare la evaluarea formularului! Va rugam incercat din nou!";
			}
		}
		else
		{
			$form_error = "Toate campurile obligatorii trebuie completate!";
		}
	}



?>
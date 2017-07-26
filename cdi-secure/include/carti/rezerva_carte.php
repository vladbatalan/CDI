<?php
	$form_error = '';
	if(isset($_POST['finiseaza_rezervarea'], $_POST['token']))
	{
		if(Token::check($_POST['token']))
		{
			if(!empty($_POST['captcha_value']))
			{
				if($_POST['captcha_value'] == $_SESSION['captcha_response'])
				{
					$astazi = date("Y-m-d");
					$sql = "INSERT INTO rezervari_carti (`id_user`, `id_book`, `stoc_rezervat`, `data_rezervarii`, `confirmed`) VALUES ('".$_SESSION['login']['id_user']."', '".$book_details['id_book']."', '1', '".$astazi."', '0')";
					$result = mysqli_query($conn, $sql);
					$MESAJ = "Cartea \"".$book_details['titlu']."\" de ".$book_details['autor']." a fost rezervata si asteapta sa fie ridicata de la CDI pe parcursul urmatoarelor 7 zile.";
				}
				else
				{
					$form_error = "Codul Captcha nu a fost completat corect!";
				}
			}
			else
			{
				$form_error = "Toate campurile sunt obligatorii!";
			}
		}
		else
		{
			$form_error = "A intervenit o eroare la evaluarea formularului! Va rugam incercat din nou!";
		}
	}
	if(isset($_POST['renunt']))
	{
		$sql = "DELETE FROM rezervari_carti WHERE id_user = '".$_SESSION['login']['id_user']."' AND id_book = '".$book_details['id_book']."'";
		$result = mysqli_query($conn, $sql);
		$done = "Procesul de anulare a rezervarii a fost realizat cu succes!";

	}

?>
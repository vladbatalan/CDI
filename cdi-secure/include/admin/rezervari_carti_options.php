<?php
	if(isset($_POST['token'])){
		if(Token::check($_POST['token']))
		{
			$astazi = date("Y-m-d");
			$sql = "SELECT * FROM rezervari_carti";
			$rezultat = mysqli_query($conn, $sql);
			while($rezervare = mysqli_fetch_assoc($rezultat))
			{
				$bifat = 'confirmat'.$rezervare['id_rezervare'];
				$x = 'sterge'.$rezervare['id_rezervare'];
				if(isset($_POST[$bifat]))
				{
					if($rezervare['confirmed'] == 0)
					{
						$sql = "SELECT * FROM books WHERE id_book = '".$rezervare['id_book']."'";
						$res = mysqli_query($conn, $sql);
						$carte = mysqli_fetch_assoc($res);

						if($carte['stoc'] - $carte['imprumutate'] > 0)
						{
							$sql = "UPDATE books SET imprumutate = '".($carte['imprumutate'] + 1)."' WHERE id_book = '".$carte['id_book']."'";
							$res = mysqli_query($conn, $sql);

							$sql = "UPDATE rezervari_carti SET confirmed = '1' WHERE id_rezervare = '".$rezervare['id_rezervare']."'";
							$res = mysqli_query($conn, $sql);

							$sql = "UPDATE rezervari_carti SET data_rezervarii = '$astazi' WHERE id_rezervare = '".$rezervare['id_rezervare']."'";
							$res = mysqli_query($conn, $sql);

							$top_message = "Operatiile au fost realizate cu succes!";
						}
						else
						{
							$error = "Cartea \"".$carte['titlu']."\" - ".$carte['autor']." nu mai este disponibilă pentru a fi dată spre împrumut!<br>";
						}
					}
					else
					{
						$sql = "SELECT * FROM books WHERE id_book = '".$rezervare['id_book']."'";
						$res = mysqli_query($conn, $sql);
						$carte = mysqli_fetch_assoc($res);

						$sql = "UPDATE books SET imprumutate = '".($carte['imprumutate'] - 1)."' WHERE id_book = '".$carte['id_book']."'";
						$res = mysqli_query($conn, $sql);

						$sql = "DELETE FROM rezervari_carti WHERE id_rezervare = '".$rezervare['id_rezervare']."'";
						$res = mysqli_query($conn, $sql);

						$top_message = "Operatiile au fost realizate cu succes!";
					}
				}
				if(isset($_POST[$x]))
				{
					$sql = "DELETE FROM rezervari_carti WHERE id_rezervare = '".$rezervare['id_rezervare']."'";
					$res = mysqli_query($conn, $sql);

					$top_message = "Operatiile au fost realizate cu succes!";
				}
			}

		}
	}
	

?>
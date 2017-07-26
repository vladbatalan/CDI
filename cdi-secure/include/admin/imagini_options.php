<?php
	if(isset($_POST['adauga']))
	{
		if(isset($_FILES['new_image']) && !empty($_FILES['new_image']) && !empty($_FILES['new_image']['name']))
		{
			$target_dir = '../img/upload/';
			$target_file = $target_dir . basename($_FILES['new_image']['name']);
			$target_name = basename($_FILES['new_image']['name']);
			$UploadOk = 1;
			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

			$mesaj_de_eroare = '';

			//verific daca fisierul este imagine
			$check = getimagesize($_FILES['new_image']['tmp_name']);
			if($check == false)
			{
				$UploadOk = 0;
				$mesaj_de_eroare .= "Fisierul dat nu este o imagine!<br>";
			}

			//verific dimensiunea imaginii
			if($_FILES['new_image']['size'] > 5242880)
			{
				$mesaj_de_eroare .= "Fisier prea mare! Dimensiune maxima: 5Mb!<br>";
				$UploadOk = 0;
			}

			/// Accepta numai formaturile de imagine
			if(strtoupper($imageFileType) != 'JPG' && strtoupper($imageFileType) != 'PNG' && strtoupper($imageFileType) != 'JPEG' && strtoupper($imageFileType) != 'GIF')
			{
				$mesaj_de_eroare .= "Ne pare rau, doar fisierele cu extensiile jpg, png, jpeg, gif sunt primite!<Br>";
				$UploadOk = 0;
			}

			// finalizam adaugarea imaginii
			if($UploadOk == 0)
			{
				$mesaj_de_eroare .= "Fisierul nu a putut fi uploadat!";
				$error_message = $mesaj_de_eroare;
			}
			else
			{
				if(move_uploaded_file($_FILES['new_image']['tmp_name'], $target_file))
				{
					$newname = date('YmdHis',time()).mt_rand().'.'.$imageFileType;
					$sql = "INSERT INTO imagini (`book_image`) VALUES ('".$newname."')";
					$res = mysqli_query($conn, $sql);

					rename($target_file, $target_dir.$newname);
					$imagine_noua = $newname;
				}
				else
				{
					$mesaj_de_eroare .= "A fost o eroare in uploadarea fisierului!";
					$error_message = $mesaj_de_eroare;
				}
			}
		}
		else
		{
			$error_message = "Alegeți o imagine!";
		}	
	}

	if(isset($_POST['modifica'], $_POST['token']))
	{
		if(Token::check($_POST['token']))
		{
			$change = $_POST['change_image'];
			if(isset($_POST['delete']))
			{
				foreach($_POST['delete'] as $del)
				{
					$im = $change;
					if($del == $change)
						$im = 'default.png';
					$dir = "../img/upload/";
					$file = $dir.$del;
					if(file_exists($file)) 
					{
						unlink($file);
						$sql = "UPDATE books SET book_image = '$im' WHERE book_image = '$del'";
						$res = mysqli_query($conn, $sql);

						$dir = "../img/upload/";
						$file = $dir.$del;
						if(file_exists($file)) unlink($file);

						$sql = "DELETE FROM imagini WHERE book_image = '$del'";
						$res = mysqli_query($conn, $sql);
						$top_message = 'Operațiile au fost realizate cu succes!';
					}
					else
					{
						$error_message = "Eroare la ștergerea imaginilor!";
					}
				}
			}
		}
	}

?>
<?php
	if(isset($_POST['modifica'], $_POST['token']))
	{
		if(Token::check($_POST['token']) && !empty($_POST['titlu']) && !empty($_POST['autor']) && !empty($_POST['descriere']) && !empty($_POST['categorie']) && !empty($_POST['stoc']) && (isset($_FILES['new_image']) && !empty($_FILES['new_image']) && !empty($_FILES['new_image']['name']) || isset($_POST['change_image'])))
		{
			$titlu_nou = verifica($_POST['titlu']);
			$autor_nou = verifica($_POST['autor']);
			$descriere_noua = verifica($_POST['descriere']);
			$categorie_noua = verifica($_POST['categorie']);
			$stoc_nou = verifica($_POST['stoc']);

			if($categorie_noua == "alta_categorie")
			{
				if(isset($_POST['new_category']) && !empty($_POST['new_category']))
				{
					$categorie_adaugata = verifica($_POST['new_category']);
					$sql = "SELECT * FROM categorii WHERE nume_categorie = '".$categorie_adaugata."'";
					$rezultat = mysqli_query($conn, $sql);
					if(mysqli_num_rows($rezultat) == 0)
					{
						$sql = "INSERT INTO categorii (`nume_categorie`) VALUES ('".$categorie_adaugata."')";
						$rezultat = mysqli_query($conn, $sql);

						$sql = "SELECT * FROM categorii WHERE nume_categorie = '".$categorie_adaugata."'";
						$rezultat = mysqli_query($conn, $sql);
						$noua_cat = mysqli_fetch_assoc($rezultat);
						$categore_noua = $noua_cat['id_categorie'];
					}
					else
					{
						$error_message = "Exista deja aceasta categorie în baza de date!";
					}
				}
				else{
					$error_message = "Noua categorie trebuie completată!";
				}
			}

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
				$imagine_noua = verifica($_POST['change_image']);
			}

			$sql = "SELECT * FROM books WHERE titlu = '$titlu_nou' AND autor = '$autor_nou'";
			$res = mysqli_query($conn, $sql);
			if(mysqli_num_rows($res) != 0)
			{
				$error_message = 'Această carte există deja în baza de date!';
			}

			if(!isset($error_message))
			{
				$sql = "INSERT INTO `books` (`id_book`, `book_image`, `titlu`, `autor`, `id_categorie`, `stoc`, `descriere`) VALUES (NULL, '$imagine_noua', '$titlu_nou', '$autor_nou', '$categorie_noua', '$stoc_nou', '$descriere_noua')";
				$res = mysqli_query($conn, $sql);
				$top_message = "Operatiile au fost realizate cu succes!";
			}
		}
		else
		{
			$error_message = "Toate câmpurile trebuie completate!";
		}
	}

?>
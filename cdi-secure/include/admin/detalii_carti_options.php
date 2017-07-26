<?php
	if(isset($_POST['modifica'], $_POST['token']))
	{
		if(Token::check($_POST['token']))
		{
			if(isset($_POST['titlu']) && !empty($_POST['titlu']) && $_POST['titlu'] != $carte['titlu'])
			{
				$titlu_nou = verifica($_POST['titlu']);
				$sql = "UPDATE books SET titlu = '".$titlu_nou."' WHERE id_book = '".$carte['id_book']."'";
				$res = mysqli_query($conn, $sql);
				$top_message = "Operatiile au fost realizate cu succes!";
			}
			if(isset($_POST['autor']) && !empty($_POST['autor']) && $_POST['autor'] != $carte['autor'])
			{
				$autor_nou = verifica($_POST['autor']);
				$sql = "UPDATE books SET autor = '".$autor_nou."' WHERE id_book = '".$carte['id_book']."'";
				$res = mysqli_query($conn, $sql);
				$top_message = "Operatiile au fost realizate cu succes!";
			}
			if(isset($_POST['descriere']) && $_POST['descriere'] != $carte['descriere'])
			{
				$descriere_noua = verifica($_POST['descriere']);
				$sql = "UPDATE books SET descriere = '".$descriere_noua."' WHERE id_book = '".$carte['id_book']."'";
				$res = mysqli_query($conn, $sql);
				$top_message = "Operatiile au fost realizate cu succes!";
			}
			if(isset($_POST['categorie']) && !empty($_POST['categorie']) && $_POST['categorie'] != $carte['id_categorie'])
			{
				$categorie_noua = verifica($_POST['categorie']);
				if($categorie_noua != 'alta_categorie')
				{
					$sql = "UPDATE books SET id_categorie = '".$categorie_noua."' WHERE id_book = '".$carte['id_book']."'";
					$res = mysqli_query($conn, $sql);
					$top_message = "Operatiile au fost realizate cu succes!";
				}
				else
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

							$sql = "UPDATE books SET id_categorie = '".$noua_cat['id_categorie']."' WHERE id_book = '".$carte['id_book']."'";
							$rezultat = mysqli_query($conn, $sql);

							$top_message = 'Operatiile au fost realizate cu succes!';
						}
						else
						{
							$error_message = "Exista deja aceasta categorie în baza de date!";
						}
					}
				}
			}
			if(isset($_POST['stoc']) && !empty($_POST['stoc']) && $_POST['stoc'] != $carte['stoc'])
			{
				$stoc_nou = verifica($_POST['stoc']);
				$sql = "UPDATE books SET stoc = '".$stoc_nou."' WHERE id_book = '".$carte['id_book']."'";
				$res = mysqli_query($conn, $sql);
				$top_message = "Operatiile au fost realizate cu succes!";
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

						$sql = "UPDATE books SET book_image = '".$newname."' WHERE id_book = '".$carte['id_book']."'";
						$res = mysqli_query($conn, $sql);

						rename($target_file, $target_dir.$newname);
						$top_message = "Operatiile au fost realizate cu succes!";
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
				if(isset($_POST['change_image']) && $_POST['change_image'] != $carte['book_image'])
				{
					$imagine_noua = verifica($_POST['change_image']);
					$sql = "UPDATE books SET book_image = '".$imagine_noua."' WHERE id_book = '".$carte['id_book']."'";
					$res = mysqli_query($conn, $sql);
					$top_message = "Operatiile au fost realizate cu succes!";
				}
			}
			if(isset($_POST['delete']))
			{
				if($carte['imprumutate'] == 0)
				{
					$sql = "DELETE FROM books WHERE id_book = '".$carte['id_book']."'";
					$res = mysqli_query($conn, $sql);
					header("Location: carti.php");
				}
				else
				{
					$error_message = "Aceasta carte a fost imprumutata și nu poate fi ștearsa până când nu este returnată!";
				}
			}
		}
	}


	$sql = "SELECT * FROM books WHERE id_book = '".$_GET['id_book']."'";
	$res= mysqli_query($conn, $sql);
	$carte = mysqli_fetch_assoc($res);

?>
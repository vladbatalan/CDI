<?php
	if(isset($_POST['modifica'], $_POST['token']))
	{
		if(Token::check($_POST['token']))
		{
			$sql = "SELECT * FROM books";
			$query = mysqli_query($conn, $sql);
			while($carte = mysqli_fetch_assoc($query))
			{
				$titlu_book = "titlu".$carte['id_book'];
				$autor_book = "autor".$carte['id_book'];
				$categorie_book = "categorie".$carte['id_book'];
				$stoc_book = "stoc".$carte['id_book'];

				if(isset($_POST[$titlu_book]) && !empty($_POST[$titlu_book]) && $_POST[$titlu_book] != $carte['titlu'])
				{
					$value = verifica($_POST[$titlu_book]);
					$sql = "UPDATE books SET titlu = '".$value."' WHERE id_book = '".$carte['id_book']."'";
					$res = mysqli_query($conn, $sql);
					$top_message = "Operatiile au fost realizate cu succes!";
				}

				if(isset($_POST[$autor_book]) && !empty($_POST[$autor_book]) && $_POST[$autor_book] != $carte['autor'])
				{
					$value = verifica($_POST[$autor_book]);
					$sql = "UPDATE books SET autor = '".$value."' WHERE id_book = '".$carte['id_book']."'";
					$res = mysqli_query($conn, $sql);
					$top_message = "Operatiile au fost realizate cu succes!";
				}

				if(isset($_POST[$categorie_book]) && !empty($_POST[$categorie_book]) && $_POST[$categorie_book] != $carte['id_categorie'])
				{
					$value = verifica($_POST[$categorie_book]);
					$sql = "UPDATE books SET id_categorie = '".$value."' WHERE id_book = '".$carte['id_book']."'";
					$res = mysqli_query($conn, $sql);
					$top_message = "Operatiile au fost realizate cu succes!";
				}

				if(isset($_POST[$stoc_book]) && !empty($_POST[$stoc_book]) && $_POST[$stoc_book] != $carte['stoc'])
				{
					$value = verifica($_POST[$stoc_book]);
					$sql = "UPDATE books SET stoc = '".$value."' WHERE id_book = '".$carte['id_book']."'";
					$res = mysqli_query($conn, $sql);
					$top_message = "Operatiile au fost realizate cu succes!";
				}
			}
		}
	}
?>
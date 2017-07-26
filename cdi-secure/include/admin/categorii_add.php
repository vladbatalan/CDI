<?php
	if(isset($_POST['adauga']))
	{
		if(!empty($_POST['new_category']))
		{
			$categorie = verifica($_POST['new_category']);
			$sql = "SELECT * FROM categorii WHERE nume_categorie = '".$categorie."'";
			$res = mysqli_query($conn, $sql);
			if(mysqli_num_rows($res) == 0)
			{
				$sql = "INSERT INTO categorii (`nume_categorie`, `implicit`) VALUES ('".$categorie."', '0')";
				$res = mysqli_query($conn, $sql);
				$top_message = "Operațiile au fost realizate cu succes!";
			}
			else
			{
				$error_message = "Există deja această categorie în baza de date!";
			}
		}
		else
		{
			$error_message = "Câmpul trebuie completat!";
		}
	}

?>
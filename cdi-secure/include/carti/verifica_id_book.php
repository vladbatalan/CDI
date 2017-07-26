<?php
	if(isset($_GET['id_book']))
	{
		$sql = "SELECT * FROM books WHERE id_book = '".$_GET['id_book']."'";
		$rezultat = mysqli_query($conn, $sql);
		if(mysqli_num_rows($rezultat) > 0)
		{
			if(isset($_SESSION['login']))
			{
				if($_SESSION['login']['rol'] == 'cititor' || $_SESSION['login']['rol'] == 'cititor_rezerva' || $_SESSION['login']['rol'] == 'admin' || $_SESSION['login']['rol'] == 'admin_suprem')
				{
					$book_details = mysqli_fetch_assoc($rezultat);
				}
				else
				{
					$MESAJ = "Din pacate nu aveti accesibilitate la acest serviciu. Discutati cu administratorul despre acest lucru (doamna bibliotecara din CDI).";
				}
			}
			else
			{
				$MESAJ = "Trebuie sa fiti logat pentru a rezerva o carte!";
			}
		}
		else
		{
			header("location: Book_arhive.php");
		}
	}
	else
	{
		header("location: Book_arhive.php");
	}
?>
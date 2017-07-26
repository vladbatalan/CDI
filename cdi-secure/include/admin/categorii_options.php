<?php
	if(isset($_POST['modifica'], $_POST['token']))
	{
		if(isset($_POST['delete'], $_POST['inlocuieste_sterse']) && Token::check($_POST['token']))
		{
			$inlocuieste_id = verifica($_POST['inlocuieste_sterse']);
			foreach($_POST['delete'] as $del)
			{
				if($del == $inlocuieste_id) $inlocuieste_id = 3;
				$sql = "UPDATE books SET id_categorie = '".$inlocuieste_id."' WHERE id_categorie = '".$del."'";
				$res = mysqli_query($conn, $sql);

				$sql = "DELETE FROM categorii WHERE id_categorie = '".$del."'";
				$res = mysqli_query($conn, $sql);
			}
			$top_message = "Operatiile au fost realizate cu succes!";
		}
	}


?>
<?php
	if(isset($_POST['modifica']))
	{
		if(isset($_POST['token']) && Token::check($_POST['token']))
		{
			// verificam daca s a realizat procedura de delete
			if(isset($_POST['vazut']))
			{
				foreach($_POST['vazut'] as $update)
				{
					$sql = "UPDATE rezervari_camere SET confirmed = '1' WHERE id_rezervare = '".$update."'";
					$result = mysqli_query($conn, $sql);
					$top_message = "Operatie realizata cu succes!";
				}
			}
			
			if(isset($_POST['action']))
			{
				foreach($_POST['action'] as $del)
				{
					$sql = "DELETE FROM rezervari_camere WHERE id_rezervare = '".$del."'";
					$result = mysqli_query($conn, $sql);
					$top_message = "Operatie realizata cu succes!";
				}
			}
		}
	}

?>
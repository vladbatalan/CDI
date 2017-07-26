<?php
	if(isset($_POST['modifica'], $_POST['token']))
	{
		if(Token::check($_POST['token']))
		{
			// verificam daca s a realizat procedura de delete
			$prev_err_msg = '';
			if(isset($_POST['delete']))
			{
				foreach($_POST['delete'] as $del)
				{
					$sql = "SELECT * FROM rezervari_carti WHERE id_user = '$del' AND (confirmed = '1' OR confirmed = '2')";
					$result = mysqli_query($conn, $sql);

					if(mysqli_num_rows($result) == 0)
					{	
						$sql = "DELETE FROM users WHERE id_user = '".$del."'";
						$result = mysqli_query($conn, $sql);
						$top_message = "Operatie realizata cu succes!";
					}
					else
					{
						$sql = "SELECT * FROM users WHERE id_user = '$del'";
						$res = mysqli_query($conn, $sql);
						$user = mysqli_fetch_assoc($res);

						$prev_err_msg .= "<li>Userul <i>".$user['username']."</i> nu a putut fi șters pentru că deține o carte!</li>";
					}
				}
				if($prev_err_msg != '')
					$error = "<ul>$prev_err_msg</ul>";
			}

			//schimbam toate rolurile
			$nume_input_rol = '';
			$sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_assoc($result))
			{
				$nume_input_rol = $row['id_user']."select";
				if(isset($_POST[$nume_input_rol]))
				{
					if($row['rol'] != $_POST[$nume_input_rol]){
						$sql = "UPDATE users SET rol = '".$_POST[$nume_input_rol]."' WHERE id_user = '".$row['id_user']."'";
						$res = mysqli_query($conn, $sql);
						if($row['confirmed'] == 0)
						{
							$sql = "UPDATE users SET confirmed = '1' WHERE id_user = '".$row['id_user']."'";
							$res = mysqli_query($conn, $sql);
						}
						$top_message = "Operatie realizata cu succes!";
					}
				}
			}

			//schimbam toate clasele
			$nume_input_clasa = '';
			$sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_assoc($result))
			{
				$nume_input_clasa = $row['id_user']."clasa";
				if(isset($_POST[$nume_input_clasa]))
				{
					if($row['clasa'] != $_POST[$nume_input_clasa]){
						$sql = "UPDATE users SET clasa = '".$_POST[$nume_input_clasa]."' WHERE id_user = '".$row['id_user']."'";
						$res = mysqli_query($conn, $sql);
						$top_message = "Operatie realizata cu succes!";
					}
				}
			}
		}
	}
?>
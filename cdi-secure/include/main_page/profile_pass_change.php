<?php
	if(isset($_POST['change_pass']))
	{
		if(!empty($_POST['old_pass']) && !empty($_POST['new_pass1']) && !empty($_POST['new_pass2']) && !empty($_POST['captcha_value']))
		{
			$old_pass = verifica($_POST['old_pass']);
			$new_pass1 = verifica($_POST['new_pass1']);
			$new_pass2 = verifica($_POST['new_pass2']);
			if($_POST['captcha_value'] == $_SESSION['captcha_response'])
			{
				$old_pass_hash = hashword($old_pass, $user_details['salt']);
				if($user_details['parola'] == $old_pass_hash)
				{
					if($new_pass1 == $new_pass2)
					{
						if(strlen($new_pass1) > 6){
							$parola_noua_hash =  hashword($_POST['new_pass1'], $user_details['salt']);
							$sql = "UPDATE users SET parola = '".$parola_noua_hash."' WHERE id_user = '".$user_details['id_user']."'";
							$res = mysqli_query($conn, $sql);
							$done = "Parola a fost schimbata cu succes!";
						}
						else
						{
							$MESAJ = 'Parola nouă trebuie să aibă minim 7 caractere!';
						}
					}
					else
					{
						$MESAJ = "Parolele noi nu corespund!";
					}
				}
				else
				{
					$MESAJ = "Parola veche este gresita!";
				}
			}
			else
			{
				$MESAJ = "Captcha nu a fost completata corect!";
			}
		}
		else
		{
			$MESAJ = "Toate campurile trebuie completate!";
		}
	}
?>
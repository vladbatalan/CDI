<?php
	//################## Aici verificam daca logarea a fost realizata bine ################
	if(isset($_POST['login']))
	{
		if(!empty($_POST['pass1']) && !empty($_POST['username']) && isset($_POST['token']))
		{
			$ok = 1;
			if(!Token::check($_POST['token'])){
				$ok = 0;
				$MESAJ = "Eroare la trimiterea formularului, incercati din nou!";
			}
			if(isset($_SESSION['multiple_login']) && $_SESSION['multiple_login'] > 3)
			{
				if(!empty($_POST['captcha_value']))
				{
					if($_POST['captcha_value'] == $_SESSION['captcha_response'])
					{
						$ok = 1;
					}
					else
					{
						$MESAJ = 'Captcha nu a fost completată corect!';
						$ok = 0;
					}
				}
				else
				{
					$MESAJ = 'Captcha trebuie completată!';
					$ok = 0;
				}
			}
			if($ok)
			{
				$pass1 = verifica($_POST['pass1']);
				$username = verifica($_POST['username']);

				$sql = "SELECT * FROM users WHERE username = '".$username."'";
				$res = mysqli_query($conn, $sql);
				
				if(mysqli_num_rows($res) == 1)
				{
					$user = mysqli_fetch_assoc($res);
					$pass1 = hashword($pass1, $user['salt']);
					if($user['parola'] == $pass1)
					{
						$_SESSION['login'] = $user;
						$MESAJ = "Ai fost logat cu succes!";
						header("location: index.php");
					}
					else
					{
						$MESAJ = "Nume sau parolă greșite!";
					}
				}
				else
				{
					$MESAJ = "Nume sau parolă greșite!";
				}
			}
		}
		else
		{
			$MESAJ = "Toate campurile obligatorii trebuie completate!";
		}
	}

?>
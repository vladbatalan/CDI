<?php

	function verifica_username($string)
	{
		if (!preg_match('/[^A-Za-z0-9_-]/', $string)) // '/[^a-z\d]/i' should also work.
		  	return 1;
		return 0;
	}
	
	if(isset($_POST["signup"]))
	{
		if(!empty($_POST['nume']) && !empty($_POST['prenume']) && !empty($_POST['pass1']) && !empty($_POST['pass2']) && !empty($_POST['username']) && !empty($_POST['captcha_value']))
		{

			$nume = verifica($_POST['nume']);
			$prenume = verifica($_POST['prenume']);
			$username = verifica($_POST['username']);
			$pass1 = verifica($_POST['pass1']);
			$pass2 = verifica($_POST['pass2']);
			$clasa = verifica($_POST['clasa']);

			if(isset($_POST['token']) && Token::check($_POST['token']))
			{
				if(verifica_username($username) && verifica_username($nume) && verifica_username($prenume))
				{
					if($pass1 === $pass2)
					{
						if(strlen($pass1) > 6)
						{
							if($_POST['captcha_value'] == $_SESSION['captcha_response'])
							{
								//verificam daca exista acest username in baza de date
								$sql = "SELECT * FROM users WHERE username = '".$username."'";		
								$res = mysqli_query($conn, $sql);
								if(mysqli_num_rows($res) == 0)
								{
									$salt = generate_new_salt();
									$pass1 = hashword($pass1, $salt);
									$astazi = date("Y-m-d");
									$sql = "INSERT INTO `users` (`username`, `nume`, `prenume`, `clasa`, `parola`, `salt`, `rol`, `data_realizarii`) VALUES ('".$username."', '".$nume."', '".$prenume."', '".$clasa."', '".$pass1."', '".$salt."', 'vizitator', '".$astazi."')";	
									$res = mysqli_query($conn, $sql);
									$MESAJ = "Contul dumneavoastra a fost creat cu succes si asteapta sa fie confirmat la CDI! Va veti putea loga pentru o saptamana, dar fara acces la toate functionalitatiile site-ului.";
								}
								else
								{
									$MESAJ = "Acest username este folosit!";
								}
							}
							else
							{
								$MESAJ = "Captcha nu a fost completata corect!";
							}
						}
						else
						{
							$MESAJ = "Parola este prea mică! (minim 7 caractere)";
						}
					}
					else
					{
						$MESAJ = "Cele doua parole nu coincid!";
					}
					
				}
				else
				{
					$MESAJ = "Username-ul, numele și prenumele nu au voie să conțină spații, și alte caractere speciale, înafară de ('-','_')!";
				}
			}
			else
			{
				$MESAJ = "Eroare la trimiterea formularului, incercati din nou!";
			}
		}
		else
		{
			$MESAJ = "Toate campurile trebuiesc completate!";
		}
	}


?>
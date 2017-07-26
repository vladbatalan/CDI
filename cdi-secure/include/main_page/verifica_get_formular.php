<?php 
	function validateDate($date)
	{
	    $d = DateTime::createFromFormat('Y-m-d', $date);
	    return $d && $d->format('Y-m-d') === $date;
	}

	if(!isset($_GET['room']) || !isset($_GET['date']) || !isset($_GET['ora']) || !validateDate($_GET['date']))
	{
		echo "<script> window.close(); </script>";
	}
	else
	{
		if(!isset($_SESSION['login']))
		{
			$MESAJ = "Trebuie sa fiti logat pentru a putea face rezervari!";
		}
		else
		{
			if($_SESSION['login']['rol'] != 'admin' && $_SESSION['login']['rol'] != 'rezerva' && $_SESSION['login']['rol'] != 'cititor_rezerva' && $_SESSION['login']['rol'] != 'admin_suprem'){
				$MESAJ = "Contul dumneavoastra nu are acces la acest privilegiu! Vorbiti cu administratorul CDI pentru accesibilitate.";
			}
		}
	}

?>
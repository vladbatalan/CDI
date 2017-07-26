<?php
	$categorie_primita = 'xaxofon';


	$link = '';
	$filtru = ' WHERE';
	$nr_elem = 0;
	if(isset($_GET['titlu']) && !empty($_GET['titlu']))
	{
		if($nr_elem > 0)
		{
			$filtru .= " AND";
			$link .= "&";
		}
		$nr_elem ++;
		$titlu_primit = verifica($_GET['titlu']);
		$filtru .= " titlu LIKE '%$titlu_primit%'";
		$link .= "titlu=".$_GET['titlu'];
	}
	if(isset($_GET['autor']) && !empty($_GET['autor']))
	{
		if($nr_elem > 0)
		{
			$filtru .= " AND";
			$link .= "&";
		}
		$nr_elem ++;
		$autor_primit = verifica($_GET['autor']);
		$filtru .= " autor LIKE '%$autor_primit%'";
		$link .= "autor=".$_GET['autor'];
	}
	if(isset($_GET['categorie']) && !empty($_GET['categorie']))
	{
		$categorie_cr = verifica($_GET['categorie']);
    	$sql = "SELECT * FROM books WHERE id_categorie = '$categorie_cr'";
    	$rezultat = mysqli_query($conn, $sql);
    	if(mysqli_num_rows($rezultat) > 0)
    	{
    		if($nr_elem > 0)
    		{
				$filtru .= " AND";
				$link .= "&";
    		}			
    		$nr_elem ++;
			$categorie_primita = verifica($_GET['categorie']);
	    	$filtru .= " id_categorie LIKE '$categorie_primita'";
			$link .= "categorie=".$_GET['categorie'];
    	}	
	}
	if($nr_elem == 0)
    {
    	//nu a aparut nicio cautare cu filtru
    	$filtru = '';
    }
    else{
    	$link = "?".$link;
    }

?>
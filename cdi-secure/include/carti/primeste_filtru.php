<?php
	//primeste eventualele filtere de cautare
	$titlu_primit = '';
	$autor_primit = '';
	$categorie_bruta = '';

    $filtru_adaugare = ' WHERE';
    $primul = 0;
    if(isset($_GET['titlu']) && !empty($_GET['titlu']))
    {
    	$titlu_primit = verifica($_GET['titlu']);
    	if($primul == 0)
    		$primul ++;
    	else
    		$filtru_adaugare .= ' AND';
    	$filtru_adaugare .= " titlu LIKE '%$titlu_primit%'";
    }

    if(isset($_GET['autor']) && !empty($_GET['autor']))
    {
    	$autor_primit = verifica($_GET['autor']);
    	if($primul == 0)
    		$primul ++;
    	else
    		$filtru_adaugare .= ' AND';
    	$filtru_adaugare .= " autor LIKE '%$autor_primit%'";
    }

    if(isset($_GET['categorie']) && !empty($_GET['categorie']))
    {
    	$categorie_primita = verifica($_GET['categorie']);
    	$sql = "SELECT * FROM books WHERE id_categorie = '$categorie_primita'";
    	$rezultat = mysqli_query($conn, $sql);
    	if(mysqli_num_rows($rezultat) > 0)
    	{
    		if($primul == 0)
	    		$primul ++;
	    	else
	    		$filtru_adaugare .= ' AND';
	    	$filtru_adaugare .= " id_categorie LIKE '$categorie_primita'";
    	}
    }
    if($primul == 0)
    {
    	//nu a aparut nicio cautare cu filtru
    	$filtru_adaugare = '';
    }



?>
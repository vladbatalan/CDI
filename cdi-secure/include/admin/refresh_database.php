<?php
	//stergem conturile foarte invechite (vizitatorii aflati la data de expirare)
	$astazi = date("Y-m-d");
	$sql = "SELECT * FROM users WHERE confirmed = '0'";
	$result = mysqli_query($conn, $sql);

	//numar de persoane sterse
	$nr_persoane_sterse = 0;
	if(mysqli_num_rows($result)){
		while($row = mysqli_fetch_assoc($result))
		{
			$date = date("Y-m-d", strtotime($row['data_realizarii']));
			$date_after = date("Y-m-d", strtotime("+7 day", strtotime($date)));
			if($date_after < $astazi)
			{
				$sql = "DELETE FROM users WHERE id_user = '".$row['id_user']."'";
				$action = mysqli_query($conn, $sql);
				$nr_persoane_sterse ++;
			}
		}
	}

	//seteaza ziua cu 2 saptamani inainte (incepand cu luni)
	$astazi = date("Y-m-d");
    $inceput = date("Y-m-d", strtotime($astazi));
    $ziua_saptamanii = date("w", strtotime($inceput));
    while($ziua_saptamanii != 1) 
    {
        $your_date = strtotime("-1 day", strtotime($inceput));
        $inceput = date('Y-m-d', $your_date);
        $ziua_saptamanii = date("w", strtotime($inceput));
    }
    $your_date = strtotime("-1 day", strtotime($inceput));
    $inceput = date('Y-m-d', $your_date);
    $ziua_saptamanii = date("w", strtotime($inceput));
    while($ziua_saptamanii != 1) 
    {
        $your_date = strtotime("-1 day", strtotime($inceput));
        $inceput = date('Y-m-d', $your_date);
        $ziua_saptamanii = date("w", strtotime($inceput));
    }

    //sterge rezervarile de camere expirate
	$sql = "SELECT * FROM rezervari_camere WHERE data < '".$inceput."'";
	$res = mysqli_query($conn, $sql);
	$nr_rezervari = 0;
	if(mysqli_num_rows($res) > 0)
	{
		$nr_rezervari = mysqli_num_rows($res);
		$sql = "DELETE FROM rezervari_camere WHERE data < '".$inceput."'";
		$res = mysqli_query($conn, $sql);
	}

	//sterge rezervarile de carti care nu au fost confirmate
	$astazi = date("Y-m-d");
	$sql = "SELECT * FROM rezervari_carti";
	$result = mysqli_query($conn, $sql);

	$nr_rezervari_carti_sterse = 0;
	$nr_rezervari_carti_expirate = 0;
	while($rezervare = mysqli_fetch_assoc($result))
	{
		if($rezervare['confirmed'] == 0)
		{
			$index_data = $rezervare['data_rezervarii'];
			$your_date = strtotime("+7 day", strtotime($index_data));
            $exceded_data = date('Y-m-d', $your_date);

            //daca a expirat il stergem din baza de date
            if($exceded_data < $astazi)
            {
            	$sql = "DELETE FROM rezervari_carti WHERE id_rezervare = '".$rezervare['id_rezervare']."'";
            	$res = mysqli_query($conn, $sql);
            	$nr_rezervari_carti_sterse ++;
            }
			continue;
		}
		if($rezervare['confirmed'] == 1)
		{
			$index_data = $rezervare['data_rezervarii'];
			$your_date = strtotime("+14 day", strtotime($index_data));
            $exceded_data = date('Y-m-d', $your_date);

            //daca a expirat il stergem din baza de date
            if($exceded_data < $astazi)
            {
            	$sql = "UPDATE rezervari_carti SET confirmed = '2' WHERE id_rezervare = '".$rezervare['id_rezervare']."'";
            	$res = mysqli_query($conn, $sql);

            	$sql = "UPDATE rezervari_carti SET data_rezervarii = '$astazi' WHERE id_rezervare = '".$rezervare['id_rezervare']."'";
            	$res = mysqli_query($conn, $sql);
            	$nr_rezervari_carti_expirate ++;
            }
			continue;
		}

	}

	if($nr_persoane_sterse > 0)
	{
		$top_message = "<li>Au fost șterse $nr_persoane_sterse conturi de utilizator expirate din baza de date!</li>";
	}

	if($nr_rezervari > 0)
	{
		if(!isset($top_message)) $top_message = '';
		$top_message .= "<li>Au fost șterse $nr_rezervari rezervari de camere expirate din baza de date!</li>";
	}

	if($nr_rezervari_carti_sterse > 0)
	{
		if(!isset($top_message)) $top_message = '';
		$top_message .= "<li>Au fost șterse $nr_rezervari_carti_sterse rezervari de camere expirate din baza de date!</li>";
	}

	if($nr_rezervari_carti_expirate > 0)
	{
		if(!isset($top_message)) $top_message = '';
		$top_message .= "<li>Au expirat $nr_rezervari_carti_expirate rezervari de carti!</li>";
	}

	if(isset($top_message)) $top_message = "<ul>".$top_message."</ul>";
	

?>
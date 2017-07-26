<html>
<head>
	<?php
		include "../connection/database.php";
		include "../main_page/verifica_id_room.php";
		function format_hour($nr)
		{
			$string = '';
			if($nr < 10)
				$string = '0';
			$string .= $nr.":00";
			return $string;
		}
	?>

    <link rel="stylesheet" href="../../css/login-register.css">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CDI-Centrul de documentare si informare</title>

</head>
<body>
	
	<div class="menu">
        <ul>
            <li>
                <a href="../../index.php"> Acasa </a>
            </li>
        </ul>
    </div>
    <div class = "main-container">
    	<?php
    		$sql = "SELECT * FROM rooms WHERE id_room = '".$_GET['room']."'";
    		$res = mysqli_query($conn, $sql);
    		$rand = mysqli_fetch_assoc($res);
    		$camera = $rand['nume'];
    		echo "<h2> $camera </h2>";
    	?>
    	<p> Alegeti ziua pentru care doriti sa faceti rezervare. </p>
    	<form method = "post" <?php echo "action = 'room_table.php?room=".$_GET['room']."'";?> >
    		<select class="input-text" name = "data">
    			<option disabled selected value> -- alege ziua -- </option>
	    		<?php
					$zile = array("Duminica", "Luni" ,"Marti","Miercuri","Joi","Vineri","Sambata");
					$astazi = date("d-m-Y");
					$inceput = date("d-m-Y", strtotime($astazi));
					$ziua_saptamanii = date("w", strtotime($inceput));
					$diferenta = 0;
	    			while($ziua_saptamanii != 1) 
	    			{
		    			$your_date = strtotime("-1 day", strtotime($inceput));
		    			$inceput = date('d-m-Y', $your_date);
		    			$ziua_saptamanii = date("w", strtotime($inceput));
		    			$diferenta ++;
	    			}
	    			$index_zi = $astazi;
	    			for($i = $diferenta; $i<=21; $i++)
	    			{
		    			$ziua_saptamanii = date("w", strtotime($index_zi));
	    				echo "<option value = '$index_zi'>$index_zi $zile[$ziua_saptamanii]</option>";
		    			$your_date = strtotime("+1 day", strtotime($index_zi));
		    			$index_zi = date('d-m-Y', $your_date);
	    			}
	    		?>
    		</select>
    		<input type = "submit" name = "alege_data" class = "button" value="Alege data">

    	</form>


	    <?php
	    	if(isset($_POST["data"]))
	    	{

	    		$ziua_rezervarii = htmlspecialchars($_POST["data"]);
	    		$ziua_saptamanii = date("w", strtotime($ziua_rezervarii));
	    		echo "<p> Rezervarile pentru ".$zile[$ziua_saptamanii].", data de ".$ziua_rezervarii."</p>";


	    		///Tabel pe orizontala
	    		echo "<div id='hidden-oriz'>";
	    		$ziua_rezervarii = date("Y-m-d", strtotime($ziua_rezervarii));
	    		$i = 8;
	    		while($i<=19)
	    		{
	    			echo "<table class='tabel-oriz'>";
	    			echo "<tr>
	    					<th>Ora</th>";
	    			$start = $i;
	    			$limita = $i+4;
		    		for($i; $i<$limita; $i++)
		    		{
		    			echo "<td> ".format_hour($i)." - ".format_hour($i+1)." </td>";
		    		}
		    		echo "</tr>
		    		<tr>
		    			<th>Status</th>";
		    		for($start; $start<$limita; $start++)
		    		{
		    			$sql = "SELECT * FROM rezervari_camere WHERE id_room = '".$_GET['room']."' AND data = '".$ziua_rezervarii."' AND ora = '$start'";
		    			$res = mysqli_query($conn, $sql);
		    			if(mysqli_num_rows($res))
		    			{
		    				echo "<td><a class = 'rezervat' href='room_formular.php?room=".$_GET['room']."&date=".$ziua_rezervarii."&ora=$start' target='_blank'> REZERVAT </a></td>";
		    			}
		    			else
		    			{
		    				echo "<td><a class='liber' href='room_formular.php?room=".$_GET['room']."&date=".$ziua_rezervarii."&ora=$start' target='_blank'> Liber </a></td>";
		    			}
		    		}
		    		echo "</tr>";
		    		echo "</table> <br>";
	    		}
	    		echo "</div>";


	    		/// Tabel pe verticala
	    		echo "<div id='hidden-vert'>";
	    		echo "<table class='tabel-oriz'>";
	    		echo "<tr>
	    					<th>Ora</th>
	    					<th>Status</th>
	    			</tr>";
	    		$ziua_rezervarii = date("Y-m-d", strtotime($ziua_rezervarii));
	    		for($i = 8; $i<=19; $i++)
	    		{
	    			echo "
	    			<tr>
	    				<td> $i:00 - ".($i+1).":00 </td>";
	    			$sql = "SELECT * FROM rezervari_camere WHERE id_room = '".$_GET['room']."' AND data = '".$ziua_rezervarii."' AND ora = '$i'";
	    			$res = mysqli_query($conn, $sql);
	    			if(mysqli_num_rows($res))
	    			{
	    				echo "<td><a class = 'rezervat' href='room_formular.php?room=".$_GET['room']."&date=".$ziua_rezervarii."&ora=$i' target='_blank'> REZERVAT </a></td>";
	    			}
	    			else
	    			{
	    				echo "<td><a class = 'liber' href='room_formular.php?room=".$_GET['room']."&date=".$ziua_rezervarii."&ora=$i' target='_blank'> Liber </a></td>";
	    			}
	    			echo "</tr>";
	    		}
	    		echo "</table>";
	    		echo "</div>";
	    	}
	    ?>
    </div>

</body>
</html>


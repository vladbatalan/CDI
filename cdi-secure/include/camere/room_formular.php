<html>
<head>
	<?php
		include "../connection/database.php";
        require_once("../crypts/token.php");
        include "../main_page/verifica_get_formular.php";
        include "../main_page/string_validation.php";
        include "../main_page/formular_rezevare.php";
	?>

    <link rel="stylesheet" href="../../css/login-register.css">
    <script src="../../js/captcha.js"> </script>

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
    <div class="main-container">
    	<?php
            if(isset($MESAJ)){
                echo "<h3 class='error'>".$MESAJ."</h3>";
            }
            else
            {
                $zile = array("Duminica", "Luni" ,"Marti","Miercuri","Joi","Vineri","Sambata");
                $data_rezervare = verifica($_GET['date']);
                $ora_rezervare = verifica($_GET['ora']);
                $camera_rezervare = verifica($_GET['room']);
                $data_rez_format = date("d-m-Y", strtotime($data_rezervare));

                $clasa = '';
                $motiv = '';
                $profesor = '';
                if(isset($_POST['clasa'])) $clasa = verifica($_POST['clasa']);
                if(isset($_POST['motiv'])) $motiv = verifica($_POST['motiv']);
                if(isset($_POST['profesor'])) $profesor = verifica($_POST['profesor']);

                $sql = "SELECT * FROM rooms WHERE id_room = '$camera_rezervare'";
                $res = mysqli_query($conn, $sql);
                $rand = mysqli_fetch_assoc($res);
                $ziua_saptamanii = date("w", strtotime($data_rezervare));
                $nume_camera = $rand['nume'];

                $sql = "SELECT * FROM rezervari_camere WHERE id_room = '".verifica($_GET['room'])."' AND data = '".verifica($_GET['date'])."' AND ora = '".verifica($_GET['ora'])."'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) == 0)
                {
                    if(!isset($done))
                    {
                       
                        echo "<h3> Completeaza formularul de rezervare a salii $nume_camera pentru ".$zile[$ziua_saptamanii].", data de $data_rez_format, ora $ora_rezervare:00 </h3>";
                        echo "<p class='error'> $form_error </p>";
                        echo "<form method = 'post' action = 'room_formular.php?room=".$camera_rezervare."&date=".$data_rezervare."&ora=".$ora_rezervare."'>
                            <p> Clasa/clasele participante: <br>
                                <input type='text' name='clasa' placeholder='Scrieti clasa participanta' class='input-text' value='".$clasa."'>
                            </p>
                            <p>
                                Profesorul/persoana responsabila *: <br>
                                <input type='text' name='profesor' placeholder='Profesor' class='input-text' value='".$profesor."'>
                            </p>
                            <p>
                                Precizati activitatea care se va desfasura *: <br>
                                <textarea name='motiv' class='input-text' placeholder='Precizati activitatea' style='min-height: 50px;'>".$motiv."</textarea>
                            </p>
                            <p>Captcha*:<br>
                                <image src='../captcha/captcha_image.php' id='captcha_image' style='width: 200px;'>
                                <img src='../captcha/refresh.ico' onclick='refresh(\"../captcha/captcha_image.php\");' style='width:35px; height:35px;' alt='Alt text'>
                                <br>
                                Introduce textul din imaginea captcha *:<br>
                                <input class='input-text' type='text' name='captcha_value'><br>
                            </p>
                            <input type='hidden' name='token' value='".Token::generate()."'>
                            <input type='submit' name='finiseaza_rezervarea' value='Rezerva sala' class='button'>";
                        echo "</form>";
                    }
                    else
                    {
                        echo "<h2> Rezervarea a fost realizata cu succes! </h2>";
                    }
                }
                else
                {
                    $row = mysqli_fetch_assoc($result);

                    //Alegem datele utilizatorului
                    $sql = "SELECT * FROM users WHERE id_user = '".$row['id_user']."'";
                    $res = mysqli_query($conn, $sql);
                    $user = mysqli_fetch_assoc($res);

                    echo "<h3 class = 'error'> Ne pare rau, dar din pacate sala a fost rezervata pentru aceasta perioada de timp.</h3>
                        <p><b>Camera:</b> ".$nume_camera."</p>
                        <p><b>Persoana care a realizat rezervarea:</b> ".$user['nume']." ".$user['prenume']." (<i>".$user['username']."</i>)</p>
                        <p><b>Profesor / Persoana responsabila:</b> ".$row['profesor']."</p>";
                    if(empty($row['motiv']))
                        $p_motiv = "Nu a precizat nici un motiv.";
                    else
                        $p_motiv = $row['motiv'];
                    echo "<p><b>Motivul rezervarii:</b> <i> $p_motiv </i></p>";
                    echo "<p><b>Data:</b> ".$zile[$ziua_saptamanii]." ".$data_rez_format."</p>";
                    echo "<p><b>Orele:</b> $ora_rezervare:00 - ".($ora_rezervare + 1).":00 </p>";
                    if($_SESSION['login']['id_user'] == $user['id_user'] || $_SESSION['login']['rol'] == 'admin' || $_SESSION['login']['rol'] == 'admin_suprem')
                    {
                        echo "<form method='post' action = 'room_formular.php?room=".$camera_rezervare."&date=".$data_rezervare."&ora=".$ora_rezervare."'>";
                        echo "<input type='submit' value='Anuleaza rezervarea' name='anuleaza_rezervarea' class='button'>";
                        echo "</form>";
                    }
                }
            }
        ?>
    </div>


</body>
</html>


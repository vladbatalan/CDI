<html>
<head>

    <?php
        include "include/connection/database.php";
        include "include/crypts/criptare.php";
        include "include/main_page/string_validation.php";
        include "include/main_page/profile_get_user.php";
    ?>

    <script src="js/captcha.js"> </script>
    <link rel="stylesheet" href="css/login-register.css">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CDI-Centrul de documentare si informare</title>
    
</head>
<body>

   	<?php
   		include "include/menus/profile_menu.php";
   	?>

    <div class="main-container">
        <?php
            if(isset($MESAJ))
                echo "<p style='color:red; font-size: 20px;'>".$MESAJ."</p>";
        ?>

        <div class="profile-box">
            <?php
                echo "<p><b>Username:</b> " . $user_details['username']."</p>";
                echo "<p><b>Nume prenume:</b> " . $user_details['nume']." ".$user_details['prenume']."</p>";
                echo "<p><b>Rol:</b> ". $user_details['rol']."</p>";
                echo "<p><b>Clasa:</b> ". $user_details['clasa']."</p>";

                if($_SESSION['login']['id_user'] == $username || $_SESSION['login']['rol'] == 'admin_suprem' || ($_SESSION['login']['rol'] == 'admin' && $user_details['rol'] != 'admin' && $user_details['rol'] != 'admin_suprem'))
                    echo " <a href='password_change.php?user=".$username."'><button class='profile-button'> Schimba parola </button></a>";
            ?>
        </div>

    </div>




</body>
</html>
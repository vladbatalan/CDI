<html>
<head>

    <?php
        include "include/connection/database.php";
        require_once("include/crypts/token.php");
        include "include/crypts/criptare.php";
        include "include/main_page/string_validation.php";
        include "include/main_page/register.php";
        include "include/main_page/salveaza_date_formular_register.php";
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

    <div class="menu">
        <ul>
            <li>
                <a href="index.php"> Acasa </a>
            </li>
        </ul>
    </div>
    <div class="main-container">
        <h3> Conturile realizate vor fi confirmate de către persoana de la bibliotecă dacă vă veți prezenta la CDI în decursul a 7 zile, în caz contrar, contul va fi șters din baza de date! </h3>

        <?php
            if(isset($MESAJ))
                echo "<p style='color:red; font-size: 20px;'>".$MESAJ."</p>";
        ?>

        <form action="" method="post">
            <p>Nume*: <br><input class="input-text" type="text" name="nume" placeholder="Nume" value="<?php echo $r_nume; ?>"></p>
            <p>Prenume*: <br><input class="input-text" type="text" name="prenume" placeholder="Prenume" value="<?php echo $r_prenume; ?>"></p>
            <p>Nume Utilizator*: <br><input class="input-text" type="text" name="username" placeholder="Username" value="<?php echo $r_username; ?>"></p>
            <p>Parola*: <br><input class="input-text" type="password" name="pass1" placeholder="Parola"></p>
            <p>Repeta parola*: <br><input class="input-text" type="password" name="pass2" placeholder="Repeta parola"></p>
            <p>Clasa: <br><input class="input-text" type="text" name="clasa" placeholder="Clasa" value="<?php echo $r_clasa; ?>"></p>
            <p>Captcha*:<br>
                <image src='include/captcha/captcha_image.php' id='captcha_image' style="width: 200px;">
                <img src='include/captcha/refresh.ico' onclick='refresh("include/captcha/captcha_image.php");' style='width:35px; height:35px;' alt='Alt text'>
                <br>
                Introduce textul din imaginea captcha *:<br>
                <input class="input-text" type='text' name='captcha_value'><br>
            </p>
            <input type='hidden' name='token' value='<?php echo Token::generate(); ?>'>
            <p><input class="button" type="submit" name="signup" placeholder="Sign up" value="Inregistreaza-te"></p>
        </form>
    </div>




</body>
</html>
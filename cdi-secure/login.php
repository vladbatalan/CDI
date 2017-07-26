<html>
<head>

    <?php
        include "include/connection/database.php";
        require_once("include/crypts/token.php");
        include "include/crypts/criptare.php";
        include "include/main_page/string_validation.php";
        include "include/main_page/salveaza_date_formular_register.php";
        if(isset($_SESSION['login'])) session_unset('login');
        include "include/main_page/login.php";
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

        <?php
            if(isset($MESAJ)){
                echo "<p style='color:red; font-size: 20px;'>".$MESAJ."</p>";
                if(isset($_SESSION['multiple_login'])) $_SESSION['multiple_login']++;
                else $_SESSION['multiple_login'] = 1;
            }
        ?>

        <form action="" method="post">
            <p>Nume Utilizator*: <br><input class="input-text" type="text" name="username" placeholder="Username" value="<?php echo $r_username; ?>"></p>
            <p>Parola*: <br><input class="input-text" type="password" name="pass1" placeholder="Parola"></p>
            <input type='hidden' name='token' value='<?php echo Token::generate(); ?>'>
            <?php
                if(isset($_SESSION['multiple_login']) && $_SESSION['multiple_login'] > 3)
                {
                    echo "
                    <p>Captcha*:<br>
                        <image src='include/captcha/captcha_image.php' id='captcha_image' style='width: 200px;'>
                        <img src='include/captcha/refresh.ico' onclick='".'refresh("include/captcha/captcha_image.php");'."' style='width:35px; height:35px;' alt='Alt text'>
                        <br>
                        Introduce textul din imaginea captcha *:<br>
                        <input class='input-text' type='text' name='captcha_value' placeholder='Captcha'><br>
                    </p>";
                }
            ?>
            <p><input class="button" type="submit" name="login" value="Log-in"></p>
        </form>
    </div>




</body>
</html>
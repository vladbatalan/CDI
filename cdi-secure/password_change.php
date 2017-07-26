<html>
<head>

    <?php
        include "include/connection/database.php";
        include "include/crypts/criptare.php";
        include "include/main_page/string_validation.php";
        include "include/main_page/profile_get_user.php";
        include "include/main_page/profile_pass_change.php";
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
    		if(isset($done))
    			echo "<h3 style='color:red; font-size: 20px;'>$done</h3>";
    		else{
	            if(isset($MESAJ))
	                echo "<p style='color:red; font-size: 20px;'>".$MESAJ."</p>";
	            echo "
			        <form action='password_change.php?user=$username' method='post'>
			        	<p><b>Parola veche: </b><br> <input type='password' name='old_pass' placeholder='Parola veche' class='input-text'> </p>
			        	<p><b>Parola noua: </b><br> <input type='password' name='new_pass1' placeholder='Parola noua' class='input-text'> </p>
			        	<p><b>Repeta parola noua: </b><br> <input type='password' name='new_pass2' placeholder='Parola noua' class='input-text'> </p>
			        	<p>Captcha*:<br>
			                <image src='include/captcha/captcha_image.php' id='captcha_image' style='width: 200px;'>
			                <img src='include/captcha/refresh.ico' onclick='refresh(\"include/captcha/captcha_image.php\");' style='width:35px; height:35px;' alt='Alt text'>
			                <br>
			                Introduce textul din imaginea captcha *:<br>
			                <input class='input-text' type='text' name='captcha_value'><br>
			            </p>
			            <p><button class='profile-button' type='submit' name='change_pass'> Schimba parola </button></p>
			       	</form>
		       	";
       		}
       	?>

    </div>




</body>
</html>
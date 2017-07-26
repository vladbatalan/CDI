<html>
<head>
    <?php
        include "../include/connection/database.php";
        require_once("../include/crypts/token.php");
        include "../include/admin/rol_admin_on.php";
        include "../include/main_page/string_validation.php";
        include "../include/admin/imagini_options.php";
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="../css/admin.css" rel="stylesheet" type="text/css">

    <title>Admin CDI-Centrul de documentare si informare</title>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
</body>
    <div class='left-nav'>
        <?php 
            include "../include/menus/admin-menu.php";
        ?>
    </div>
    <div class='main-container'>
        <?php
            if(isset($top_message)){
                echo "
                    <div class='top-message-box'>
                        Operațiile au fost executate cu succes!
                    </div>";
            }
        ?>
        <div class='main-active-box'>
        <h2 class='big-title'> Imagini cărți <span class='info' onclick='info_hide_display();'> [info] </span></h2>
        <div id='info-box'>
            <h3> <span class='info'> info </span> </h3>
            <h3> Gestionați imaginiile din baza de date. </h3>
            <p> Adăugați sau ștergeți imagini din baza de date. În momentul în care este ștearsă o imagine, cărțile care foloseau imaginea respectivă își vor schimba imaginea în cea care este precizată sau, daca nu este niciuna precizată, în imaginea prestabilită.
            </p>
        </div>

        <?php
            if(isset($error_message))
                echo "<span class='error'>$error_message</span>";
        ?>
        <form action='imagini.php' method='post' enctype='multipart/form-data'>
            <p>
                <b>Adaugă imagine nouă</b><br><input type='file' name='new_image' id='new_image'>
                <input type='submit' value='Adaugă' name='adauga'>
            </p>
        </form>
        
        <form action='imagini.php' method='post'>
            <p> La ștergere, înlocuiește cu:
                <div class='choose-image-container'>
                    <?php
                        $sql = "SELECT * FROM imagini";
                        $result = mysqli_query($conn, $sql);

                        while($image = mysqli_fetch_assoc($result))
                        {   
                            $checked_image = '';
                            if($image['book_image'] == 'default.png')
                                $checked_image = "checked = 'checked'";     
                            echo "
                                <div class='choose-image-box'><img src='../img/upload/".$image['book_image']."' alt='".$image['book_image']."'><br>
                                    <input type='radio' name='change_image' $checked_image value='".$image['book_image']."'>
                                </div>";
                        }
                    ?>
                </div>
            </p>


            <span>Șterge imagini</span><br>
            <div class='choose-image-expose-container'>
                <?php
                    $sql = "SELECT * FROM imagini";
                    $result = mysqli_query($conn, $sql);

                    while($image = mysqli_fetch_assoc($result))
                    {   
                        $sql = "SELECT * FROM books WHERE book_image = '".$image['book_image']."'"; 
                        $res = mysqli_query($conn, $sql);
                        $nr_books = mysqli_num_rows($res);
                        $enabled = '';
                        if($image['book_image'] == 'default.png')
                            $enabled = "disabled='disabled'";
                        echo "
                            <div class='choose-image-expose'>
                                <img src='../img/upload/".$image['book_image']."' alt='".$image['book_image']."' class='choose-image-expose-img'><br>
                                <p>Folosit la $nr_books cărți <br>
                                    <image src='../img/x-mark.png' class='seen-delete-img'><input type='checkbox' name='delete[]' value='".$image['book_image']."' $enabled>
                                </p>
                            </div>";
                    }
                ?>
                <div class='select-page'></div>
            </div>
            <input type='hidden' name='token' value='<?php echo Token::generate(); ?>'>
            <p><input type='submit' value='Produce modificări' name='modifica'></p>
        </form>
        <div class='select-page'></div>
    </div>
   
</body> 
   <script>
        function info_hide_display()
        {
            var info_box = document.getElementById("info-box");
            if(info_box.style.display == 'none')
                info_box.style.display = 'block';
            else
                info_box.style.display = 'none';
         }
    </script>
</html>
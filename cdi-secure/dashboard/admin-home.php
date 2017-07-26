<html>
<head>
    <?php
        include "../include/connection/database.php";
        include "../include/admin/rol_admin_on.php";
        include "../include/admin/refresh_database.php";
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
                        Baza de date a fost updatată cu succes!
                    </div>";
            }
        ?>
        <div class='main-active-box'>
            <h2 class='big-title'> Bine ați venit! </h2>
            <h3> Acesta este locul de unde puteți gestiona elementele de pe site-ul CDI </h3>
            <?php
                if(isset($top_message))
                    echo "<span class='error'>$top_message</span>";
            ?>

        </div>
        <div class='end-page'></div>
    </div>

   
</body> 
</html>
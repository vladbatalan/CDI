<html>
<head>
    <?php
        include "../include/connection/database.php";
        require_once("../include/crypts/token.php");
        include "../include/admin/rol_admin_on.php";
        include "../include/main_page/string_validation.php";
        include "../include/admin/categorii_options.php";
        include "../include/admin/categorii_add.php";
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
                        $top_message;
                    </div>";
            }
        ?>
        <div class='main-active-box'>  
            <h3> <span class='info' onclick='info_hide_display();'> [info] </span> </h3>
            <h2 class='big-title'> Categorii </h2>
            <div id='info-box'>
                <h3> <span class='info'> info </span> </h3>
                <h3> Gestionați categoriile cărților existente în bibliotecă. </h3>
                <p>Aici veți putea adauga sau șterge diferite categorii ale cărților. <span class='error'>ATENȚIE! </span>Categoriile care sunt folosite de anumite cărți și șterse în această platformă vor fi înlocuite cu o altă categorie. Dacă nu este precizată, aceasta va fi înlocuită cu o categorie implicită (niciuna).</p>
        </div>
        <br>

        <?php
            if(isset($error_message))
                echo "<p class='error'>$error_message</p>";
        ?>

        <form method='post' action=''>
            Adaugă o categorie nouă: <input type='text' name='new_category' placeholder="Categorie nouă">    
            <input type='submit' name='adauga' value='Adaugă categorie'>
        </form>

        <form action = '' method = 'post'>
            <p>Înlocuiește categoriile șterse cu:  
                <select name='inlocuieste_sterse'>
                    <option value='3' selected='selected'>niciuna (implicit)</option>

                    <?php
                        $sql = "SELECT * FROM categorii WHERE implicit = '0'";
                        $res = mysqli_query($conn, $sql);
                        while($catg = mysqli_fetch_assoc($res))
                        {
                            echo "<option value='".$catg['id_categorie']."'>".$catg['nume_categorie']."</option>";
                        }
                    ?>

                </select>
            </p>
            <table class='table-box-users'>
                <tr>
                    <th>Șterge</th>
                    <th>Nume categorie</th>
                    <th>Număr de cărți</th>
                </tr>

                <!-- afiseaza inainte categorie implicita -->
                <tr>
                    <td>
                        <img src='../img/x-mark.png' class='seen-delete-img'>
                        <input type='checkbox' name='delete[]' value='3' disabled='disabled'>
                    </td>

                    <td> niciuna (implicit) </td>
                    <?php
                        $sql = "SELECT * FROM books WHERE id_categorie = '3'";
                        $res = mysqli_query($conn, $sql);   

                        echo "<td>  ".mysqli_num_rows($res)." </td>";
                    ?>
                </tr>

                <!-- afiseaza celelalte categorii -->
                <?php
                    $sql = "SELECT * FROM categorii WHERE implicit != '1' ORDER BY nume_categorie ASC";
                    $search_query = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($search_query))
                    {
                        echo "<tr><td><img src='../img/x-mark.png' class='seen-delete-img'><input type='checkbox' name='delete[]' value='".$row['id_categorie']."'>
                                </td>
                        <td> ".$row['nume_categorie']." </td>";

                        $sql = "SELECT * FROM books WHERE id_categorie = '".$row['id_categorie']."'";
                        $res = mysqli_query($conn, $sql);   

                        echo "<td>  ".mysqli_num_rows($res)." </td>";

                        echo "</tr>";
                       
                    }
                    echo "</table>";
                    echo "<input type='hidden' name='token' value='".Token::generate()."'>";
                    echo "<input type='submit' name='modifica' value='Produce modificari'>";
                ?>
            </div>
        </form>

        <div class='end-page'></div>
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
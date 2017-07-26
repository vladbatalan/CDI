<html>
<head>
    <?php
        include "../include/connection/database.php";
        require_once("../include/crypts/token.php");
        include "../include/admin/rol_admin_on.php";
        include "../include/main_page/string_validation.php";
        include "../include/admin/search_users.php";
        include "../include/admin/user_options.php";
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
                        Operatiile au fost executate cu succes!
                    </div>";
            }
        ?>
        <div class='main-active-box'>
        <h2 class='big-title'> Utilizatori <span class='info' onclick='info_hide_display();'> [info] </span></h2>
        <div id='info-box'>
            <h3> <span class='info'> info </span> </h3>
            <h3> Aici puteți vizualiza utilizatorii site-ului CDI și să executați schimbari asupra rolului acestora. </h3>
            <p> Conturile de vizitatori trebuie activate în decursul unei săptamâni de la înregistrare sau vor fi șterse automat. Activarea se realizează prin prezentarea posesorului contului la administrator și a schibării rolului acestora în <b>cititor</b> (cel care are dreptul de a împrumuta cărți), <b>rezerva</b> (cel care poate rezerva săli), <b>cititor_rezerva</b> (ambele roluri mentionate anterior), sau <b>admin</b> (cel care poate face modificari în dashboard). </p>
        </div>
        <?php
            if(isset($error))
            {
                echo "<span class='error'>$error</span><br>";
            }
        ?>
        <form method='get' action=''>
            <span> Caută persoane dupa nume, prenume, username și rol: </span><br>
            <input type='text' name='search_user' placeholder='Cauta' autocomplete="off">
            <input type='submit' name='search' value='cauta'><br><br>
            <div class='select-page'>
                <?php
                    // instructiunea de cautare pentru a afla mai repede numarul de pagini necesare
                    $sql = "SELECT * FROM users WHERE (username LIKE '%".$get_search."%' OR nume LIKE '%".$get_search."%' OR prenume LIKE '%".$get_search."%' OR rol LIKE '".$get_search."')";
                    if(isset($_GET['new_users']) && !empty($_GET['new_users']))
                        $sql .= " AND confirmed LIKE '0'";
                    $sql .= " ORDER BY username ASC";

                    $search_query = mysqli_query($conn, $sql);

                    // paginile
                    $nr_de_pagini = (int)((mysqli_num_rows($search_query) - 1) / 20) + 1;
                    $current_page = 1;
                    if(isset($_GET['page'])) $current_page = verifica($_GET['page']);


                    $vars_added = '';
                    $elem_added = 0;
                    if(isset($_GET['search_user'])){
                        $vars_added .= "search_user=".verifica($_GET['search_user']);
                        $elem_added ++;
                    }
                    if(isset($_GET['search'])){
                        if($elem_added > 0)
                            $vars_added .= "&";
                        $vars_added .= "search=".verifica($_GET['search']);
                        $elem_added ++;
                    }
                    if(isset($_GET['new_users'])){
                        if($elem_added > 0)
                            $vars_added .= "&";
                        $vars_added .= "new_users=".verifica($_GET['new_users']);
                        $elem_added ++;
                    }
                    if($elem_added > 0)
                    {
                        $vars_added = "&".$vars_added;
                    }
                    for($i = 1; $i <= $nr_de_pagini && $nr_de_pagini > 1; $i++)
                    {
                        $class = '';
                        if($i == $current_page) $class = "class='active-select-page'";
                        echo "<a href='utilizatori.php?page=$i$vars_added' $class>$i</a> ";
                    }
                ?>
            </div>

            <?php
                $sql = "SELECT * FROM users WHERE confirmed = '0'";
                $rezultat = mysqli_query($conn, $sql);
                if(mysqli_num_rows($rezultat) > 0){
                    $expr = 'conturi neverificate';
                    if(mysqli_num_rows($rezultat) == 1)
                        $expr = 'cont neverificat';
                    echo "
                        <div class='new-user-box'>
                           <button type='submit' name='new_users' class='invisible-button' value='".mysqli_num_rows($rezultat)."'>Aveti ".mysqli_num_rows($rezultat)." $expr!<span class='new-user-simbol'>New!</span></button>
                        </div>
                    ";
                }
            ?> 

        <table class='table-box-users'>
            </form>
            <tr>
                <th>Sterge</th>
                <th>User</th>
                <th>Nume</th>
                <th>Prenume</th>
                <th>Rol</th>
                <th>Clasa</th>
                <th>Data inregistrare</th>
            </tr>
            <?php
                echo "<form action='' method='post'>";

                $numar_afisari = -1;
                $nr_pagina = 1;
                while($row = mysqli_fetch_assoc($search_query))
                {
                    $numar_afisari ++;
                    if($numar_afisari == 20)
                    {
                        $nr_pagina ++;
                        $numar_afisari = 0;
                    }
                    if($nr_pagina != $current_page) continue;
                    $add_new = '';
                    //reda culoarea randului in caz ca este utiizator nou
                    if($row['confirmed'] == 0)
                        echo "<tr class='new-user'>";
                    else
                        echo "<tr>";

                    //administratorii supremi nu pot fi modificati cu nimic si de nimeni
                    if($row['id_user'] == $_SESSION['login']['id_user'] || $row['rol'] == 'admin_suprem' || ($row['rol'] == 'admin' && $_SESSION['login']['rol'] == 'admin'))
                        echo "<td><img src='../img/x-mark.png' class='seen-delete-img'><input type='checkbox' disabled='disabled'></td>";
                    else
                        echo "<td><img src='../img/x-mark.png' class='seen-delete-img'><input type='checkbox' name='delete[]' value='".$row['id_user']."'></td>";
                        

                    echo "  <td>".$row['username']."</td>
                            <td>".$row['nume']."</td>
                            <td>".$row['prenume']."</td>";
                    if($row['id_user'] == $_SESSION['login']['id_user'] || $row['rol'] == 'admin_suprem' || ($row['rol'] == 'admin' && $_SESSION['login']['rol'] == 'admin'))
                    {
                        echo "<td>".$row['rol']."</td>";
                    }
                    else
                    {
                        //nu mi da voie sa fac modificari in dreptul contului meu
                        echo "<td> <select name='".$row['id_user']."select'> <option selected='selected' value='".$row['rol']."'>".$row['rol']."</option>";
                        $sql = "SELECT * FROM roluri WHERE rol NOT LIKE '".$row['rol']."'";
                        $rezultat = mysqli_query($conn, $sql);
                        while($rol = mysqli_fetch_assoc($rezultat))
                        {
                            if($rol['rol'] == 'admin')
                            {
                                if($_SESSION['login']['rol'] == 'admin_suprem')
                                {
                                    echo "<option value='".$rol['rol']."'>".$rol['rol']."</option>";
                                }
                            }
                            else
                            {
                                if($rol['rol'] != 'admin_suprem'){
                                    echo "<option value='".$rol['rol']."'>".$rol['rol']."</option>";
                                }
                            }
                           
                        }
                        echo "</select></td>";
                    }
                    echo"<td>"; 
                    // nu permite schimbarea clasei la adminii supremi

                    if(($row['rol'] == 'admin_suprem' && $_SESSION['login']['rol'] == 'admin') || ($row['rol'] == 'admin' && $_SESSION['login']['rol'] == 'admin'))
                        echo $row['clasa'];
                    else
                        echo "<input type='text' name='".$row['id_user']."clasa' value='".$row['clasa']."' placeholder='clasa' class='small-input'>";
                    echo"</td>
                            <td>".$row['data_realizarii']."</td>
                        </tr>
                    ";
                }
                echo "</table>";
                echo "<input type='hidden' name='token' value='".Token::generate()."'";
                echo "<input type='submit' name='modifica' value='Produce modificari'>";
                echo "</form>";
            ?>
        </div>
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
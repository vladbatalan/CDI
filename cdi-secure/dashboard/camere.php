<html>
<head>
    <?php
        include "../include/connection/database.php";
        require_once("../include/crypts/token.php");
        include "../include/main_page/string_validation.php";
        include "../include/admin/rol_admin_on.php";
        include "../include/admin/camere_options.php";
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
        <h2 class='big-title'> Camere <span class='info' onclick='info_hide_display();'> [info] </span></h2>
        <div id='info-box'>
            <h3> <span class='info'> info </span> </h3>
            <h3> Aici puteți vizualiza modificările care se realizează in cadrul rezervărilor diferitelor săli și eventual să anulați unele rezervări nedorite. </h3>
            <p> Utilizați câmpurile pentru filtrare ale informațiilor pentru a găsi mai ușor rezervări realizate și pentru a le șterge sau a le vedea. Pentru a vizualiza rezervările noi apasați pe bara de deasupra tabelului (dacă apare). Dacă doriți să filtrați numai rezervarile noi, cand completați câmpurile de filtrare, apasați pe bara care indică cate rezervari noi sunt (bara de deasupra tabelului).</p>
        </div>
        <div class='search-container'>
        <h3> Filtrează rezervările: </h3>
            <form method='get' action=''>
                <p> Sala: <br>
                <select name='camera'>
                    <option value=''> -- alege o sala -- </option>
                    <?php 
                        // daca exista camera
                        $exista_get = 0;
                        if(isset($_GET['camera']))
                        {
                            $sql = "SELECT * FROM rooms WHERE id_room = '".$_GET['camera']."'";
                            $rezultat = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($rezultat) > 0)
                            {
                                $exista_get = 1;
                                //afiseaza optiunile 
                                $rooms = mysqli_fetch_assoc($rezultat);
                                echo "<option value='".$rooms['id_room']."' selected='selected'>".$rooms['nume']."</option>";
                                //selecteaza toate camerele cu exceptia celei alese si afiseaza optiunile
                                $sql = "SELECT * FROM rooms WHERE id_room NOT LIKE '".$_GET['camera']."'";
                                $rezultat = mysqli_query($conn, $sql);
                                while($rooms = mysqli_fetch_assoc($rezultat))
                                {
                                    echo "<option value='".$rooms['id_room']."'>".$rooms['nume']."</option>";
                                }
                            }
                        }
                        if($exista_get == 0)
                        {
                            // daca nu exista un get sau este gresit afiseaza toate optiunile
                            $sql = "SELECT * FROM rooms ORDER BY nume ASC";
                            $rezultat = mysqli_query($conn, $sql);
                            while($rooms = mysqli_fetch_assoc($rezultat))
                            {
                                echo "<option value='".$rooms['id_room']."'>".$rooms['nume']."</option>";
                            }
                        }
                    ?>
                </select>
                </p>
                <p> Data rezervării: <br>
                <select name='data_rezervarii'>
                    <option value=''> -- alege o dată -- </option>
                    <?php
                        // se aleg datele din ultimele 3 saptamani
                        $zile = array("Duminica", "Luni" ,"Marti","Miercuri","Joi","Vineri","Sambata");
                        $astazi = date("Y-m-d");
                        $inceput = date("Y-m-d", strtotime($astazi));
                        $ziua_saptamanii = date("w", strtotime($inceput));
                        while($ziua_saptamanii != 1) 
                        {
                            $your_date = strtotime("-1 day", strtotime($inceput));
                            $inceput = date('Y-m-d', $your_date);
                            $ziua_saptamanii = date("w", strtotime($inceput));
                        }
                        $your_date = strtotime("-1 day", strtotime($inceput));
                        $inceput = date('Y-m-d', $your_date);
                        $ziua_saptamanii = date("w", strtotime($inceput)); 
                        while($ziua_saptamanii != 1) 
                        {
                            $your_date = strtotime("-1 day", strtotime($inceput));
                            $inceput = date('Y-m-d', $your_date);
                            $ziua_saptamanii = date("w", strtotime($inceput));
                        }

                        $index_zi = $inceput;

                        // alegem data care este selectata daca exista un get pentru data_rezervarii
                        $selected = 'nada data';
                        if(isset($_GET['data_rezervarii']))
                        {
                            $selected = $_GET['data_rezervarii'];
                        }
                        echo "<optgroup label='Saptamana anterioara'>";
                        for($i = 1; $i<=7; $i++)
                        {
                            $ziua_saptamanii = date("w", strtotime($index_zi));
                            $index_zi_to_dmy = date("d-m-Y", strtotime($index_zi));
                            
                            echo "<option value = '$index_zi'";
                            if($index_zi == $selected) echo " selected='selected'";
                            echo ">$index_zi_to_dmy $zile[$ziua_saptamanii]</option>";
                            $your_date = strtotime("+1 day", strtotime($index_zi));
                            $index_zi = date('Y-m-d', $your_date);
                        }

                        echo "</optgroup>";
                        echo "<optgroup label='Saptamana 1'>";
                        $saptamana = 1;
                        for($i = 1; $i<=21; $i++)
                        {
                            $ziua_saptamanii = date("w", strtotime($index_zi));
                            $index_zi_to_dmy = date("d-m-Y", strtotime($index_zi));
                            if($i % 7 == 1 && $i != 1)
                            {
                                $saptamana ++;
                                echo "</optgroup>
                                    <optgroup label='Saptamana ".$saptamana."'>";
                            }
                            echo "<option value = '$index_zi'";
                            if($index_zi == $selected) echo " selected='selected'";
                            echo ">$index_zi_to_dmy $zile[$ziua_saptamanii]</option>";
                            $your_date = strtotime("+1 day", strtotime($index_zi));
                            $index_zi = date('Y-m-d', $your_date);
                        }
                        echo "</optgroup>";
                    ?>
                </select>
                </p>
                <p> Ora rezervării:<br>
                <select name='ora_rezervarii'>
                    <option value=''> -- alege o oră -- </option>
                    <?php
                        //alegem orele intre 08:00 si 19:00
                        for($ora = 8; $ora <= 19; $ora ++)
                        {
                            //formatam ora sa apara 0 in fata daca e doar uc o cifra
                            $ora_show = $ora;
                            $next_ora_show = $ora + 1;
                            if($ora < 10)
                                $ora_show = '0'.$ora;
                            if($ora + 1 < 10)
                            $next_ora_show = '0'.$next_ora_show;

                            //daca primit ora salvam in ora_primita
                            $ora_primita = 1000000;
                            if(isset($_GET['ora_rezervarii']))
                            {
                                $ora_primita = $_GET['ora_rezervarii'];
                            }

                            //afisam optiunea
                            echo "<option value='$ora'";
                            if($ora == $ora_primita) echo " selected='selected'";
                            echo">$ora_show:00 - $next_ora_show:00</option>";
                        }

                    ?>
                </select>
                </p>
                <p>Caută date persoană:<br><input type='text' name='user_rezervare' placeholder='Date persoana'<?php if(isset($_GET['user_rezervare'])) echo "value='".$_GET['user_rezervare']."'"; ?> ></p>
                <p><br><input type='submit' name='search' value='Cauta'></p>
            
        </div>

        <?php
            //daca sunt primite locuri de cautare formeaza text de cautare sql
            $sql_text = " WHERE";
            $found_get = 0;
            if(isset($_GET['camera']) && !empty($_GET['camera']))
            {
                if($found_get)
                    $sql_text .= " AND";
                $found_get = 1;
                $sql_text .= " id_room = '".verifica($_GET['camera'])."'";
            }
            if(isset($_GET['data_rezervarii']) && !empty($_GET['data_rezervarii']))
            {
                if($found_get)
                    $sql_text .= " AND";
                $found_get = 1;
                $sql_text .= " data = '".verifica($_GET['data_rezervarii'])."'";
            }
            if(isset($_GET['ora_rezervarii']) && !empty($_GET['ora_rezervarii']))
            {
                if($found_get)
                    $sql_text .= " AND";
                $found_get = 1;
                $sql_text .= " ora = '".verifica($_GET['ora_rezervarii'])."'";
            }
            if(isset($_GET['new_rooms']) && !empty($_GET['new_rooms']))
            {
                if($found_get)
                    $sql_text .= " AND";
                $found_get = 1;
                $sql_text .= " confirmed = '0'";
            }
            if(isset($_GET['user_rezervare']) && !empty($_GET['user_rezervare']))
            {
                $both = 0;
                $usr = verifica($_GET['user_rezervare']);
                $sql = "SELECT * FROM users WHERE username = '$usr' OR nume = '$usr' OR prenume = '$usr'";
                $res = mysqli_query($conn, $sql);
                if(mysqli_num_rows($res) > 0)
                {
                    if($found_get)
                        $sql_text .= " AND";
                    $found_get = 1;
                    if($both == 0){
                        $sql_text .= " (";
                        $both = 1;
                    }
                    $first = 0;
                    while($usrs = mysqli_fetch_assoc($res))
                    {
                        $first ++;
                        if($first != 1)
                            $sql_text .= " OR";
                        $sql_text .= " id_user = '".$usrs['id_user']."'";
                    }
                }
                //cautam si dupa profesor supraveghetor
                if($both == 1)
                    $sql_text .= " OR";
                else{
                    if($found_get == 1)
                        $sql_text .= " AND";
                }
                $found_get = 1;
                $sql_text .= " profesor = '".$usr."'";
                if($both == 1)
                    $sql_text .= " )";
            }
            if(!$found_get)
                $sql_text = '';
        ?>

         <div class='select-page'>
                <?php
                    // instructiunea de cautare pentru a afla mai repede numarul de pagini necesare
                    $sql = "SELECT * FROM rezervari_camere".$sql_text." ORDER BY data DESC, id_room, ora ASC";
                    $search_query = mysqli_query($conn, $sql);

                    // paginile
                    $nr_de_pagini = (int)((mysqli_num_rows($search_query) - 1) / 20) + 1;
                    $current_page = 1;
                    if(isset($_GET['page'])) $current_page = $_GET['page'];


                    $vars_added = '';
                    $elem_added = 0;
                    if(isset($_GET['camera'])){
                        $vars_added .= "camera=".$_GET['camera'];
                        $elem_added ++;
                    }
                    if(isset($_GET['data_rezervarii'])){
                        if($elem_added > 0)
                            $vars_added .= "&";
                        $vars_added .= "data_rezervarii=".$_GET['data_rezervarii'];
                        $elem_added ++;
                    }
                    if(isset($_GET['ora_rezervarii'])){
                        if($elem_added > 0)
                            $vars_added .= "&";
                        $vars_added .= "ora_rezervarii=".$_GET['ora_rezervarii'];
                        $elem_added ++;
                    }
                    if(isset($_GET['user_rezervare'])){
                        if($elem_added > 0)
                            $vars_added .= "&";
                        $vars_added .= "user_rezervare=".$_GET['user_rezervare'];
                        $elem_added ++;
                    }
                    if(isset($_GET['search'])){
                        if($elem_added > 0)
                            $vars_added .= "&";
                        $vars_added .= "search=".$_GET['search'];
                        $elem_added ++;
                    }
                    if(isset($_GET['new_rooms'])){
                        if($elem_added > 0)
                            $vars_added .= "&";
                        $vars_added .= "new_rooms=".$_GET['new_rooms'];
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
                        echo "<a href='camere.php?page=$i$vars_added' $class>$i</a> ";
                    }
                ?>
            </div>

        <?php
            //daca sunt care nu s vazuti afiseaza bara de persoane noi
            $sql = "SELECT * FROM rezervari_camere WHERE confirmed = '0'";
            $rezultat = mysqli_query($conn, $sql);
            if(mysqli_num_rows($rezultat) > 0){
                $expr = 'rezervari noi realizate';
                if(mysqli_num_rows($rezultat) == 1)
                    $expr = 'rezervare noua realizata';
                echo "
                    <div class='new-user-box'>
                        <button type='submit' name='new_rooms' class='invisible-button' value='".mysqli_num_rows($rezultat)."'>Aveti ".mysqli_num_rows($rezultat)." $expr!<span class='new-user-simbol'>New!</span></button>
                    </div>
                ";
            }
            echo "</form>";
        ?>
        <form action='' method='post'>
            <table class='table-box-users'>
                <tr>
                    <th>Acțiune</th>
                    <th>Sală</th>
                    <th>Dată</th>
                    <th>Oră</th>
                    <th>Persoană responsabilă</th>
                    <th>User</th>
                    <th>Nume Prenume</th>
                </tr>
                <?php
                    //daca s a accesat new_rooms cautam doar cele neconfirmate
                    $sql = "SELECT * FROM rezervari_camere".$sql_text." ORDER BY data DESC, id_room, ora ASC";
                    $res = mysqli_query($conn, $sql);

                    $numar_afisari = -1;
                    $nr_pagina = 1;

                    while($rezerv = mysqli_fetch_assoc($res))
                    {
                        $numar_afisari ++;
                        if($numar_afisari == 20)
                        {
                            $nr_pagina ++;
                            $numar_afisari = 0;
                        }
                        if($nr_pagina != $current_page) continue;
                        //zilele saptamanii
                        $zile = array("Duminica", "Luni" ,"Marti","Miercuri","Joi","Vineri","Sambata");

                        //alegem date utilizator

                        $sql = "SELECT * FROM users WHERE id_user = '".$rezerv['id_user']."'";
                        $raspuns = mysqli_query($conn, $sql);
                        $user = mysqli_fetch_assoc($raspuns);

                        //alegem camera
                        $sql = "SELECT * FROM rooms WHERE id_room = '".$rezerv['id_room']."'";
                        $raspuns = mysqli_query($conn, $sql);
                        $camera = mysqli_fetch_assoc($raspuns);

                        $ora_act = $rezerv['ora'];
                        $ora_next = $rezerv['ora'] + 1;

                        if($ora_act < 10) $ora_act = '0'.$ora_act;
                        if($ora_next < 10) $ora_next = '0'.$ora_next;

                        if($rezerv['confirmed'] == 0){
                            echo "<tr class='new-user'>";
                            echo "
                            <td class='action-box'>
                                <img src='../img/Bifat.png' class='seen-delete-img'><input type='checkbox' name='vazut[]' value='".$rezerv['id_rezervare']."'>
                                <img src='../img/x-mark.png' class='seen-delete-img'><input type='checkbox' name='action[]' value='".$rezerv['id_rezervare']."'><br>
                            </td>";
                        }
                        else{
                            echo "<tr>";
                            echo "<td><img src='../img/x-mark.png' class='seen-delete-img'><input type='checkbox' name='action[]' value='".$rezerv['id_rezervare']."'></td>";
                        }
                        $ziua_saptamanii = date("w", strtotime($rezerv['data']));

                        echo "<td>".$camera['nume']."</td>";
                        echo "<td>".date("d-m-Y", strtotime($rezerv['data']))." ".$zile[$ziua_saptamanii]."</td>";
                        echo "<td>$ora_act:00 - $ora_next:00</td>";
                        echo "<td>".$rezerv['profesor']."</td>";
                        echo "<td>".$user['username']."</td>";
                        echo "<td>".$user['nume']." ".$user['prenume']."</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <input type='submit' name='modifica' value='Produce modificari'>
        </form>

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
<html>
<head>
    <?php
        include "../include/connection/database.php";
        require_once("../include/crypts/token.php");
        include "../include/admin/rol_admin_on.php";
        include "../include/main_page/string_validation.php";
        include "../include/admin/rezervari_carti_search.php";
        include "../include/admin/rezervari_carti_options.php";
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
        <h2 class='big-title'> Rezervări cărți <span class='info' onclick='info_hide_display();'> [info] </span></h2>
        <div id='info-box'>
            <h3> <span class='info'> info </span> </h3>
            <h3> Aici puteți vizualiza rezervările de cărți realizate. </h3>
            <p> Procesul de rezervare pentru o anumită carte sau mai multe cărți începe în mediul online. Elevii care au cont cu rol de <b>cititor</b> sau de <b>cititor_rezerva</b> care au facut rezervări vor fi afișați cu <span class='new-user'>fundal verde</span>. În momentul în care aceștia se prezintă la CDI să ceară cartea, rezervările vor fi confirmate de către dumneavoastră. În cazul în care o carte este împrumutată și expiră data împrumutului, aceste înregistrări vor fi afișate cu <span class='expired-user'>fundal roșu</span> pentru a vă atenționa, iar când deținătorul temporar se prezintă să înapoieze cartea, veți șterge înregistrarea corespondentă. </p>
            <p> Când veți împrumuta o carte, data înregistrării va fi schimbată pe data când a fost împrumutată cartea. Când un împrumut expiră, data înregistrării acestuia va fi updatată în ziua respectivă </p>
        </div>
        <br>

        <?php
            if(isset($error))
                echo "<span class='error'>$error</span>";
        ?>

        <span> Caută rezervări după utilizatori, titlu, autor, starea rezervării și dată: </span><br>
        <div class='search-container'>
            <form method='get' action=''>
                <p><input type='text' name='user' placeholder='Utilizator' <?php echo "value='$get_user'"; ?>></p>
                <p><input type='text' name='titlu' placeholder='Titlu' <?php  echo "value='$get_titlu'"; ?>></p>
                <p><input type='text' name='autor' placeholder='Autor' <?php  echo "value='$get_autor'";  ?>></p>
                <p><select name='tip_cautat' class='input-text'>
                        <option value='' <?php if(empty($get_tip)) echo "selected='selected'"; ?>> --starea rezervării-- </option>
                        <option value='rezervate' <?php if($get_tip == 'rezervate') echo "selected='selected'";  ?>> Rezervate </option>
                        <option value='imprumutate' <?php if($get_tip == 'imprumutate') echo "selected='selected'";  ?>> Împrumutate </option>
                        <option value='expirate' <?php if($get_tip == 'expirate') echo "selected='selected'";  ?>> Expirate </option>
                    </select>
                </p>
                <p><select name='data' class='input-text'>
                        <option value=''> --data rezervării-- </option>
                        <?php
                            $zile = array("Duminica", "Luni" ,"Marti","Miercuri","Joi","Vineri","Sambata");

                            $sql = 'SELECT * FROM rezervari_carti ORDER BY data_rezervarii ASC';
                            $res = mysqli_query($conn, $sql);
                            $last_date = '';

                            while($rezervare = mysqli_fetch_assoc($res))
                            {
                                $checked = '';
                                if($rezervare['data_rezervarii'] != $last_date)
                                {
                                    $last_date = $rezervare['data_rezervarii'];
                                    $ziua_sapt = date("w", strtotime($last_date));
                                    if($last_date == $get_data) $checked = "selected='selected'";
                                    echo "<option value='".$last_date."' $checked>".date("d-m-Y", strtotime($last_date))." ".$zile[$ziua_sapt]."</option>";
                                }
                            }
                        ?>
                    </select>
                </p>
        </div>
        <input type='submit' name='search' value='cauta'><br><br>
        </form>
        
        <form action='<?php echo "rezervari_carti.php?user=$get_user&titlu=$get_titlu&autor=$get_autor&tip_cautat=$get_tip&data=$get_data&search=cauta"; ?>' method='post'>
            <input type='hidden' name='token' value='<?php echo Token::generate(); ?>'>
            <table class='table-box-users'>
                <tr>
                    <th>Acțiune</th>
                    <th>User</th>
                    <th>Titlu</th>
                    <th>Autor</th>
                    <th>Rămase</th>
                    <th>Data rezervării</th>
                </tr>
                <?php
                    $rezultat = mysqli_query($conn, $sql_search);
                    while($rezervare = mysqli_fetch_assoc($rezultat))
                    {
                        $sql = "SELECT * FROM users WHERE id_user = '".$rezervare['id_user']."'";
                        $res = mysqli_query($conn, $sql);
                        $user = mysqli_fetch_assoc($res);

                        $sql = "SELECT * FROM books WHERE id_book = '".$rezervare['id_book']."'";
                        $res = mysqli_query($conn, $sql);
                        $book = mysqli_fetch_assoc($res);

                        $type = '';
                        if($rezervare['confirmed'] == 0){
                            $type = " class='new-user'";
                            $actions = "
                            <button type='submit' name='confirmat".$rezervare['id_rezervare']."'><img src='../img/Bifat.png' class='seen-delete-img'></button>
                            <button type='submit' name='sterge".$rezervare['id_rezervare']."'><img src='../img/x-mark.png' class='seen-delete-img'></button>";
                        }
                        if($rezervare['confirmed'] == 2){
                            $type = " class='expired-user'";
                            $actions = "
                            <button type='submit' name='confirmat".$rezervare['id_rezervare']."'><img src='../img/Bifat.png' class='seen-delete-img'></button>";
                        }
                        if($rezervare['confirmed'] == 1){
                            $actions = "
                            <button type='submit' name='confirmat".$rezervare['id_rezervare']."'><img src='../img/Bifat.png' class='seen-delete-img'></button>";
                        }

                        echo "
                        <tr $type>
                            <td class='action-box'>
                                $actions
                            </td>
                            <td>".$user['username']."</td>
                            <td class='book-title'><a href='detalii_carte.php?id_book=".$book['id_book']."' target='_blank'>".$book['titlu']."</a></td>
                            <td>".$book['autor']."</td>
                            <td>".($book['stoc']-$book['imprumutate'])."/".$book['stoc']."</td>
                            <td>".$rezervare['data_rezervarii']."</td>
                        </tr>
                        ";
                    }

                ?>
            </table>
        </form>
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
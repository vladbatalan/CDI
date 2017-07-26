<html>
<head>
    <?php
        include "../include/connection/database.php";
        require_once("../include/crypts/token.php");
        include "../include/main_page/string_validation.php";
        include "../include/admin/rol_admin_on.php";
        include "../include/admin/filtru_carti.php";
        include "../include/carti/carti_options.php";
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
        <h2 class='big-title'> Cărți <span class='info' onclick='info_hide_display();'> [info] </span></h2>
        <div id='info-box'>
            <h3> <span class='info'> info </span> </h3>
            <h3> Aici puteți vizualiza cărțile din baza de date și puteți efectua schimbari.</h3>
            <p> Folosiți filterele pentru a căuta mai ușor carți în baza de date. Efectuați direct modificări schimbând datele din tabel sau vizualizați o anumită carte individual apăsând pe "Detalii carte" din coloana din dreapta. </p>
        </div>
        <br>
        
        <!-- bara de cautare -->
        <span> Caută cărți după titlu, autor, categorie: </span><br>
        <div class='search-container'>
            <form method='get' action=''>
                <p><input type='text' name='titlu' placeholder='Titlu' <?php if(isset($titlu_primit)) echo "value='$titlu_primit'"; ?> ></p>
                <p><input type='text' name='autor' placeholder='Autor' <?php if(isset($autor_primit)) echo "value='$autor_primit'"; ?> ></p>
                <p><select name='categorie' class='input-text'>
                    <option value=''> --alege o categorie-- </option>
                    <?php
                        $sql = "SELECT * FROM categorii ORDER BY nume_categorie ASC";
                        $res = mysqli_query($conn, $sql);
                        while($categorie = mysqli_fetch_assoc($res))
                        {
                            $selected_value = '';
                            if($categorie_primita == $categorie['id_categorie']) $selected_value = "selected = 'selected'";
                            echo "<option value='".$categorie['id_categorie']."' ".$selected_value."> ".$categorie['nume_categorie']." </option>";
                        }
                    ?>
                </select></p>
        </div>
        <input type='submit' name='search' value='cauta'><br><br>
        </form>


        <form action='<?php echo $link; ?>' method='post'>
	        <table class='book-container'>
	            <tr>
	                <th>Imagine</th>
	                <th>Titlu</th>
	                <th>Autor</th>
	                <th>Categorie</th>
	                <th>Stoc</th>
	                <th>Descriere</th>
	                <th>Detalii</th>
	            </tr>
	            <?php
	                //fixeaza categoriile
	                $categorie = array();
	                $sql = "SELECT * FROM categorii";
	                $result = mysqli_query($conn, $sql);
	                while($row = mysqli_fetch_assoc($result))
	                {
	                    $categorie[$row['id_categorie']] = $row['nume_categorie'];
	                }

	                $sql = "SELECT * FROM books".$filtru." ORDER BY titlu, autor, id_categorie ASC";
	                $result = mysqli_query($conn, $sql);
	                while($carte = mysqli_fetch_assoc($result))
	                {
	                    echo "
	                        <tr>
	                            <td>";
	                            	//<div class='image-upload'>
									//    <label for='file-input'>
									//       <img src='../img/upload/".$carte['book_image']."' class='book-img-small'>
									//    </label>
									//    <input id='file-input' type='file'/>
									//</div>
	                    echo "      <img src='../img/upload/".$carte['book_image']."' class='book-img-small'>
	                            </td>
	                            <td><input type='text' value='".$carte['titlu']."' name='titlu".$carte['id_book']."'></td>
	                            <td><input type='text' value='".$carte['autor']."' name='autor".$carte['id_book']."'></td>
	                            <td><select name='categorie".$carte['id_book']."'> 
		                            <option selected='selected' value='".$carte['id_categorie']."'>".$categorie[$carte['id_categorie']]."</option>";
		                            $sql = "SELECT * FROM categorii WHERE id_categorie != '".$carte['id_categorie']."' ORDER BY nume_categorie ASC";
		                            $rezultat = mysqli_query($conn, $sql);
		                            while($catg = mysqli_fetch_assoc($rezultat))
		                            {
		                            	echo "<option value='".$catg['id_categorie']."'>".$catg['nume_categorie']."</option>";
		                            }
	                            echo "
	                            </select></td>
	                            <td><input type='number' value='".$carte['stoc']."' min='".$carte['imprumutate']."' name='stoc".$carte['id_book']."'></td>
	                            <td>
	                            	<div class='book-details'>".$carte['descriere']."</div>
	                            </td>
	                            <td> <a href='detalii_carte.php?id_book=".$carte['id_book']."'>Detalii carte</a></td>
	                        </tr>
	                    ";
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
<html>
<head>

    <?php
	    include "../connection/database.php";
        include "../main_page/string_validation.php";
        include "primeste_filtru.php";
    ?>

    <link rel="stylesheet" href="../../css/login-register.css">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CDI-Centrul de documentare si informare</title>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
</body>
    <div class="menu">
        <ul>
            <li>
                <a href="../../index.php"> Acasa </a>
            </li>
        </ul>
    </div>
    <div class="main-container">
        <label>
            <h2> Cauta carti </h2>
            <form method='get' action='Book_arhive.php'>
                <p>Titlul:<br><input type='text' placeholder='Titlu' name='titlu' class='input-text' <?php echo "value='".$titlu_primit."'"; ?>> </p>
                <p>Autor:<br><input type='text' placeholder='Autor' name='autor' class='input-text' <?php echo "value='".$autor_primit."'"; ?>></p>
                <p>Categorie:<br> 
                <select name='categorie' class='input-text'>
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
                <p><input type='submit' class='button' name='search' value='Cauta'></p>
            </form>
        </label>

        <div>
	       	<div class='book_container'>
		        <?php
		            $sql = "SELECT * FROM books".$filtru_adaugare." ORDER BY titlu ASC";
		            $result = mysqli_query($conn, $sql);
		            if(mysqli_num_rows($result)>0)
		            {
		                while($row = mysqli_fetch_assoc($result))
		                {
		                    $sql = "SELECT * FROM categorii WHERE id_categorie = '".$row['id_categorie']."'";
		                    $sql_res = mysqli_query($conn, $sql);
		                    $categorie_nume = mysqli_fetch_assoc($sql_res);

                            $rez_det = '';
		                    if(isset($_SESSION['login'])){
	                            $sql = "SELECT * FROM rezervari_carti WHERE id_user = '".$_SESSION['login']['id_user']."' AND id_book = '".$row['id_book']."'";
	                            $rez = mysqli_query($conn, $sql);
	                            if(mysqli_num_rows($rez) > 0)
	                            {   
	                                $rez_carte = mysqli_fetch_assoc($rez);
	                                if($rez_carte['confirmed'] == 0)
	                                    $rez_det = "<p class='carte-rezervata'>Rezervata</p>";
	                                else{
	                                    $rez_det = "<p class='carte-rezervata'>Detinuta</p>";
	                                }
	                            }
	                        }

                            echo "
                            <div class='book_box'>
                                <img src='../../img/upload/".$row['book_image']."' class='book_img'>
                                $rez_det
                                <h2>\"".$row['titlu']."\" - ".$row['autor']."</h2>
                                <p> Descriere: <i> ".$row['descriere']." </i></p>
                                <p>Au mai ramas: ".$row['stoc']." carti</p>
                                <p class='book-category'> ".$categorie_nume['nume_categorie']." </p>
                                <p>
                                    <form action='Borrow_formular.php?id_book=".$row['id_book']."' method='post'>   
                                        <input type='submit' value='Rezerva' name = 'imprumut' class='button'> 
                                    </form>
                                </p>
                            </div>";
		                }
		            }
		            else
		                echo "Nu este nici o carte inregistrata in baza de date";
		        ?>
		   	</div>
        </div>
    </div>

   
</body> 
</html>
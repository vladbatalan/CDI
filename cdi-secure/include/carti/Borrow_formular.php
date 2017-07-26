
<?php
    include "../connection/database.php";
    require_once("../crypts/token.php");
    include "verifica_id_book.php";
    include "rezerva_carte.php";
?>

<html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CDI-Centrul de documentare si informare</title>

    <link rel="stylesheet" href="../../css/login-register.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src='../../js/captcha.js'></script>

</head>
<body>
	<div class="menu">
        <ul>
            <li>
                <a href="Book_arhive.php"> Bibliotecă </a>
            </li>
        </ul>
    </div>		   
    <div class="main-container">
        <?php
            if(isset($MESAJ)){
                echo "<h3 class='error'>".$MESAJ."</h3>";
            }
            else
            {
                if(isset($done))
                    echo "<h3 class='error'>$done</h3>";

                //alege categorii
                $sql = "SELECT * FROM categorii WHERE id_categorie = '".$book_details['id_categorie']."'";
                $rezultat = mysqli_query($conn, $sql);
                $categorie = mysqli_fetch_assoc($rezultat);
                echo "
                <div class='borrow-book-box'>
                    <img src='../../img/upload/".$book_details['book_image']."' class='borrow-book-img'>
                    <h2>\"".$book_details['titlu']."\" - ".$book_details['autor']."</h2>
                    <p><b>Descriere:</b> <i> ".$book_details['descriere']." </i></p>
                    <p><b>Au mai ramas:</b> ".$book_details['stoc']." carti</p>
                    <p><b>Categorie:</b> ".$categorie['nume_categorie']." </p>
                </div>";

                //verifica daca aceasta carte a mai fost rezervata de catre aceasta persoana sau chiar detinuta
                $sql = "SELECT * FROM rezervari_carti WHERE id_user = '".$_SESSION['login']['id_user']."' AND id_book = '".$book_details['id_book']."'";
                $rezultat = mysqli_query($conn, $sql);
                if(mysqli_num_rows($rezultat) == 0)
                {
                    //afiseaza formular
                    echo "<p class='error'> $form_error </p>";

                    echo "
                    <div class='borrow-book-formular'>
                        <h3> Daca doriti sa rezervati cartea, completati codul captcha si prezentati-va la CDI in decursul a 7 zile de la semnarea intentiei de rezervare</h3>
                        <form method='post' action='Borrow_formular.php?id_book=".$book_details['id_book']."'>
                                <p>Captcha*:<br>
                                    <image src='../captcha/captcha_image.php' id='captcha_image' style='width: 200px;'>
                                    <img src='../captcha/refresh.ico' onclick='refresh(\"../captcha/captcha_image.php\");' style='width:35px; height:35px;' alt='Alt text'>
                                    <br>
                                    Introduce textul din imaginea captcha *:<br>
                                    <input class='input-text' type='text' name='captcha_value'><br>
                                </p>
                                <input type='hidden' name='token' value='".Token::generate()."'>
                                <input type='submit' name='finiseaza_rezervarea' value='Rezerv aceasta carte!' class='button'>
                        </form>
                    </div>
                    ";
                }
                else
                {
                    $zile = array("Duminica", "Luni" ,"Marti","Miercuri","Joi","Vineri","Sambata");

                    $rezervare = mysqli_fetch_assoc($rezultat);
                    if($rezervare['confirmed'] == 0)
                        echo "
                        <div class='borrow-book-formular'>
                            <h3>Ati rezervat deja aceasta carte! Doriti sa anulati rezervarea?</h3>
                            <form method='post' action='Borrow_formular.php?id_book=".$book_details['id_book']."'>
                                <input type='submit' name='renunt' value='Renunt la aceasta carte!' class='button'>
                            </form>
                        </div>";
                    else{
                        //$rezervare['data_rezervarii'] = date("Y-m-d", strtotime($rezervare['data_rezervarii']));
                        $inceput = date("Y-m-d", strtotime($rezervare['data_rezervarii']));
                        $your_date = strtotime("+14 day", strtotime($inceput));
                        $data_returnarii = date("d-m-Y", $your_date);

                        $ziua_saptamanii = date("w", strtotime($data_returnarii));
                        echo "<div class='borrow-book-formular'>
                            <h3 class='error'>Detineti aceasta carte si trebuie sa o returnati pe data de ".$zile[$ziua_saptamanii]." ".$data_returnarii.".</h3>
                        </div>";
                    }
                   
                }
            }
        ?>


    </div>



</body>  
</html>

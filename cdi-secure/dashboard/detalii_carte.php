<html>
<head>
	<?php
		include "../include/connection/database.php";
        require_once("../include/crypts/token.php");
		include "../include/main_page/string_validation.php";
		include "../include/admin/rol_admin_on.php";
		include "../include/admin/verifica_get_carte.php";
		include "../include/admin/detalii_carti_options.php";
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


		<?php
			//seteaza vectorul de categorii
			$categorie = array();

			$sql = "SELECT * FROM categorii";
			$result = mysqli_query($conn, $sql);
			while($cat = mysqli_fetch_assoc($result))
			{
				$categorie[$cat['id_categorie']] = $cat['nume_categorie'];
			}
			echo "
			<div class='detail-book-atributes'>
				
			<img src='../img/upload/".$carte['book_image']."' class='detail-book-image'>";
			if(isset($error_message))
				echo "<p><span class='error'>$error_message</span></p>";

			echo "
				<form action='detalii_carte.php?id_book=".$carte['id_book']."' method='post'  enctype='multipart/form-data'>
					<p><b>Titlu:</b><br><input type='text' value='".$carte['titlu']."' name='titlu'></p>
					<p><b>Autor:</b><br><input type='text' value='".$carte['autor']."' name='autor'></p>
					<p><b>Descriere:</b><br><textarea name='descriere'>".$carte['descriere']."</textarea></p>

					<p><b>Categorie:</b><br>
						<select name='categorie' onchange='admSelectCheck(this);'> 
				            <option selected='selected' value='".$carte['id_categorie']."'>".$categorie[$carte['id_categorie']]."</option>";
				            $sql = "SELECT * FROM categorii WHERE id_categorie != '".$carte['id_categorie']."' ORDER BY nume_categorie ASC";
				            $rezultat = mysqli_query($conn, $sql);
				            while($catg = mysqli_fetch_assoc($rezultat))
				            {
				               	echo "<option value='".$catg['id_categorie']."'>".$catg['nume_categorie']."</option>";
				           	}
		    echo "
		    	<option id='admOption' value='alta_categorie'> -- altă categorie -- </option>
		    	</select></td></p>
		    	<div style='display:none;' id='admDivCheck'>
		    		<p><b>Categorie nouă:</b><br><input type='text' name='new_category' placeholder='Categorie nouă'></p>
		    	</div>
				<p><b>Stoc:</b><br><input type='number' value='".$carte['stoc']."' name='stoc' min='".$carte['imprumutate']."'></p>
				<p><b>Schimbă imaginea:</b></p>
				<div class='choose-image-container'>";

			$sql = "SELECT * FROM imagini";
			$result = mysqli_query($conn, $sql);
			while($image = mysqli_fetch_assoc($result))
			{	
				$checked_image = '';
				if($image['book_image'] == $carte['book_image'])
					$checked_image = "checked = 'checked'";		
				echo "
					<div class='choose-image-box'><img src='../img/upload/".$image['book_image']."' alt='".$image['book_image']."'><br>
						<input type='radio' name='change_image' $checked_image value='".$image['book_image']."'>
					</div>";
			}
			echo "
					</div>
					<p><b>Adaugă imagine nouă</b><br><input type='file' name='new_image' id='new_image'></p>
					<p><b>Dorești să ștergi această carte?</b><br><input type='checkbox' name='delete'><span>Șterge</span></p>
                    <input type='hidden' name='token' value='".Token::generate()."'>
					<p><input type='submit' value='Modifica' name='modifica'></p>
				</form>
			</div>";

		?>
		<div class='end-page'></div>
	</div>

   
</body> 
	<script>
		function admSelectCheck(nameSelect)
		{
		    console.log(nameSelect);
		    if(nameSelect){
		        admOptionValue = document.getElementById("admOption").value;
		        if(admOptionValue == nameSelect.value){
		            document.getElementById("admDivCheck").style.display = "block";
		        }
		        else{
		            document.getElementById("admDivCheck").style.display = "none";
		        }
		    }
		    else{
		        document.getElementById("admDivCheck").style.display = "none";
		    }
		}
	</script>
</html>
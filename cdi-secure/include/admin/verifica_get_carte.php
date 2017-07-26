<?php
	if(isset($_GET['id_book']))
	{
		$sql = "SELECT * FROM books WHERE id_book = '".$_GET['id_book']."'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0)
		{
			$carte = mysqli_fetch_assoc($result);
		}
		else
		{
			header("location: ../dashboard/carti.php");
		}
	}
	else
	{
		header("location: ../../dashboard/carti.php");
	}
?>
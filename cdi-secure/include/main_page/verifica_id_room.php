<?php
	if(isset($_GET['room']))
	{
		$sql = "SELECT * FROM rooms WHERE id_room = '".$_GET['room']."'";
		$res = mysqli_query($conn, $sql);
		if(!mysqli_num_rows($res) == 1){
			header("location: index.php");
		}

	}
	else
	{
		header("location: index.php");
	}

?>
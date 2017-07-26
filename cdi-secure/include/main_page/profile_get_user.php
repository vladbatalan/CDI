<?php
    if(!isset($_SESSION['login']) || !isset($_GET['user']))
        header("location: index.php");
    $username = verifica($_GET['user']);
    $sql = "SELECT * FROM users WHERE id_user = '".$username."'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    	$user_details = mysqli_fetch_assoc($result);
    else
        header("location: index.php");
?>
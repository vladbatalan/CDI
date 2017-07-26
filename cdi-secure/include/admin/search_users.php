<?php
	$get_search = '';
	if(isset($_GET['search_user']))
	{
		$get_search = verifica($_GET['search_user']);
	}

?>
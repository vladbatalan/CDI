<?php
	$get_titlu = '';
	$get_user = '';
	$get_autor = '';
	$get_tip = '';
	$get_data = '';

	$sql_search = ' WHERE';
	$ok_search = 1;
	if(isset($_GET['search']))
	{
		$get_titlu = verifica($_GET['titlu']);
		$get_user = verifica($_GET['user']);
		$get_autor = verifica($_GET['autor']);
		$get_tip = verifica($_GET['tip_cautat']);
		$get_data = verifica($_GET['data']);

		$nr_comp = 0;
		if(!empty($get_titlu))
		{
			$nr_comp ++;
			$sql = "SELECT * FROM books WHERE titlu LIKE '%$get_titlu%'";
			$res = mysqli_query($conn, $sql);

			$add = '';
			while($row = mysqli_fetch_assoc($res))
			{
				if($add != '')
					$add .= " OR";
				$add .= " id_book LIKE '".$row['id_book']."'";
			}
			if($add != '')
				$add = '('.$add.')';

			if($nr_comp != 1 && $add != '')
				$sql_search .= " AND";
			if($add == ''){
				$nr_comp --;
				$ok_search = 0;
			}
			else
				$sql_search .= " $add";
		}

		if(!empty($get_autor))
		{
			$nr_comp ++;
			$sql = "SELECT * FROM books WHERE autor LIKE '%$get_autor%'";
			$res = mysqli_query($conn, $sql);

			$add = '';
			while($row = mysqli_fetch_assoc($res))
			{
				if($add != '')
					$add .= " OR";
				$add .= " id_book LIKE '".$row['id_book']."'";
			}
			if($add != '')
				$add = '('.$add.')';

			if($nr_comp != 1 && $add != '')
				$sql_search .= " AND";
			if($add == ''){
				$nr_comp --;
				$ok_search = 0;
			}
			else
				$sql_search .= " $add";
		}

		if(!empty($get_user))
		{
			$nr_comp ++;
			$sql = "SELECT * FROM users WHERE nume LIKE '%$get_user%' OR prenume LIKE '%$get_user%' OR username LIKE '%$get_user%'";
			$res = mysqli_query($conn, $sql);

			$add = '';
			while($row = mysqli_fetch_assoc($res))
			{
				if($add != '')
					$add .= " OR";
				$add .= " id_user LIKE '".$row['id_user']."'";
			}
			if($add != '')
				$add = '('.$add.')';

			if($nr_comp != 1 && $add != '')
				$sql_search .= " AND";
			if($add == ''){
				$nr_comp --;
				$ok_search = 0;
			}
			else
				$sql_search .= " $add";
		}

		if(!empty($get_data))
		{
			$nr_comp ++;
			if($nr_comp != 1)
				$sql_search .= " AND";
			$sql_search .= " data_rezervarii LIKE '$get_data'";
		}

		if(!empty($get_tip))
		{
			$nr_comp ++;
			if($nr_comp != 1)
				$sql_search .= " AND";
			$id = 0;
			if($get_tip == 'rezervare')
				$id = 0;
			if($get_tip == 'imprumutate')
				$id = 1;
			if($get_tip == 'expirate')
				$id = 2;
			$sql_search .= " confirmed LIKE '$id'";
		}
	}
		
	if($sql_search == ' WHERE')
		$sql_search = "SELECT * FROM rezervari_carti ORDER BY confirmed DESC, data_rezervarii ASC";
	else
		$sql_search = "SELECT * FROM rezervari_carti$sql_search ORDER BY confirmed DESC, data_rezervarii ASC";
	if($ok_search == 0)
		$sql_search = "SELECT * FROM rezervari_carti WHERE confirmed = '-1'";

?>	
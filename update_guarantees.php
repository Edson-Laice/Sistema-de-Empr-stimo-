<?php
	require_once'class.php';
	if(ISSET($_POST['update'])){
		$db=new db_class();
        $gua_id = $_POST['gua_id'];
		$gua_name=$_POST['gua_name'];
		$gua_desc=$_POST['gua_desc'];
		
		$db->update_guarantees($gua_id ,$gua_name,$gua_desc);
		
		header("location: guarantees.php");
	}
?>
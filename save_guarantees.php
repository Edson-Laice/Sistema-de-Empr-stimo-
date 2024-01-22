<?php
include 'cf.php';
	require_once'class.php';
	if(ISSET($_POST['save'])){
		$gua_name=$_POST['gua_name'];
		$gua_desc=$_POST['gua_desc'];
		

        $query = "INSERT INTO `guarantees` (`name`, `description`) VALUES($gua_name, $gua_desc)";
		$result = $conn2->query($query);
    
		
	}
?>
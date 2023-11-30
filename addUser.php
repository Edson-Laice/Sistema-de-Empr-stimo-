<?php
	require_once'class.php';
	if(ISSET($_POST['confirm'])){
		$db=new db_class();
		$username=$_POST['username'];
		$password=$_POST['password'];
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$account_type = $_POST['account_type'];
		$db->add_user($username,$password,$firstname,$lastname,$account_type);
		echo"<script>window.location='user.php'</script>";
	}
?>
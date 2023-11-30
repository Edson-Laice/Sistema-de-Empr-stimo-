<?php
	require_once'class.php';
	if(ISSET($_POST['save'])){
		$db=new db_class();
        $loan_detalis = $_POST['loan_detalis'];
		$gua_name=$_POST['gua_name'];
		$gua_desc=$_POST['gua_desc'];
        $loanID = $_POST['loanID'];
		
		$db->save_guarantees($gua_name,$gua_desc);
		
        if($loan_detalis == "")
        {
            header("location: guarantees.php");
        }else{
            header("location: loan_details.php?id=$loanID");
        }
		
	}
?>
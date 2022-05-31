<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){

	$id=$_POST["id"];
	$subgroup=$_POST["subgroup"];	
	$result = $con->query("Select subgroup from SUBGROUP Where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){		
		$result1 = $con1->query("Delete From SUBGROUP where id='$id'");		
		header("location: ../subgroup.php");
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../subgroup.php");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../subgroup.php");
}
?>
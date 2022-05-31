<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){	

	$id=$_POST["id"];
	$branch=$_POST["branch"];
	$location=$_POST["location"];
	$username=$_POST["username"];
	$date=date("Y-m-d")." ".date("H:i:s");	
	
	$result = $con->query("Select * from BRANCH Where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){		
		$result1 = $con1->query("Delete From BRANCH where id='$id'");		
		header("location: ../branch.php");
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../branch.php");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../branch.php");
}
?>
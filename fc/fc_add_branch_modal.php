<?php
session_start();
include("fc_config.php");
if(!empty($_POST["branch"])){	

	$branch=$_POST["branch"];
	$location=$_POST["location"];
	$username=$_POST["username"];
	$date=date("Y-m-d")." ".date("H:i:s");	
	
	$result = $con->query("Select * from BRANCH Where branch='$branch'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$_SESSION["iss21"]["info"]="Gagal, nama cabang $branch sudah terdaftar.";
		header("location: ../branch.php");
	}else{
		$result = $con->query("Insert Into BRANCH (branch, location, username, entrydate) values ('$branch', '$location', '$username', '$date')");
		header("location: ../branch.php");
	}

}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../branch.php");
}
?>
<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){	

	$email=$_POST["email"];
	$password=$_POST["password"];
	$fullname=$_POST["fullname"];
	$position=$_POST["position"];
	$level=$_POST["level"];
	$status=$_POST["status"];
	$img=$_POST["img"];
	$id=$_POST["id"];
	$username=$fullname;
	$date=date("Y-m-d")." ".date("H:i:s");	
	
	$result = $con->query("Update TBLLOGIN set email='$email', password='$password', fullname='$fullname', img='$img', lastname='$username', lastdate='$date' where id='$id'");
	$count = mysqli_num_rows($result);
	
	$_SESSION["iss21"]["email"]=$email;
	$_SESSION["iss21"]["password"]=$password;
	$_SESSION["iss21"]["fullname"]=$fullname;
	$_SESSION["iss21"]["img"]=$img;
	
	$_SESSION["iss21"]["info"]="Berhasil, informasi profil anda berhasil diperbaharui.";
	header("location: ../pages-profile.php");

}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../pages-profile.php");
}
?>
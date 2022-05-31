<?php
session_start();
include("fc_config.php");
if(!empty($_GET["id"]) &&!empty($_GET["tanggal"])){

	$id=$_GET["id"];
	$tanggal=$_GET["tanggal"];
	$result = $con->query("Delete From KEBUTUHAN where id='$id' and convert(tanggal, date)='$tanggal'");
	header("location: ../add-needs.php?tanggal=$tanggal");
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../add-needs.php?tanggal=$tanggal");
}
?>
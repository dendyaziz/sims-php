<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){	

	$id=$_POST["id"];
	$kode=$_POST["kode"];
	$customer=$_POST["customer"];
	$address=$_POST["address"];
	$phone=$_POST["phone"];
	$contact=$_POST["contact"];
	$tipe=$_POST["tipe"];
	$note=$_POST["note"];
	$username=$_POST["username"];
	$date=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from CUSTOMER Where kode='$kode' and id !='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$xcustomer=$row["customer"];
			$xaddress=$row["address"];
			$_SESSION["iss21"]["info"]="Gagal, kode customer $kode sudah terdaftar dengan nama customer $xcustomer dan address $xaddress.";
			header("location: ../customer.php");
		}
	}else{
		$result1 = $con1->query("Update CUSTOMER set customer='$customer', address='$address', phone='$phone', contact='$contact', tipe='$tipe', note='$note', username='$username', entrydate='$date' where id='$id'");			
		header("location: ../customer.php");	
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../customer.php");
}
?>
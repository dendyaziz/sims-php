<?php
session_start();
include("fc_config.php");
if(!empty($_POST["id"])){	

	$id=$_POST["id"];
	$kode=$_POST["kode"];
	$supplier=$_POST["supplier"];
	$address=$_POST["address"];
	$phone=$_POST["phone"];
	$contact=$_POST["contact"];
	$username=$_POST["username"];
	$date=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from SUPPLIER Where kode='$kode' and id !='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$xsupplier=$row["supplier"];
			$xaddress=$row["address"];
			$_SESSION["iss21"]["info"]="Gagal, kode supplier $kode sudah terdaftar dengan nama supplier $xsupplier dan address $xaddress.";
			header("location: ../supplier.php");
		}
	}else{
		$result1 = $con1->query("Update SUPPLIER set supplier='$supplier', address='$address', phone='$phone', contact='$contact', username='$username', entrydate='$date' where id='$id'");			
		header("location: ../supplier.php");	
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../supplier.php");
}
?>
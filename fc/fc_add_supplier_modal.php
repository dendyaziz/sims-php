<?php
session_start();
include("fc_config.php");
if( !empty($_POST["supplier"]) && !empty($_POST["address"]) && !empty($_POST["phone"]) && !empty($_POST["contact"]) ){	

	$result = $con->query("Select kode from SUPPLIER order by kode desc limit 1");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$kode_supplier=$row["kode"];
			$kode=number_format(right($kode_supplier,5))+1;	
			$kode="S".right("00000".$kode,5);
		}		
	}else{
		$kode="S00001";
	}
	
	if(!empty($kode)){
		
		$supplier=$_POST["supplier"];
		$address=$_POST["address"];
		$phone=$_POST["phone"];
		$contact=$_POST["contact"];
		$username=$_POST["username"];
		$entrydate=date("Y-m-d")." ".date("H:i:s");	
		
		$result = $con->query("Select * from SUPPLIER Where kode='$kode'");
		$count = mysqli_num_rows($result);
		if($count>0){
			$_SESSION["iss21"]["info"]="Gagal, Kode Supplier $kode sudah terdaftar.";
			header("location: ../supplier.php");
		}else{
			$result = $con->query("Insert Into SUPPLIER (kode, supplier, address, phone, contact, username, entrydate) values ('$kode', '$supplier', '$address', '$phone', '$contact', '$username', '$entrydate')");
			header("location: ../supplier.php");
		}
		
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih pada saat generate kode supplier.";
		header("location: ../supplier.php");
	}
		
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../supplier.php");
}
?>
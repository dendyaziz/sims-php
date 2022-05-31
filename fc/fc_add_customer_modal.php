<?php
session_start();
include("fc_config.php");
if( !empty($_POST["customer"]) && !empty($_POST["address"]) && !empty($_POST["phone"]) && !empty($_POST["contact"]) ){	

	$result = $con->query("Select kode from CUSTOMER order by kode desc limit 1");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$kode_customer=$row["kode"];
			$kode=number_format(right($kode_customer,5))+1;	
			$kode="C".right("00000".$kode,5);
		}		
	}else{
		$kode="C00001";
	}
	
	if(!empty($kode)){
		
		$customer=$_POST["customer"];
		$address=$_POST["address"];
		$phone=$_POST["phone"];
		$contact=$_POST["contact"];
		$tipe=$_POST["tipe"];
		$note=$_POST["note"];
		$username=$_POST["username"];
		$entrydate=date("Y-m-d")." ".date("H:i:s");	
		
		$result = $con->query("Select * from CUSTOMER Where kode='$kode'");
		$count = mysqli_num_rows($result);
		if($count>0){
			$_SESSION["iss21"]["info"]="Gagal, Kode Customer $kode sudah terdaftar.";
			header("location: ../customer.php");
		}else{
			$result = $con->query("Insert Into CUSTOMER (kode, customer, address, phone, contact, tipe, note, username, entrydate) 
			values ('$kode', '$customer', '$address', '$phone', '$contact', '$tipe', '$note', '$username', '$entrydate')");
			header("location: ../customer.php");
		}
		
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih pada saat generate kode customer.";
		header("location: ../customer.php");
	}
		
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../customer.php");
}
?>
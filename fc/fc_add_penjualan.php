<?php
session_start();
include("fc_config.php");
if(!empty($_POST["branch"]) &&!empty($_POST["tanggal"]) && !empty($_POST["customer"]) && !empty($_POST["jenis"]) && !empty($_POST["barang"]) && !empty($_POST["jual_panjang"]) && !empty($_POST["jumlah"]) && !empty($_POST["harga"])){	
	
	$branch=$_POST["branch"];
	$tanggal=$_POST["tanggal"];	
	$tgl=date('Y-m-d',strtotime($tanggal));
	$tgl_faktur=$tgl." ".date("H:i:s");
	
	if(empty($_POST["faktur"])){		
		$result = $con->query("Select faktur from PENJUALAN where left(faktur,3)='F".right(date("Y"),2)."' order by faktur desc limit 1");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$faktur="F".(str_replace("F","",$row["faktur"])+1);
			}
		}else{
			$faktur="F".right(date("Y"),2)."000000001";
		}
	}else{
		$faktur=$_POST["faktur"];
	}
	$_SESSION["iss21"]["faktur"]=$faktur;
	
	$customer=$_POST["customer"];
	$alamat=$_POST["alamat"];
	$telepon=$_POST["telepon"];
	
	$jenis=$_POST["jenis"];
	$barang=$_POST["barang"];
	$panjang=$_POST["panjang"];
	$lebar=$_POST["lebar"];
	if(empty($lebar)){
		$lebar="0";
	}
	
	$jual_panjang=$_POST["jual_panjang"];
	$jual_lebar=$_POST["jual_lebar"];
	if(empty($jual_lebar)){
		$jual_lebar="0";
	}
	$jumlah=$_POST["jumlah"];
	$harga=$_POST["harga"];
	
	$username=$_POST["username"];
	$date=date("Y-m-d")." ".date("H:i:s");	
	
	$result = $con->query("Insert Into PENJUALAN (branch, tanggal, faktur, customer, alamat, telepon, jenis, barang, panjang, lebar, jual_panjang, jual_lebar, jumlah, harga, username, entrydate) values ('$branch','$tgl_faktur','$faktur','$customer', '$alamat', '$telepon', '$jenis', '$barang', '$panjang', '$lebar', '$jual_panjang', $jual_lebar, '$jumlah', '$harga', '$username', '$date')");
	
	$result = $con->query("Select * from STOK Where branch='$branch' and  jenis='$jenis' and barang='$barang'");
	$count = mysqli_num_rows($result);
	
	$s_out=$jumlah;
	if($count>0){		
		$result1 = $con1->query("update STOK set s_out=s_out+$s_out, saldo=saldo-$s_out, lastname='$username', lastdate='$date' where branch='$branch' and jenis='$jenis' and barang='$barang'");		
	}else{		
		$result1 = $con1->query("Insert into STOK (branch, jenis, barang, panjang, lebar, s_in, s_out, saldo, username, entrydate) values ('$branch', '$jenis','$barang','$panjang','$lebar','0','$s_out','-$s_out','$username','$date')");		
	}	
	$result2 = $con2->query("Insert into HISTORY (branch, faktur, tanggal, transcd, jenis, barang, panjang, lebar, s_out, username, entrydate) 
	values ('$branch', '$faktur', '$tgl_faktur', 'C', '$jenis','$barang','$panjang','$lebar','$s_out','$username','$date')");		
	
	header("location: ../penjualan.php?tanggal=$tanggal&faktur=$faktur&customer=$customer&alamat=$alamat&telepon=$telepon");
	
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../penjualan.php?tanggal=$tanggal&faktur=$faktur&customer=$customer&alamat=$alamat&telepon=$telepon");
}
?>
<?php
session_start();
include("fc_config.php");
if(!empty($_POST["tanggal"]) && !empty($_POST["kode"]) && !empty($_POST["qty"])){	

	$branch=$_SESSION["iss21"]["branch"];	
	$tanggal=$_POST["tanggal"];	
	$faktur=$_POST["faktur"];
	if(empty($faktur)){
		$transNo="D".right(date('Ym'),4);
		$result = $con->query("Select faktur from PEMUSNAHAN where left(faktur,5)='$transNo' order by faktur desc limit 1");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$transno=right($row["faktur"],9)+1;
				$faktur="D".$transno;
			}
		}else{
			$faktur="D".right(date('Ym'),4)."00001";
		}
	}
		
	$kode=$_POST["kode"];
	$jenis=$_POST["jenis"];
	$subgroup=$_POST["subgroup"];
	$merk=$_POST["merk"];
	$barang=$_POST["barang"];
	$barang=str_replace("'","",$barang);
	$satuan=$_POST["satuan"];
	$stok=$_POST["stok"];
	$qty=$_POST["qty"];
	$harga=$_POST["harga_beli"];
	$keterangan=$_POST["keterangan"];
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from PEMUSNAHAN Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode' ");
	$count = mysqli_num_rows($result);
	if($count>0){	
		$result = $con->query("update PEMUSNAHAN set qty=qty+$qty, harga='$harga' Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode' ");
	}else{
		$result = $con->query("Insert Into PEMUSNAHAN (branch, tanggal, faktur, kode, jenis, subgroup, merk, barang, satuan, qty, harga, keterangan, username, entrydate) 
		values ('$branch','$tanggal','$faktur', '$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$qty','$harga', '$keterangan', '$username', '$entrydate')");
	}
	
	$result = $con->query("Select * from STOK Where branch='$branch' and kode='$kode' ");
	$count = mysqli_num_rows($result);	
	if($count>0){
		$result1 = $con1->query("update STOK set s_out=s_out+$qty, saldo=saldo-$qty where branch='$branch' and kode='$kode' ");		
	}else{		
		$result1 = $con1->query("Insert into STOK (branch, kode, jenis, subgroup, merk, barang, satuan, s_in, s_out, saldo, username, entrydate) 
		    values ('$branch', '$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '0' , '$qty', '-$qty', '$username', '$entrydate')");				
	}
	
	$result = $con->query("Select * from HISTORY Where branch='$branch' and transaksi='DESTRUCTION' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$result = $con->query("update HISTORY set qty=qty+$qty, harga_beli='$harga' Where branch='$branch' and transaksi='DESTRUCTION' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");
	}else{
		$result2 = $con2->query("Insert into HISTORY (branch, transaksi, faktur, tanggal, kode, jenis, subgroup, merk, barang, satuan, qty, harga_beli, username, entrydate) 
		values ('$branch', 'DESTRUCTION', '$faktur', '$tanggal', '$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$qty', '$harga', '$username', '$entrydate')");
	}
	
	header("location: ../destroy.php?tanggal=$tanggal&faktur=$faktur");	
	
}else{
    $tanggal=$_POST["tanggal"];	
	$faktur=$_POST["faktur"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../destroy.php?tanggal=$tanggal&faktur=$faktur");
}
?>
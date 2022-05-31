<?php
session_start();
include("fc_config.php");
if(!empty($_POST["tanggal"]) && !empty($_POST["supplier"]) && !empty($_POST["jenis"]) && !empty($_POST["barang"]) && !empty($_POST["satuan"]) && !empty($_POST["kode"]) && !empty($_POST["qty"]) ){	

	$branch=$_SESSION["iss21"]["branch"];	
	$tanggal=$_POST["tanggal"];	
	$tgl=date('Y-m-d',strtotime($tanggal));
	$tgl_prod=$tgl." ".date("H:i:s");
	
	$faktur=$_POST["faktur"];
	if(empty($faktur)){
		$transNo="I".right(date('Ym'),4);
		$result = $con->query("Select faktur from PEMBELIAN where left(faktur,5)='$transNo' order by faktur desc limit 1");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$transno=right($row["faktur"],9)+1;
				$faktur="I".$transno;
			}
		}else{
			$faktur="I".right(date('Ym'),4)."00001";
		}
	}	
	
	$supplier=$_POST["supplier"];
	$alamat_supplier=$_POST["alamat_supplier"];
	$telepon_supplier=$_POST["telepon_supplier"];
	$person_supplier=$_POST["person_supplier"];
	$kode_supplier=$_POST["kode_supplier"];
	
	$kode=$_POST["kode"];
	$jenis=$_POST["jenis"];
	$barang=$_POST["barang"];
	$barang=str_replace("'","''",$barang);
	$satuan=$_POST["satuan"];
	$qty=$_POST["qty"];
	$harga=$_POST["harga"];
	$ongkir=$_POST["ongkir"];
	
	$username=$_POST["username"];
	$date=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from PEMBELIAN Where branch='$branch' and CONVERT(tanggal, DATE)='$tgl' and faktur='$faktur' and  kode='$kode' and jenis='$jenis' and barang='$barang' and satuan='$satuan' and harga='$harga'");
	$count = mysqli_num_rows($result);
	if($count>0){	
		$result = $con->query("update PEMBELIAN set qty=qty+$qty Where branch='$branch' and CONVERT(tanggal, DATE)='$tgl' and faktur='$faktur' and  kode='$kode' and jenis='$jenis' and barang='$barang' and satuan='$satuan' and harga='$harga'");
	}else{
		$result = $con->query("Insert Into PEMBELIAN (branch, tanggal, faktur, supplier, alamat_supplier, telepon_supplier, person_supplier, kode_supplier, jenis, barang, satuan, kode, qty, harga, username, entrydate) 
			values ('$branch','$tgl_prod','$faktur','$supplier', '$alamat_supplier', '$telepon_supplier', '$person_supplier', '$kode_supplier', '$jenis', '$barang', '$satuan', '$kode', '$qty', '$harga', '$username', '$date')");
	}
	
	$result = $con->query("Select * from STOK Where branch='$branch' and  kode='$kode' and jenis='$jenis' and barang='$barang' and satuan='$satuan'");
	$count = mysqli_num_rows($result);	
	$s_in=$qty;
	if($count>0){		
		$result1 = $con1->query("update STOK set s_in=s_in+$s_in, saldo=saldo+$s_in where branch='$branch' and kode='$kode' and jenis='$jenis' and barang='$barang' and satuan='$satuan'");		
	}else{		
		$result1 = $con1->query("Insert into STOK (branch, jenis, barang, satuan, kode, s_in, s_out, saldo, username, entrydate) 
			values ('$branch', '$jenis','$barang','$satuan','$kode','$s_in','0','$s_in','$username','$date')");		
	}
	
	$result = $con->query("Select * from HISTORY Where branch='$branch' and transcd='A' and CONVERT(tanggal_faktur, DATE)='$tgl' and faktur='$faktur' and  kode='$kode' and jenis='$jenis' and barang='$barang' and satuan='$satuan' and harga='$harga'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$result = $con->query("update HISTORY set qty=qty+$qty Where branch='$branch' and transcd='A' and CONVERT(tanggal, DATE)='$tgl' and faktur='$faktur' and  kode='$kode' and jenis='$jenis' and barang='$barang' and satuan='$satuan' and harga='$harga'");
	}else{
		$result2 = $con2->query("Insert into HISTORY (branch, username, transdate, transcd, transaksi, faktur, tanggal_faktur, jenis, barang, satuan, kode, qty, harga) 
		values ('$branch', '$username', '$date', 'A', 'Barang Masuk', '$faktur', '$tgl_prod', '$jenis','$barang', '$satuan','$kode','$s_in','$harga')");		
	}
	header("location: ../incoming-edit.php?tanggal=$tanggal&faktur=$faktur&supplier=$supplier");	
	
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../incoming-edit.php?tanggal=$tanggal&faktur=$faktur&supplier=$supplier");
}
?>
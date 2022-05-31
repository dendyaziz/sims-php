<?php
session_start();
include("fc_config.php");
if(!empty($_POST["tanggal"]) && !empty($_POST["kode"]) && !empty($_POST["qty"])){	

	$branch=$_SESSION["iss21"]["branch"];	
	$tanggal=$_POST["tanggal"];	
	$faktur=$_POST["faktur"];
	if(empty($faktur)){
		$transNo="SO".right(date('Ym'),4);
		$result = $con->query("Select faktur from OPNAME where left(faktur,6)='$transNo' order by faktur desc limit 1");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$transno=right($row["faktur"],9)+1;
				$faktur="SO".$transno;
			}
		}else{
			$faktur="SO".right(date('Ym'),4)."00001";
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
	$harga=$_POST["harga"];
	$keterangan=$_POST["keterangan"];
	$selisih=$qty-$stok;
	
	$stok=$_POST["stok"];
	
	$username=$_POST["username"];
	$date=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from OPNAME Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode' ");
	$count = mysqli_num_rows($result);
	if($count>0){	
		$result = $con->query("update OPNAME set qty=$qty, stok=$stok Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode' ");
	}else{
		$result = $con->query("Insert Into OPNAME (branch, tanggal, faktur, kode, jenis, subgroup, merk, barang, satuan, stok, qty, harga, keterangan, username, entrydate) 
		values ('$branch','$tanggal','$faktur', '$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$stok', '$qty', '$harga', '$keterangan', '$username', '$date')");
	}
	
	$result = $con->query("Select * from STOK Where branch='$branch' and  kode='$kode' ");
	$count = mysqli_num_rows($result);	
	if($count>0){
		if($selisih>0){
			$result1 = $con1->query("update STOK set s_in=s_in+$selisih, saldo=saldo+$selisih where branch='$branch' and kode='$kode' ");		
		}else{
			$result1 = $con1->query("update STOK set s_out=s_out-$selisih, saldo=saldo+$selisih where branch='$branch' and kode='$kode' ");		
		}		
	}else{		
		if($selisih>0){
			$result1 = $con1->query("Insert into STOK (branch, kode, jenis, subgroup, merk, barang, satuan, s_in, s_out, saldo, username, entrydate) 
			values ('$branch', '$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$kode', '$selisih' , '0', '$selisih', '$username', '$date')");		
		}else{
			$result1 = $con1->query("Insert into STOK (branch, kode, jenis, subgroup, merk, barang, satuan, s_in, s_out, saldo, username, entrydate) 
			values ('$branch', '$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$kode', '0' , '-$selisih', '$selisih', '$username', '$date')");		
		}		
	}
	
	$result = $con->query("Select * from HISTORY Where branch='$branch' and transaksi='STOCK OPNAME' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$result = $con->query("update HISTORY set qty=$selisih, harga_beli='$harga' Where branch='$branch' and transaksi='STOCK OPNAME' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");
	}else{
		$result2 = $con2->query("Insert into HISTORY (branch, transaksi, faktur, tanggal, kode, jenis, subgroup, merk, barang, satuan, qty, harga_beli, username, entrydate) 
		values ('$branch', 'STOCK OPNAME', '$faktur', '$tanggal', '$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$selisih', '$harga', '$username', '$date')");
	}
	
	header("location: ../opname.php?tanggal=$tanggal&faktur=$faktur");	
	
}else{
    $tanggal=$_POST["tanggal"];	
	$faktur=$_POST["faktur"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../opname.php?tanggal=$tanggal&faktur=$faktur");
}
?>
<?php
session_start();
include("fc_config.php");
if(!empty($_POST["tanggal"]) && !empty($_POST["kode"]) && !empty($_POST["customer"]) && !empty($_POST["qty"])){	

	$branch=$_SESSION["iss21"]["branch"];	
	$tanggal=$_POST["tanggal"];	
	$tgl=date('Y-m-d',strtotime($tanggal));
	$tgl_trans=$tgl." ".date("H:i:s");
	
	$faktur=$_POST["faktur"];
	if(empty($faktur)){
		$transNo="T".right(date('Ym'),4);
		$result = $con->query("Select faktur from OUTGOING where left(faktur,5)='$transNo' order by faktur desc limit 1");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$transno=right($row["faktur"],9)+1;
				$faktur="T".$transno;
			}
		}else{
			$faktur="T".right(date('Ym'),4)."00001";
		}
	}
	
	$customer=$_POST["customer"];
	$alamat=$_POST["alamat"];
	$telepon=$_POST["telepon"];
	$person=$_POST["person"];
	$kode_customer=$_POST["kode_customer"];
	
	$kode=$_POST["kode"];
	$jenis=$_POST["jenis"];
	$barang=$_POST["barang"];
	$barang=str_replace("'","''",$barang);
	$satuan=$_POST["satuan"];
	
	$qty=$_POST["qty"];
	$harga=$_POST["harga"];
	
	$username=$_POST["username"];
	$date=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from OUTGOING Where branch='$branch' and CONVERT(tanggal, DATE)='$tgl' and faktur='$faktur' and customer='$customer' and kode='$kode' and jenis='$jenis' and barang='$barang' and satuan='$satuan'");
	$count = mysqli_num_rows($result);
	if($count>0){	
		$result = $con->query("update OUTGOING set qty=qty+$qty Where branch='$branch' and CONVERT(tanggal, DATE)='$tgl' and faktur='$faktur' and customer='$customer' and kode='$kode' and jenis='$jenis' and barang='$barang' and satuan='$satuan'");
	}else{
		$result = $con->query("Insert Into OUTGOING (branch, tanggal, faktur, customer, alamat, telepon, person, kode_customer, jenis, barang, satuan, kode, qty, harga, username, entrydate) 
		values ('$branch','$tgl_trans','$faktur', '$customer','$alamat','$telepon', '$person', '$kode_customer', '$jenis', '$barang', '$satuan', '$kode', '$qty', '$harga', '$username', '$date')");
	}
	
	$result = $con->query("Select * from STOK Where branch='$branch' and  kode='$kode' and jenis='$jenis' and barang='$barang' and satuan='$satuan'");
	$count = mysqli_num_rows($result);	
	if($count>0){		
		$result1 = $con1->query("update STOK set s_out=s_out+$qty, saldo=saldo-$qty where branch='$branch' and kode='$kode' and jenis='$jenis' and barang='$barang' and satuan='$satuan'");		
	}else{		
		$result1 = $con1->query("Insert into STOK (branch, jenis, barang, satuan, kode, s_in, s_out, saldo, username, entrydate) 
		values ('$branch', '$jenis', '$barang', '$satuan', '$kode', '0' , '-$qty', '-$qty', '$username', '$date')");		
	}
	
	$result = $con->query("Select * from HISTORY Where branch='$branch' and transcd='B' and CONVERT(tanggal_faktur, DATE)='$tgl' and faktur='$faktur' and kode='$kode' and jenis='$jenis' and barang='$barang' and satuan='$satuan'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$result = $con->query("update HISTORY set qty=qty+$qty Where branch='$branch' and transcd='B' and CONVERT(tanggal_faktur, DATE)='$tgl' and faktur='$faktur' and kode='$kode' and jenis='$jenis' and barang='$barang' and satuan='$satuan'");
	}else{
		$result2 = $con2->query("Insert into HISTORY (branch, username, transdate, transcd, transaksi, faktur, tanggal_faktur, jenis, barang, satuan, kode, qty, harga) 
		values ('$branch', '$username', '$date', 'B', 'Barang Keluar', '$faktur', '$tgl_trans', '$jenis', '$barang', '$satuan', '$kode', '$qty', '$harga')");
	}
	header("location: ../outgoing-edit.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer");	
	
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../outgoing-edit.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer");
}
?>
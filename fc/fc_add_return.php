<?php
session_start();
include("fc_config.php");
if(!empty($_POST["tanggal"]) && !empty($_POST["kode"]) && !empty($_POST["customer"]) && !empty($_POST["qty"]) ){	

	$branch=$_SESSION["iss21"]["branch"];	
	$tanggal=$_POST["tanggal"];	
	$faktur=$_POST["faktur"];
	if(empty($faktur)){
		$transNo="R".right(date('Ym'),4);
		$result = $con->query("Select faktur from RETUR where left(faktur,5)='$transNo' order by faktur desc limit 1");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$transno=right($row["faktur"],9)+1;
				$faktur="R".$transno;
			}
		}else{
			$faktur="R".right(date('Ym'),4)."00001";
		}
	}
	
	$customer=$_POST["customer"];
	$address=$_POST["address"];
	$phone=$_POST["phone"];
	$contact=$_POST["contact"];
	$kode_customer=$_POST["kode_customer"];
	
    $kode=$_POST["kode"];
	$jenis=$_POST["jenis"];
	$subgroup=$_POST["subgroup"];
	$merk=$_POST["merk"];
	$barang=$_POST["barang"];
	$barang=str_replace("'","",$barang);
	$satuan=$_POST["satuan"];	
	$qty=$_POST["qty"];
	$harga_beli=$_POST["harga_beli"];
	$harga_jual=$_POST["harga_jual"];
	$descr=$_POST["descr"];
	
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from RETUR Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and customer='$customer' and salesman='$salesman' and kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){	
		$result = $con->query("update RETUR set qty=qty+$qty, harga_beli='$harga_beli', harga_jual='$harga_jual' Where branch='$branch' and tanggal='$tanggal' and faktur='$faktur' and customer='$customer' and salesman='$salesman' and kode='$kode'");
	}else{
		$result = $con->query("Insert Into RETUR (branch, tanggal, faktur, customer, address, phone, contact, kode_customer, kode, jenis, subgroup, merk, barang, satuan, qty, harga_beli, harga_jual, descr, username, entrydate) 
		values ('$branch','$tanggal','$faktur', '$customer', '$address', '$phone', '$contact', '$kode_customer','$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$qty', '$harga_beli', '$harga_jual', '$descr', '$username', '$entrydate')");
	}
	
	$result = $con->query("Select * from STOK Where branch='$branch' and kode='$kode'");
	$count = mysqli_num_rows($result);	
	if($count>0){		
		$result1 = $con1->query("update STOK set s_out=s_out-$qty, saldo=saldo+$qty where branch='$branch' and kode='$kode'");		
	}else{		
		$result1 = $con1->query("Insert into STOK (branch, jenis, barang, satuan, kode, s_in, s_out, saldo, username, entrydate) 
		values ('$branch', '$jenis', '$barang', '$satuan', '$kode', '0' , '-$qty', '-$qty', '$username', '$entrydate')");		
	}
	
	$result = $con->query("Select * from HISTORY Where branch='$branch' and transaksi='RETURN' and tanggal='$tanggal' and faktur='$faktur' and salesman='$salesman' and kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$result = $con->query("update HISTORY set qty=qty+$qty, harga_beli='$harga_beli', harga_jual='$harga_jual' Where branch='$branch' and transaksi='RETURN' and tanggal='$tanggal' and faktur='$faktur' and salesman='$salesman' and kode='$kode'");
	}else{
		$result2 = $con2->query("Insert into HISTORY (branch, transaksi, faktur, tanggal, kode_customer, customer, address, phone, contact, kode, jenis, subgroup, merk, barang, satuan, qty, harga_beli, harga_jual, username, entrydate, descr) 
		values ('$branch', 'RETURN', '$faktur', '$tanggal', '$kode_customer', '$customer', '$address', '$phone', '$contact','$kode', '$jenis', '$subgroup', '$merk', '$barang', '$satuan', '$qty', '$harga_beli', '$harga_jual', '$username', '$entrydate', '$descr')");
	}
	
	header("location: ../return.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&userid=$userid");
	
}else{	
	$tanggal=$_POST["tanggal"];
	$faktur=$_POST["faktur"];
	$kode_customer=$_POST["kode_customer"];
	$userid=$_POST["userid"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../return.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&userid=$userid");
}
?>
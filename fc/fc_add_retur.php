<?php
session_start();
include("fc_config.php");
if(!empty($_POST["tanggal"]) && !empty($_POST["kode"]) && !empty($_POST["nik"]) && !empty($_POST["qty"])){	

	$branch=$_SESSION["iss21"]["branch"];	
	$tanggal=$_POST["tanggal"];
	$transdate=$tanggal." ".date("H:i:s");
	
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
	
	$nik=$_POST["nik"];
	$fullname=$_POST["fullname"];
	$address=$_POST["address"];
	$phone=$_POST["phone"];
	$position=$_POST["position"];
	$dept=$_POST["dept"];
	
	$kode=$_POST["kode"];
	$barang=$_POST["barang"];
	$barang=str_replace("'","''",$barang);
	$jenis=$_POST["jenis"];
	$satuan=$_POST["satuan"];	
	$qty=$_POST["qty"];
	
	$username=$_POST["username"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from RETUR Where branch='$branch' and CONVERT(tanggal, DATE)='$tanggal' and faktur='$faktur' and nik='$nik' and kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){	
		$result = $con->query("update RETUR set qty=qty+$qty Where branch='$branch' and CONVERT(tanggal, DATE)='$tanggal' and faktur='$faktur' and nik='$nik' and kode='$kode'");
	}else{
		$result = $con->query("Insert Into RETUR (branch, tanggal, faktur, nik, fullname, address, phone, position, dept, kode, barang, jenis, satuan, qty, username, entrydate) 
		values ('$branch','$transdate','$faktur', '$nik', '$fullname', '$address', '$phone', '$position', '$dept', '$kode', '$barang', '$jenis', '$satuan', '$qty', '$username', '$entrydate')");
	}
	
	$result = $con->query("Select * from STOK Where branch='$branch' and kode='$kode'");
	$count = mysqli_num_rows($result);
	
	if($count>0){		
		$result1 = $con1->query("update STOK set s_in=s_in+$qty, saldo=saldo+$qty where branch='$branch' and kode='$kode'");		
	}else{		
		$result1 = $con1->query("Insert into STOK (branch, jenis, barang, satuan, kode, s_in, s_out, saldo, username, entrydate) 
		values ('$branch', '$jenis', '$barang', '$satuan', '$kode', '$qty', 0, '$qty', '$username', '$entrydate')");
	}
	
	$result = $con->query("Select * from HISTORY Where branch='$branch' and transaksi='RETURN' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");
	$count = mysqli_num_rows($result);
	if($count>0){
		$result = $con->query("update HISTORY set qty=qty+$qty Where branch='$branch' and transaksi='RETURN' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");
	}else{
		$result2 = $con2->query("Insert into HISTORY (branch, transaksi, faktur, tanggal, kode_supplier, supplier, address, phone, contact, kode, barang, jenis, satuan, qty, username, entrydate, descr) 
		values ('$branch', 'RETURN', '$faktur', '$tanggal', '$nik', '$fullname', '$address', '$phone', '$position $dept', '$kode', '$barang', '$jenis', '$satuan', '$qty', '$username', '$entrydate', 'Return Transaction')");
	}
	header("location: ../retur.php?tanggal=$tanggal&faktur=$faktur&nik=$nik");
	
}else{
	$faktur=$_POST["faktur"];
	$nik=$_POST["nik"];
	$tanggal=$_POST["tanggal"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../retur.php?tanggal=$tanggal&faktur=$faktur&nik=$nik");
}
?>
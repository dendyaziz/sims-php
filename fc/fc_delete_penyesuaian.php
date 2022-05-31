<?php
session_start();
include("fc_config.php");
if(!empty($_GET["id"])){	

	$id=$_GET["id"];
	$username=$_SESSION["iss21"]["fullname"];
	$date=date("Y-m-d")." ".date("H:i:s");	
	
	$result = $con->query("Select * from PENJUALAN where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$branch=$row["branch"];
			$tanggal=$row["tanggal"];
			$tgl=date('Y-m-d',strtotime($tanggal));
			$tgl_prod=$tgl." ".date("H:i:s");
			$faktur=$row["faktur"];			
			$customer=$row["customer"];
			
			$jenis=$row["jenis"];	
			$barang=$row["barang"];
			$panjang=($row["panjang"]);
			$lebar=($row["lebar"]);
			$jumlah=$row["jumlah"];	
			$s_out=$jumlah;
			
			$result = $con->query("Delete From PENJUALAN where id='$id'");
			$result1 = $con1->query("update STOK set s_out=s_out-$s_out, saldo=saldo+$s_out, lastname='$username', lastdate='$date' where branch='$branch' and jenis='$jenis' and barang='$barang'");		
			$result2 = $con2->query("Insert into HISTORY (branch, faktur, tanggal, transcd, jenis, barang, panjang, lebar, s_out, username, entrydate) values ('$branch', '$faktur', '$tgl_prod', 'D', '$jenis','$barang','$panjang','$lebar','-$s_out','$username','$date')");		
			
			header("location: ../penjualan.php?tanggal=$tanggal&faktur=$faktur&customer=$customer&alamat=$alamat&telepon=$telepon");
		}
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../penjualan.php?tanggal=$tanggal&faktur=$faktur&customer=$customer&alamat=$alamat&telepon=$telepon");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../penjualan.php?tanggal=$tanggal&faktur=$faktur&customer=$customer&alamat=$alamat&telepon=$telepon");
}
?>
<?php
session_start();
include("fc_config.php");
if(!empty($_GET["id"])){	

	$id=$_GET["id"];
	$username=$_SESSION["iss21"]["fullname"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$tanggal=$_GET["tanggal"];
	$faktur=$_GET["faktur"];
	$kode_supplier=$_GET["kode_supplier"];
	
	$result = $con->query("Select * from PEMBELIAN where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$branch=$row["branch"];
			$tanggal=$row["tanggal"];
			$faktur=$row["faktur"];			
			$supplier=$row["supplier"];
			$address=$row["address"];
			$phone=$row["phone"];
			$contact=$row["contact"];
			$kode_supplier=$row["kode_supplier"];
			
			$jenis=$row["jenis"];	
			$barang=$row["barang"];
			$satuan=($row["satuan"]);
			$kode=($row["kode"]);
			$qty=$row["qty"];	
			$harga_beli=$row["harga_beli"];
			$batch=$row["batch"];
			
			
			$result = $con->query("Delete From PEMBELIAN where id='$id'");
			$result1 = $con1->query("update STOK set s_in=s_in-$qty, saldo=saldo-$qty, lastname='$username', lastdate='$entrydate' where branch='$branch' and kode='$kode'");		
			$result2 = $con2->query("Delete from HISTORY where tanggal='$tanggal' and transaksi='INCOMING' and branch='$branch' and faktur='$faktur' and kode='$kode' and batch='$batch'");	
			
			header("location: ../incoming.php?tanggal=$tgl&faktur=$faktur&kode_supplier=$kode_supplier");
		}
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../incoming.php?tanggal=$tgl&faktur=$faktur&kode_supplier=$kode_supplier");
	}
}else{
    $tanggal=$_GET["tanggal"];
	$faktur=$_GET["faktur"];
	$kode_supplier=$_GET["kode_supplier"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../incoming.php?tanggal=$tgl&faktur=$faktur&kode_supplier=$kode_supplier");
}
?>
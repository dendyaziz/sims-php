<?php
session_start();
include("fc_config.php");
if(!empty($_GET["id"])){	
	
	$username=$_SESSION["iss21"]["fullname"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$id=$_GET["id"];	
	$tanggal=$_GET["tanggal"];	
	$result = $con->query("Select * from PEMUSNAHAN where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$branch=$row["branch"];
			$tanggal=$row["tanggal"];
			$faktur=$row["faktur"];
			
			$kode=($row["kode"]);
			$jenis=$row["jenis"];	
			$barang=$row["barang"];
			$satuan=($row["satuan"]);
			$qty=$row["qty"];	
			
			$result = $con->query("Delete From PEMUSNAHAN where id='$id'");
			$result1 = $con1->query("update STOK set s_out=s_out-$qty, saldo=saldo+$qty, lastname='$username', lastdate='$entrydate' where branch='$branch' and kode='$kode'");		
			$result2 = $con2->query("Delete from HISTORY where branch='$branch' and transaksi='DESTRUCTION' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");		
			
			header("location: ../destroy.php?tanggal=$tanggal&faktur=$faktur");
		}
	}else{
		$tanggal=$_GET["tanggal"];
		$faktur=$_GET["faktur"];
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../destroy.php?tanggal=$tanggal&faktur=$faktur");
	}
}else{
	$tanggal=$_GET["tanggal"];
	$faktur=$_GET["faktur"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../destroy.php?tanggal=$tanggal&faktur=$faktur");
}
?>
<?php
session_start();
include("fc_config.php");
if(!empty($_GET["id"])){

	$id=$_GET["id"];
	$user=$_GET["username"];	
	$tanggal=$_GET["tanggal"];
	$tgl=date('Y-m-d',strtotime($tanggal));
	
	$fullname=$_SESSION["iss21"]["fullname"];
	$date=date("Y-m-d")." ".date("H:i:s");
	
	$result = $con->query("Select * from OUTGOING where id='$id' and status='OPEN'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$branch=$row["branch"];
			$tanggal=$row["tanggal"];
			$tgl=date('Y-m-d',strtotime($tanggal));
			$tgl_prod=$tgl." ".date("H:i:s");
	
			$keterangan=$row["keterangan"];
			$kode=$row["kode"];
			$jenis=$row["jenis"];	
			$barang=$row["barang"];
			$satuan=$row["satuan"];
			$qty=$row["qty"];	
			
			$result = $con->query("Insert Into PENGELUARAN (branch, requestby, requestdate, keterangan, jenis, barang, satuan, kode, qty, username, entrydate)
									Select branch, username, entrydate, keterangan, jenis, barang, satuan, kode, qty, '$fullname', '$date' From OUTGOING where id='$id'");
			$result = $con->query("delete from OUTGOING where id='$id'");
			$result2 = $con2->query("Insert into HISTORY (branch, username, transdate, transcd, transaksi, tanggal_faktur, jenis, barang, satuan, kode, qty) 
			values ('$branch', '$fullname', '$date', 'E', 'Approval Pengeluaran ($keterangan)', '$tgl_prod', '$jenis','$barang','$satuan','$kode','$qty')");	
			
			header("location: ../pengeluaran.php?tanggal=$tgl&username=$user");
		}
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../pengeluaran.php?tanggal=$tgl&username=$user");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../pengeluaran.php?tanggal=$tgl&username=$user");
}
?>
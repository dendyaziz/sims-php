<?php
session_start();
include("fc_config.php");
if(!empty($_GET["id"])){	

	$id=$_GET["id"];
	$user=$_GET["username"];
	$username=$_SESSION["iss21"]["fullname"];
	$date=date("Y-m-d")." ".date("H:i:s");
	$tanggal=$_GET["tanggal"];
	$tgl=date('Y-m-d',strtotime($tanggal));
	
	$result = $con->query("Select * from OUTGOING where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$branch=$row["branch"];
			$tanggal=$row["tanggal"];
			$tgl=date('Y-m-d',strtotime($tanggal));
			$tgl_prod=$tgl." ".date("H:i:s");
			$keterangan=$row["keterangan"];
			
			$jenis=$row["jenis"];	
			$barang=$row["barang"];
			$satuan=($row["satuan"]);
			$kode=($row["kode"]);
			$qty=$row["qty"];	
			
			$result = $con->query("Delete From OUTGOING where id='$id'");
			$result1 = $con1->query("update STOK set s_out=s_out-$qty, saldo=saldo+$qty, lastname='$username', lastdate='$date' where branch='$branch' and jenis='$jenis' and barang='$barang' and satuan='$satuan' and kode='$kode'");		
			$result2 = $con2->query("Insert into HISTORY (branch, username, transdate, transcd, transaksi, tanggal_faktur, jenis, barang, satuan, kode, qty) values ('$branch', '$username', '$date', 'D', 'Hapus Outgoing', '$tgl_prod', '$jenis','$barang','$satuan','$kode','$qty')");	
			
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
<?php
session_start();
include("fc_config.php");
if(!empty($_GET["id"])){	

	$id=$_GET["id"];
	$username=$_SESSION["iss21"]["fullname"];
	$date=date("Y-m-d")." ".date("H:i:s");
	$tanggal=$_GET["tanggal"];
	$tgl=date('Y-m-d',strtotime($tanggal));
	
	$result = $con->query("Select * from PEMBELIAN where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$branch=$row["branch"];
			$tanggal=$row["tanggal"];
			$tgl=date('Y-m-d',strtotime($tanggal));
			$tgl_prod=$tgl." ".date("H:i:s");
			$faktur=$row["faktur"];			
			$supplier=$row["supplier"];
			$alamat_supplier=$row["alamat_supplier"];
			$telepon_supplier=$row["telepon_supplier"];
			$person_supplier=$row["person_supplier"];
			$kode_supplier=$row["kode_supplier"];
			
			$jenis=$row["jenis"];	
			$barang=$row["barang"];
			$barang=str_replace("'","''",$barang);
			$satuan=($row["satuan"]);
			$kode=($row["kode"]);
			$qty=$row["qty"];	
			$s_in=$qty;
			
			$result = $con->query("Delete From PEMBELIAN where id='$id'");
			$result1 = $con1->query("update STOK set s_in=s_in-$s_in, saldo=saldo-$s_in, lastname='$username', lastdate='$date' where branch='$branch' and jenis='$jenis' and barang='$barang' and satuan='$satuan' and kode='$kode'");		
			$result2 = $con2->query("Delete from HISTORY where convert(transdate,DATE)='$tgl' and transcd='A' and branch='$branch' and faktur='$faktur' and jenis='$jenis' and barang='$barang' and satuan='$satuan' and kode='$kode'");	
			
			header("location: ../incoming-edit.php?tanggal=$tgl&faktur=$faktur&supplier=$supplier");
		}
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../incoming-edit.php?tanggal=$tgl&faktur=$faktur&supplier=$supplier");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../incoming-edit.php?tanggal=$tgl&faktur=$faktur&supplier=$supplier");
}
?>
<?php
session_start();
include("fc_config.php");
if(!empty($_GET["id"])){	

	$id=$_GET["id"];
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
			$tgl_trans=$tgl." ".date("H:i:s");

			$faktur=$row["faktur"];
			$customer=$row["customer"];
			$alamat=$row["alamat"];
			$telepon=$row["telepon"];
			$person=$row["person"];
			$kode_customer=$row["kode_customer"];
			
			$kode=($row["kode"]);
			$jenis=$row["jenis"];	
			$barang=$row["barang"];
			$barang=str_replace("'","''",$barang);
			$satuan=($row["satuan"]);			
			$qty=$row["qty"];	
			
			$result = $con->query("Delete From OUTGOING where id='$id'");
			$result1 = $con1->query("update STOK set s_out=s_out-$qty, saldo=saldo+$qty, lastname='$username', lastdate='$date' where branch='$branch' and jenis='$jenis' and barang='$barang' and satuan='$satuan' and kode='$kode'");		
			$result2 = $con2->query("Delete from HISTORY where convert(transdate,DATE)='$tgl' and transcd='B' and branch='$branch' and faktur='$faktur' and jenis='$jenis' and barang='$barang' and satuan='$satuan' and kode='$kode'");		
			
			header("location: ../outgoing-edit.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer");
		}
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../outgoing-edit.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../outgoing-edit.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer");
}
?>
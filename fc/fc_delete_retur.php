<?php
session_start();
include("fc_config.php");
if(!empty($_GET["id"])){	

	$id=$_GET["id"];
	$username=$_SESSION["iss21"]["fullname"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	$tanggal=$_GET["tanggal"];
	$tanggal=date('Y-m-d',strtotime($tanggal));
	
	$result = $con->query("Select * from RETUR where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$branch=$row["branch"];
			$tanggal=$row["tanggal"];
			$transdate=$tanggal." ".date("H:i:s");

			$faktur=$row["faktur"];
			$nik=$row["nik"];
			$fullname=$row["fullname"];
			$address=$row["address"];
			$phone=$row["phone"];
			$position=$row["position"];
			$dept=$row["dept"];
			
			$kode=($row["kode"]);
			$barang=$row["barang"];
			$barang=str_replace("'","''",$barang);
			$jenis=$row["jenis"];
			$satuan=($row["satuan"]);			
			$qty=$row["qty"];	
			
			$result = $con->query("Delete From RETUR where id='$id'");
			$result1 = $con1->query("update STOK set s_in=s_in-$qty, saldo=saldo-$qty, lastname='$username', lastdate='$entrydate' where branch='$branch' and kode='$kode'");		
			$result2 = $con2->query("Delete from HISTORY where branch='$branch' and transaksi='RETURN' and tanggal='$tanggal' and faktur='$faktur' and kode='$kode'");		
			
			header("location: ../retur.php?tanggal=$tanggal&faktur=$faktur&nik=$nik");
		}
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../retur.php?tanggal=$tanggal&faktur=$faktur&nik=$nik");
	}
}else{
	$tanggal=$_GET["tanggal"];
	$faktur=$_GET["faktur"];
	$nik=$_GET["nik"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../retur.php?tanggal=$tanggal&faktur=$faktur&nik=$nik");
}
?>
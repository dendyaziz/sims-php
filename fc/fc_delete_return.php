<?php
session_start();
include("fc_config.php");
if(!empty($_GET["id"])){	
	
	$username=$_SESSION["iss21"]["fullname"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$id=$_GET["id"];	
	$tanggal=$_GET["tanggal"];	
	$result = $con->query("Select * from RETUR where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$branch=$row["branch"];
			$tanggal=$row["tanggal"];
			$faktur=$row["faktur"];
			$customer=$row["customer"];
			$address=$row["address"];
			$phone=$row["phone"];
			$contact=$row["contact"];
			$kode_customer=$row["kode_customer"];
			
			$userid=$row["userid"];
			$salesman=$row["salesman"];
			
			$kode=($row["kode"]);
			$jenis=$row["jenis"];	
			$barang=$row["barang"];
			$satuan=($row["satuan"]);
			$qty=$row["qty"];	
			
			$result = $con->query("Delete From RETUR where id='$id'");
			$result1 = $con1->query("update STOK set s_out=s_out+$qty, saldo=saldo-$qty, lastname='$username', lastdate='$entrydate' where branch='$branch' and kode='$kode'");		
			$result2 = $con2->query("Delete from HISTORY where branch='$branch' and transaksi='RETUR' and tanggal='$tanggal' and faktur='$faktur' and salesman='$salesman' and kode='$kode'");		
			
			header("location: ../return.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&userid=$userid");
		}
	}else{
		$kode_customer=$_GET["kode_customer"];
		$userid=$_GET["userid"];
		$tanggal=$_GET["tanggal"];
		$faktur=$_GET["faktur"];
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../return.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&userid=$userid");
	}
}else{
	$kode_customer=$_GET["kode_customer"];
	$userid=$_GET["userid"];
	$tanggal=$_GET["tanggal"];
	$faktur=$_GET["faktur"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../return.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&userid=$userid");
}
?>
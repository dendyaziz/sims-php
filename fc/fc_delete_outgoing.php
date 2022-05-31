<?php
session_start();
include("fc_config.php");
if(!empty($_GET["id"])){	
	
	$username=$_SESSION["iss21"]["fullname"];
	$entrydate=date("Y-m-d")." ".date("H:i:s");
	
	$id=$_GET["id"];	
	$tanggal=$_GET["tanggal"];	
	$result = $con->query("Select * from OUTGOING where id='$id'");
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
			
			$po=$row["po"];
			$tglpo=$row["tglpo"];
			
			$kode=($row["kode"]);
			$jenis=$row["jenis"];	
			$barang=$row["barang"];
			$satuan=($row["satuan"]);
			$qty=$row["qty"];	
			$tipe_outgoing=$row["tipe_outgoing"];	
			
			$result = $con->query("Delete From OUTGOING where id='$id'");
			$result1 = $con1->query("update STOK set s_out=s_out-$qty, saldo=saldo+$qty, lastname='$username', lastdate='$entrydate' where branch='$branch' and kode='$kode'");		
			$result2 = $con2->query("Delete from HISTORY where branch='$branch' and transaksi='OUTGOING' and tanggal='$tanggal' and faktur='$faktur' and salesman='$salesman' and kode='$kode'");		
			
			header("location: ../outgoing.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&ongkir=$ongkir&biaya_lainnya=$biaya_lainnya&po=$po&tglpo=$tglpo&tgltempo=$tgltempo&tipe_outgoing=$tipe_outgoing");
		}
	}else{
		$kode_customer=$_GET["kode_customer"];
		$userid=$_GET["userid"];
		$po=$_GET["po"];
		$tglpo=$_GET["tglpo"];
		$tipe_outgoing=$_GET["tipe_outgoing"];
		$tanggal=$_GET["tanggal"];
		$faktur=$_GET["faktur"];
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../outgoing.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&ongkir=$ongkir&biaya_lainnya=$biaya_lainnya&po=$po&tglpo=$tglpo&tgltempo=$tgltempo&tipe_outgoing=$tipe_outgoing");
	}
}else{
	$kode_customer=$_GET["kode_customer"];
	$userid=$_GET["userid"];
	$po=$_GET["po"];
	$tglpo=$_GET["tglpo"];
	$tipe_outgoing=$_GET["tipe_outgoing"];
	$tanggal=$_GET["tanggal"];
	$faktur=$_GET["faktur"];
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../outgoing.php?tanggal=$tanggal&faktur=$faktur&kode_customer=$kode_customer&ongkir=$ongkir&biaya_lainnya=$biaya_lainnya&po=$po&tglpo=$tglpo&tgltempo=$tgltempo&tipe_outgoing=$tipe_outgoing");
}
?>
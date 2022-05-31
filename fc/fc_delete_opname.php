<?php
session_start();
include("fc_config.php");
if(!empty($_GET["id"])){	

	$id=$_GET["id"];
	$username=$_SESSION["iss21"]["fullname"];
	$date=date("Y-m-d")." ".date("H:i:s");
	$tanggal=$_GET["tanggal"];
	$tgl=date('Y-m-d',strtotime($tanggal));
	
	$result = $con->query("Select * from OPNAME where id='$id'");
	$count = mysqli_num_rows($result);
	if($count>0){
		while($row = mysqli_fetch_assoc($result))
		{
			$branch=$row["branch"];
			$tanggal=$row["tanggal"];
			$tgl=date('Y-m-d',strtotime($tanggal));
			$tgl_trans=$tgl." ".date("H:i:s");
		
			$faktur=($row["faktur"]);
			$kode=($row["kode"]);
			$jenis=$row["jenis"];
			$subgroup=($row["subgroup"]);
			$merk=($row["merk"]);
			$barang=$row["barang"];
			$barang=str_replace("'","''",$barang);
			$satuan=($row["satuan"]);			
			$stok=$row["stok"];
			$qty=$row["qty"];
			$harga=$row["harga"];
			$keterangan=$row["keterangan"];
			$selisih=$qty-$stok;
			
			$result = $con->query("Delete From OPNAME where id='$id'");
			if($selisih>0){
				$result1 = $con1->query("update STOK set s_in=s_in-$selisih, saldo=saldo-$selisih, lastname='$username', lastdate='$date' where branch='$branch' and kode='$kode'");		
			}else{
				$result1 = $con1->query("update STOK set s_in=s_in-$selisih, saldo=saldo-$selisih, lastname='$username', lastdate='$date' where branch='$branch' and kode='$kode'");		
			}
			
			$result2 = $con2->query("Delete from HISTORY where convert(transdate,DATE)='$tgl' and transcd='D' and branch='$branch' and faktur='$faktur' and kode='$kode'");		
			
			header("location: ../opname.php?tanggal=$tanggal&faktur=$faktur");
		}
	}else{
		$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
		header("location: ../opname.php?tanggal=$tanggal&faktur=$faktur");
	}
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../opname.php?tanggal=$tanggal&faktur=$faktur");
}
?>
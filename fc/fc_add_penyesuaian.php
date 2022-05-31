<?php
session_start();
include("fc_config.php");
if(!empty($_POST["branch"]) &&!empty($_POST["tanggal"]) && !empty($_POST["alasan"]) && !empty($_POST["jenis"]) && !empty($_POST["barang"]) && !empty($_POST["sesuai_panjang"]) && !empty($_POST["jumlah"]) && !empty($_POST["penyesuaian"])){	
	
	$branch=$_POST["branch"];
	$tanggal=$_POST["tanggal"];	
	$tgl=date('Y-m-d',strtotime($tanggal));
	$tgl_faktur=$tgl." ".date("H:i:s");
	
	if(empty($_POST["faktur"])){		
		$result = $con->query("Select faktur from TBLPENYESUAIAN where left(faktur,3)='D".right(date("Y"),2)."' order by faktur desc limit 1");
		$count = mysqli_num_rows($result);
		if($count>0){
			while($row = mysqli_fetch_assoc($result))
			{
				$faktur="D".(str_replace("D","",$row["faktur"])+1);
			}
		}else{
			$faktur="D".right(date("Y"),2)."000000001";
		}
	}else{
		$faktur=$_POST["faktur"];
	}
	$_SESSION["iss21"]["faktur"]=$faktur;
	
	$alasan=$_POST["alasan"];
	
	$jenis=$_POST["jenis"];
	$barang=$_POST["barang"];
	$panjang=$_POST["panjang"];
	$lebar=$_POST["lebar"];
	if(empty($lebar)){
		$lebar="0";
	}
	$penyesuaian=$_POST["penyesuaian"];
	
	$sesuai_panjang=$_POST["sesuai_panjang"];
	$sesuai_lebar=$_POST["sesuai_lebar"];
	if(empty($sesuai_lebar)){
		$sesuai_lebar="0";
	}
	$jumlah=$_POST["jumlah"];
	
	$username=$_POST["username"];
	$date=date("Y-m-d")." ".date("H:i:s");	
	
	$result = $con->query("Insert Into PENYESUAIAN (branch, tanggal, faktur, alasan, jenis, barang, panjang, lebar, penyesuaian, sesuai_panjang, sesuai_lebar, jumlah, username, entrydate) values ('$branch','$tgl_faktur','$faktur','$alasan', '$jenis', '$barang', '$panjang', '$lebar', '$penyesuaian', '$sesuai_panjang', $sesuai_lebar, '$jumlah', '$username', '$date')");
	
	$result = $con->query("Select * from STOK Where branch='$branch' and  jenis='$jenis' and barang='$barang'");
	$count = mysqli_num_rows($result);
	
	if(strtolower($penyesuaian)=="penambahan stok"){
		$s_in=$jumlah;
		if($count>0){		
			$result1 = $con1->query("update STOK set s_in=s_in+$s_in, saldo=saldo+$s_in, lastname='$username', lastdate='$date' where branch='$branch' and jenis='$jenis' and barang='$barang'");		
		}else{		
			$result1 = $con1->query("Insert into STOK (branch, jenis, barang, panjang, lebar, s_in, s_out, saldo, username, entrydate) values ('$branch', '$jenis','$barang','$panjang','$lebar','$s_in','0','$s_in','$username','$date')");		
		}	
		$result2 = $con2->query("Insert into HISTORY (branch, faktur, tanggal, transcd, jenis, barang, panjang, lebar, s_in, username, entrydate) 
		values ('$branch', '$faktur', '$tgl_faktur', 'E', '$jenis','$barang','$panjang','$lebar','$s_in','$username','$date')");
	}else{
		$s_out=$jumlah;
		if($count>0){		
			$result1 = $con1->query("update STOK set s_out=s_out+$s_out, saldo=saldo-$s_out, lastname='$username', lastdate='$date' where branch='$branch' and jenis='$jenis' and barang='$barang'");		
		}else{		
			$result1 = $con1->query("Insert into STOK (branch, jenis, barang, panjang, lebar, s_in, s_out, saldo, username, entrydate) values ('$branch', '$jenis','$barang','$panjang','$lebar','0','$s_out','-$s_out','$username','$date')");		
		}	
		$result2 = $con2->query("Insert into HISTORY (branch, faktur, tanggal, transcd, jenis, barang, panjang, lebar, s_out, username, entrydate) 
		values ('$branch', '$faktur', '$tgl_faktur', 'F', '$jenis','$barang','$panjang','$lebar','$s_out','$username','$date')");
	}	
	
	header("location: ../penyesuaian.php?tanggal=$tanggal&faktur=$faktur&alasan=$alasan");
	
}else{
	$_SESSION["iss21"]["info"]="Gagal, hai sepertinya ada sesuatu yang salah nih, mohon ulangi kembali nanti.";
	header("location: ../penyesuaian.php?tanggal=$tanggal&faktur=$faktur&alasan=$alasan");
}
?>